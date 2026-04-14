#!/usr/bin/env bash
# =============================================================
#  run-heavy-linters.sh  –  APU System
#  Linters pesados ejecutados LOCALMENTE (sin contenedores).
#
#  Uso:
#    scripts/run-heavy-linters.sh          # analiza todo src/
#    scripts/run-heavy-linters.sh --quick  # solo archivos en la rama actual vs main
#
#  Salida:
#    0  –  todo OK (o solo advertencias)
#    1  –  al menos un linter critico fallo
# =============================================================
set -uo pipefail
IFS=$'\n\t'

RED='\033[0;31m'
YELLOW='\033[1;33m'
GREEN='\033[0;32m'
CYAN='\033[0;36m'
BOLD='\033[1m'
NC='\033[0m'

GIT_ROOT=$(git rev-parse --show-toplevel 2>/dev/null || pwd)
cd "$GIT_ROOT"

QUICK=0
[[ "${1:-}" == "--quick" ]] && QUICK=1

CRITICAL=0   # linters cuyo fallo puede tener impacto de seguridad/bloqueo CI
WARNINGS=0

# ── Helpers ──────────────────────────────────────────────────
pass()  { echo -e "${GREEN}  ok  $*${NC}"; }
warn()  { echo -e "${YELLOW}  !!  $*${NC}"; WARNINGS=$((WARNINGS+1)); }
fail()  { echo -e "${RED}  x   $*${NC}"; CRITICAL=$((CRITICAL+1)); }
sep()   { echo -e "${BOLD}----------------------------------------------------------${NC}"; }

echo ""
echo -e "${BOLD}============================================================${NC}"
echo -e "${BOLD}  run-heavy-linters.sh  –  APU System${NC}"
echo -e "${BOLD}  Modo: $([ "$QUICK" -eq 1 ] && echo 'quick (rama actual vs main)' || echo 'completo (src/)')${NC}"
echo -e "${BOLD}============================================================${NC}"
echo ""

# ── Selección de archivos ─────────────────────────────────────
if [ "$QUICK" -eq 1 ]; then
    BASE_BRANCH=$(git merge-base HEAD "$(git remote show origin 2>/dev/null | grep 'HEAD branch' | awk '{print $NF}' || echo main)" 2>/dev/null || true)
    if [ -n "$BASE_BRANCH" ]; then
        CHANGED_PHP=$(git diff --name-only "$BASE_BRANCH"...HEAD -- '*.php' 2>/dev/null | grep '^src/' || true)
    else
        CHANGED_PHP=$(git diff --name-only HEAD~1 HEAD -- '*.php' 2>/dev/null | grep '^src/' || true)
    fi
    PHPSTAN_SCOPE=""
    if [ -n "$CHANGED_PHP" ]; then
        while IFS= read -r f; do
            [ -f "$GIT_ROOT/$f" ] && PHPSTAN_SCOPE="$PHPSTAN_SCOPE $GIT_ROOT/$f"
        done <<< "$CHANGED_PHP"
        PHPSTAN_SCOPE="${PHPSTAN_SCOPE# }"
    fi
else
    PHPSTAN_SCOPE=""   # usa la config phpstan.neon (paths: [src])
fi

# ─────────────────────────────────────────────────────────────
sep
echo -e "${CYAN}[1/4] PHPStan – análisis estático (nivel 5)${NC}"
sep

PHPSTAN_BIN="$GIT_ROOT/vendor/bin/phpstan"
if [ -f "$PHPSTAN_BIN" ]; then
    CFG=""
    [ -f "$GIT_ROOT/phpstan.neon" ] && CFG="--configuration=$GIT_ROOT/phpstan.neon"

    if [ -n "$PHPSTAN_SCOPE" ]; then
        echo "  Analizando: $(echo "$PHPSTAN_SCOPE" | wc -w | tr -d ' ') archivo(s) en rama"
        result=$("$PHPSTAN_BIN" analyse --level=5 --no-progress $CFG $PHPSTAN_SCOPE 2>&1) || true
    else
        echo "  Analizando: src/ (completo)"
        result=$("$PHPSTAN_BIN" analyse --no-progress $CFG 2>&1) || true
    fi

    if echo "$result" | grep -qE '^\[ERROR\]|No errors'; then
        if echo "$result" | grep -q 'No errors'; then
            pass "PHPStan: sin errores"
        else
            fail "PHPStan: errores encontrados"
            echo "$result" | grep -v '^$' | sed 's/^/      /'
        fi
    elif echo "$result" | grep -qE '^Found [0-9]+ error'; then
        fail "PHPStan encontró errores:"
        echo "$result" | sed 's/^/      /'
    else
        pass "PHPStan: sin errores"
    fi
else
    warn "PHPStan no encontrado en vendor/bin – omitido"
fi
echo ""

