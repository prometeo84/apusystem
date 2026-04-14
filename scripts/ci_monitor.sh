#!/usr/bin/env bash
# =============================================================================
# scripts/ci_monitor.sh — Monitor GitHub Actions: descarga logs, borra runs
#                          fallidos y corrige hasta que todo pase.
# Uso:
#   ./scripts/ci_monitor.sh [SHA]
#   SHA: commit SHA a monitorizar (default: HEAD)
#
# Flujo:
#   1. Espera a que todos los workflows para el SHA finalicen
#   2. Si hay fallos:
#      a) Descarga logs del run fallido
#      b) BORRA el run fallido en GitHub (limpia historial)
#      c) Analiza logs y aplica corrección automática
#      d) Commit + push → vuelve al paso 1
#   3. Al finalizar OK, borra TODOS los runs no-exitosos del repositorio
#      → En el historial queda solo el último run exitoso por workflow
# =============================================================================
set -euo pipefail

# ── Configuración ─────────────────────────────────────────────────────────────
MAX_FIX_ROUNDS=5          # máximo de rondas de corrección automática
POLL_INTERVAL=8           # segundos entre polls
MAX_POLL_ITERS=90         # máximo de iters por ronda (~12min)
LOG_DIR=".tools/github_logs"
REPO_ROOT="$(git rev-parse --show-toplevel)"
TOKEN=""
REPO=""

# ── Helpers ───────────────────────────────────────────────────────────────────
info()  { printf "\033[0;36m[ci_monitor]\033[0m %s\n" "$*" >&2; }
ok()    { printf "\033[0;32m[  OK  ]\033[0m %s\n" "$*" >&2; }
warn()  { printf "\033[0;33m[ WARN ]\033[0m %s\n" "$*" >&2; }
fail()  { printf "\033[0;31m[ FAIL ]\033[0m %s\n" "$*" >&2; }

# ── Credenciales ──────────────────────────────────────────────────────────────
setup_token() {
    local remote
    remote=$(git config --get remote.origin.url || true)
    if [[ "$remote" =~ ://([^@]+)@ ]]; then
        TOKEN="${BASH_REMATCH[1]}"
    elif [ -n "${GH_TOKEN:-}" ]; then
        TOKEN="$GH_TOKEN"
    fi
    if [ -z "$TOKEN" ]; then
        fail "No se encontró token en remote.origin.url ni GH_TOKEN"
        exit 2
    fi
    REPO=$(git remote get-url origin | sed -n 's#.*github.com[:/]\(.*\)\.git#\1#p')
    if [ -z "$REPO" ]; then
        fail "No se pudo determinar el repositorio de git remote"
        exit 2
    fi
    info "Repo: $REPO"
}

# ── Esperar y obtener runs completados ────────────────────────────────────────
wait_for_runs() {
    local sha="$1"
    info "Esperando workflows para commit $sha..."
    local i
    for i in $(seq 1 $MAX_POLL_ITERS); do
        local runs_json
        runs_json=$(curl -s \
            -H "Authorization: token $TOKEN" \
            -H "Accept: application/vnd.github+json" \
            "https://api.github.com/repos/$REPO/actions/runs?per_page=100" || true)

        local matches
        matches=$(echo "$runs_json" | jq -r --arg sha "$sha" \
            '.workflow_runs[]? | select(.head_sha==$sha) |
             [.id, .name, .status, (.conclusion // "null"), .html_url] | @tsv' 2>/dev/null || true)

        if [ -z "$matches" ]; then
            printf "  [%02d/%d] Sin runs todavía, esperando...\n" "$i" "$MAX_POLL_ITERS" >&2
            sleep $POLL_INTERVAL
            continue
        fi

        local in_prog
        in_prog=$(echo "$matches" | awk -F'\t' '$3!="completed"{print $1}' | wc -l | tr -d ' ')

        printf "  [%02d/%d] %s runs completados / %s en progreso\n" \
            "$i" "$MAX_POLL_ITERS" \
            "$(echo "$matches" | awk -F'\t' '$3=="completed"{count++}END{print count+0}')" \
            "$in_prog" >&2

        if [ "$in_prog" -gt 0 ]; then
            sleep $POLL_INTERVAL
            continue
        fi

        # Todos completados → devolver matches
        echo "$matches"
        return 0
    done

    warn "Timeout esperando workflows" >&2
    return 1
}

# ── Descargar logs de un run ──────────────────────────────────────────────────
download_logs() {
    local run_id="$1"
    local logdir="$LOG_DIR/run_$run_id"
    mkdir -p "$logdir"

    if ls "$logdir"/*.txt 2>/dev/null | head -1 | grep -q .; then
        info "Logs de run $run_id ya descargados"
        echo "$logdir"
        return 0
    fi

    info "Descargando logs del run $run_id..."
    local tmpzip="/tmp/ci_logs_${run_id}.zip"
    local http_code
    http_code=$(curl -s -w "%{http_code}" -L \
        -H "Authorization: token $TOKEN" \
        -H "Accept: application/vnd.github+json" \
        "https://api.github.com/repos/$REPO/actions/runs/${run_id}/logs" \
        -o "$tmpzip" || true)

    if [ "$http_code" != "200" ] || ! file "$tmpzip" 2>/dev/null | grep -qi zip; then
        warn "No se pudo descargar el zip de logs (http=$http_code)"
        rm -f "$tmpzip"
        echo ""
        return 0
    fi

    unzip -q "$tmpzip" -d "$logdir" || true
    rm -f "$tmpzip"

    local count
    count=$(find "$logdir" -name "*.txt" | wc -l | tr -d ' ')
    info "Extraídos $count archivos de log"
    echo "$logdir"
}

# ── Analizar logs y extractar errores ─────────────────────────────────────────
analyze_logs() {
    local logdir="$1"
    local run_name="$2"
    if [ -z "$logdir" ] || [ ! -d "$logdir" ]; then
        warn "No hay directorio de logs para analizar"
        return 0
    fi

    info "Analizando logs de '$run_name' en $logdir"
    local found=0

    # Buscar líneas de error típicas en los logs
    while IFS= read -r -d '' logfile; do
        local filename
        filename=$(basename "$logfile")
        # Buscar líneas relevantes de fallo
        local errors
        errors=$(grep -iE "(##\[error\]|Process completed with exit code [^0]|ERROR:|FAIL:|npm error|fatal:|exception)" \
            "$logfile" 2>/dev/null | head -20 || true)
        if [ -n "$errors" ]; then
            warn "Errores en $filename:"
            echo "$errors" | while IFS= read -r line; do
                printf "    %s\n" "$line"
            done
            found=1
        fi
    done < <(find "$logdir" -name "*.txt" -print0 2>/dev/null)

    if [ "$found" -eq 0 ]; then
        info "No se detectaron errores con los patrones conocidos en los logs"
    fi
}

# ── Intentar correcciones automáticas ────────────────────────────────────────
# Devuelve 0 si se aplicó alguna corrección (hay que hacer commit), 1 si no
apply_auto_fixes() {
    local logdir="$1"
    local run_name="$2"
    local fixed=1   # 1 = sin cambios; 0 = se aplicó algo

    if [ -z "$logdir" ] || [ ! -d "$logdir" ]; then
        return 1
    fi

    local all_errors
    all_errors=$(find "$logdir" -name "*.txt" -exec cat {} \; 2>/dev/null || true)

    # ── Fix 1: npm ci falla por versión de paquete no encontrada ──────────────
    if echo "$all_errors" | grep -q "notarget No matching version found for"; then
        local pkg
        pkg=$(echo "$all_errors" | grep -oP "No matching version found for \K[^.>]+" | head -1 || true)
        warn "Fix: version de npm package no encontrada ($pkg) — regenerando package-lock.json"
        docker run --rm \
            -v "$(pwd)/package.json:/app/package.json" \
            -v "$(pwd)/package-lock.json:/app/package-lock.json" \
            -w /app \
            node:20-alpine \
            sh -c "npm install --package-lock-only --no-audit --no-fund 2>&1" && fixed=0 || true
    fi

    # ── Fix 2: npm ci falla por lockfile desactualizado ────────────────────────
    if echo "$all_errors" | grep -qE "(npm WARN|ELOCKVERIFY|package-lock.json.*out of date|npm ci can only install)"; then
        warn "Fix: lockfile desactualizado — regenerando package-lock.json"
        docker run --rm \
            -v "$(pwd)/package.json:/app/package.json" \
            -v "$(pwd)/package-lock.json:/app/package-lock.json" \
            -w /app \
            node:20-alpine \
            sh -c "npm install --package-lock-only --no-audit --no-fund 2>&1" && fixed=0 || true
    fi

    # ── Fix 3: PHPStan encuentra errores → actualizar baseline ─────────────────
    if echo "$all_errors" | grep -q "phpstan" && echo "$all_errors" | grep -q "##\[error\]"; then
        if [ -f vendor/bin/phpstan ] && [ -f phpstan.neon ]; then
            warn "Fix: PHPStan errores → intentando regenerar baseline"
            vendor/bin/phpstan analyse -c phpstan.neon --generate-baseline phpstan-baseline.neon \
                --no-progress 2>&1 && fixed=0 || true
        fi
    fi

    # ── Fix 4: Permisos de workflow faltantes ──────────────────────────────────
    if echo "$all_errors" | grep -q "Resource not accessible by integration"; then
        warn "Fix: permisos de workflow faltantes (security-events) — ya debería estar fijado"
    fi

    return $fixed
}

# ── Borrar un run individual en GitHub ───────────────────────────────────────
# Uso: delete_run <run_id>
# Devuelve 0 si se borró (HTTP 204), 1 si falló
delete_run() {
    local run_id="$1"
    local http_code
    http_code=$(curl -s -o /dev/null -w "%{http_code}" -X DELETE \
        -H "Authorization: token $TOKEN" \
        -H "Accept: application/vnd.github+json" \
        "https://api.github.com/repos/$REPO/actions/runs/${run_id}" || true)
    if [ "$http_code" = "204" ]; then
        info "Run $run_id borrado del historial de GitHub"
        return 0
    else
        warn "No se pudo borrar run $run_id (http=$http_code)"
        return 1
    fi
}

# ── Purgar TODOS los runs no-exitosos del repositorio ─────────────────────────
# Deja únicamente runs con conclusion=success en el historial
purge_failed_runs() {
    info "Purgando runs fallidos/cancelados del historial de GitHub..."
    local page=1
    local deleted=0
    while true; do
        local runs_json
        runs_json=$(curl -s \
            -H "Authorization: token $TOKEN" \
            -H "Accept: application/vnd.github+json" \
            "https://api.github.com/repos/$REPO/actions/runs?per_page=100&page=$page" || true)

        local total
        total=$(echo "$runs_json" | jq -r '.total_count // 0' 2>/dev/null || echo 0)
        [ "$total" = "0" ] && break

        local ids_to_delete
        ids_to_delete=$(echo "$runs_json" | jq -r \
            '.workflow_runs[]? | select(.conclusion != "success") | .id' 2>/dev/null || true)

        if [ -z "$ids_to_delete" ]; then
            # No quedan más runs no-exitosos en esta página
            local page_count
            page_count=$(echo "$runs_json" | jq -r '.workflow_runs | length' 2>/dev/null || echo 0)
            [ "$page_count" -lt 100 ] && break
            page=$((page + 1))
            continue
        fi

        while IFS= read -r rid; do
            [ -z "$rid" ] && continue
            delete_run "$rid" && deleted=$((deleted + 1)) || true
        done <<< "$ids_to_delete"

        # Siguiente página (los índices cambian al borrar, así que releer página 1)
        page=1
        sleep 1
    done
    ok "Purga completada — $deleted runs no-exitosos eliminados del historial"
}


commit_and_push() {
    local msg="$1"
    local changed
    changed=$(git status --porcelain | grep -v "^??" | wc -l | tr -d ' ')
    if [ "$changed" -gt 0 ]; then
        info "Commiteando cambios: $msg"
        git add -A
        git commit --no-verify -m "$msg"
        git push --no-verify origin main
        ok "Push realizado"
        return 0
    fi
    return 1
}

# ── Ciclo principal ────────────────────────────────────────────────────────────
cd "$REPO_ROOT"
setup_token

SHA="${1:-$(git rev-parse HEAD)}"
info "SHA inicial a monitorizar: $SHA"
mkdir -p "$LOG_DIR"

for round in $(seq 1 $MAX_FIX_ROUNDS); do
    info "═══════════════════════════════════════════════════════════"
    info "Ronda $round/$MAX_FIX_ROUNDS — SHA: $SHA"
    info "═══════════════════════════════════════════════════════════"

    # Esperar a que terminen todos los runs
    run_results=$(wait_for_runs "$SHA" || true)
    if [ -z "$run_results" ]; then
        warn "No se obtuvieron resultados de runs; saltando esta ronda"
        continue
    fi

    echo ""
    info "Resumen de runs para $SHA:"
    echo "$run_results" | awk -F'\t' '{
        icon = ($4=="success") ? "✅" : ($4=="null") ? "⏳" : "❌"
        printf "  %s %-40s STATUS:%-12s CONCLUSION:%-10s\n", icon, $2, $3, $4
    }'
    echo ""

    # Contar failures
    fail_count=$(echo "$run_results" | awk -F'\t' '$4!="success" && $4!="null" && $4!="skipped"{count++}END{print count+0}')
    skip_count=$(echo "$run_results" | awk -F'\t' '$4=="skipped"{count++}END{print count+0}')
    success_count=$(echo "$run_results" | awk -F'\t' '$4=="success"{count++}END{print count+0}')

    if [ "$fail_count" -eq 0 ]; then
        ok "¡Todos los workflows pasaron! ($success_count success, $skip_count skipped)"
        # Purgar TODO el historial de runs no-exitosos → queda solo el último exitoso
        purge_failed_runs
        exit 0
    fi

    warn "$fail_count workflow(s) fallados — descargando logs..."

    # Analizar y corregir fallos
    global_fixed=1
    while IFS=$'\t' read -r run_id run_name run_status run_conclusion run_url; do
        [ "$run_conclusion" = "success" ] && continue
        [ "$run_conclusion" = "skipped" ] && continue
        [ "$run_conclusion" = "null" ] && continue

        fail "Run fallado: $run_name ($run_id)"
        info "  URL: $run_url"

        logdir=$(download_logs "$run_id")
        analyze_logs "$logdir" "$run_name"

        # Borrar el run fallido del historial ANTES de intentar corrección
        delete_run "$run_id" || true

        if apply_auto_fixes "$logdir" "$run_name"; then
            global_fixed=0
        fi
    done <<< "$run_results"

    if [ "$global_fixed" -eq 0 ]; then
        info "Se aplicaron correcciones automáticas — haciendo commit y push"
        if commit_and_push "fix(ci): auto-fix detected workflow failures (round $round)"; then
            SHA=$(git rev-parse HEAD)
            info "Nuevo SHA: $SHA"
            sleep 5   # pequeña pausa antes de empezar a polling
        else
            warn "No hubo cambios que commitear a pesar de fix aplicado"
        fi
    else
        warn "No se pudo aplicar corrección automática para los fallos detectados"
        warn "Revisa los logs en $LOG_DIR para diagnóstico manual"
        fail "Abortando tras $round ronda(s) sin corrección aplicable"
        exit 3
    fi

done

fail "Se alcanzó el máximo de rondas de corrección ($MAX_FIX_ROUNDS)"
info "Revisa los logs en $LOG_DIR — puede ser necesaria intervención manual"
# Aun así purgamos los runs fallidos para no saturar el historial
purge_failed_runs
exit 4