# ─────────────────────────────────────────────────────────────
sep
echo -e "${CYAN}[2/4] Composer Audit – vulnerabilidades en dependencias${NC}"
sep

COMPOSER_BIN=$(command -v composer 2>/dev/null || true)
if [ -n "$COMPOSER_BIN" ]; then
    result=$("$COMPOSER_BIN" audit --no-interaction --format=plain 2>&1) || AUDIT_EXIT=$?
    AUDIT_EXIT=${AUDIT_EXIT:-0}
    if [ "$AUDIT_EXIT" -ne 0 ]; then
        fail "Composer audit: vulnerabilidades encontradas"
        echo "$result" | head -40 | sed 's/^/      /'
    else
        pass "Composer audit: sin vulnerabilidades conocidas"
    fi
else
    warn "composer no disponible – omitido"
fi
echo ""

# ─────────────────────────────────────────────────────────────
sep
echo -e "${CYAN}[3/4] Snyk – escaneo de dependencias y código${NC}"
sep

SNYK_BIN=$(command -v snyk 2>/dev/null || true)
if [ -n "$SNYK_BIN" ]; then
    SNYK_TOKEN=$("$SNYK_BIN" config get api 2>/dev/null | grep -v '^undefined$' | grep -v '^$' || true)
    if [ -n "$SNYK_TOKEN" ]; then
        result=$("$SNYK_BIN" test "$GIT_ROOT" --severity-threshold=high 2>&1) || SNYK_EXIT=$?
        SNYK_EXIT=${SNYK_EXIT:-0}
        if [ "$SNYK_EXIT" -ne 0 ]; then
            fail "Snyk: vulnerabilidades HIGH/CRITICAL detectadas"
            echo "$result" | head -40 | sed 's/^/      /'
        else
            pass "Snyk: sin vulnerabilidades HIGH/CRITICAL"
        fi
    else
        warn "Snyk instalado pero no autenticado – omitido (ejecuta: snyk auth)"
    fi
else
    warn "Snyk no instalado – omitido (npm install -g snyk)"
fi
echo ""

# ─────────────────────────────────────────────────────────────
sep
echo -e "${CYAN}[4/4] ESLint + Stylelint – assets/JS y CSS${NC}"
sep

ESLINT_BIN="$GIT_ROOT/node_modules/.bin/eslint"
[ -f "$ESLINT_BIN" ] || ESLINT_BIN=$(command -v eslint 2>/dev/null || true)

STYLELINT_BIN="$GIT_ROOT/node_modules/.bin/stylelint"
[ -f "$STYLELINT_BIN" ] || STYLELINT_BIN=$(command -v stylelint 2>/dev/null || true)

if [ -n "$ESLINT_BIN" ] && [ -f "$ESLINT_BIN" ]; then
    result=$("$ESLINT_BIN" "$GIT_ROOT/assets/" 2>&1) || ESLINT_EXIT=$?
    ESLINT_EXIT=${ESLINT_EXIT:-0}
    if [ "$ESLINT_EXIT" -eq 0 ]; then
        pass "ESLint: sin errores"
    elif [ "$ESLINT_EXIT" -eq 1 ]; then
        warn "ESLint: advertencias/errores de estilo"
        echo "$result" | head -30 | sed 's/^/      /'
    else
        warn "ESLint: salida inesperada ($ESLINT_EXIT) – revisión manual recomendada"
    fi
else
    warn "ESLint no encontrado – omitido (npm install)"
fi

if [ -n "$STYLELINT_BIN" ] && [ -f "$STYLELINT_BIN" ]; then
    result=$("$STYLELINT_BIN" "$GIT_ROOT/assets/**/*.css" 2>&1) || STYLELINT_EXIT=$?
    STYLELINT_EXIT=${STYLELINT_EXIT:-0}
    if [ "$STYLELINT_EXIT" -eq 0 ]; then
        pass "Stylelint: sin errores"
    elif [ "$STYLELINT_EXIT" -eq 1 ]; then
        warn "Stylelint: problemas de estilo CSS"
        echo "$result" | head -20 | sed 's/^/      /'
    else
        warn "Stylelint: no configurado o sin archivos – omitido"
    fi
else
    warn "Stylelint no encontrado – omitido (npm install)"
fi
echo ""

# ─────────────────────────────────────────────────────────────
echo -e "${BOLD}============================================================${NC}"
if [ "$CRITICAL" -gt 0 ]; then
    echo -e "${RED}  RESULTADO: ${CRITICAL} error(es) CRITICOS  |  ${WARNINGS} advertencia(s)${NC}"
    echo -e "${RED}  Corrige los errores antes de hacer push.${NC}"
    echo -e "${BOLD}============================================================${NC}"
    echo ""
    exit 1
else
    echo -e "${GREEN}  RESULTADO: OK  |  ${WARNINGS} advertencia(s)${NC}"
    echo -e "${BOLD}============================================================${NC}"
    echo ""
    exit 0
fi
