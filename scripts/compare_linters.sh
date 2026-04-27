#!/usr/bin/env bash
set -euo pipefail

ROOT=$(cd "$(dirname "$0")/.." && pwd)
cd "$ROOT"

mkdir -p .tools

echo "Running local linters..."

# ESLint
echo "ESLint (local) -> .tools/local_eslint.json"
npx --yes eslint assets/app.js -f json -o .tools/local_eslint.json || true

# normalize paths in local eslint output
if [ -f .tools/local_eslint.json ]; then
  sed -i.bak "s|$ROOT|.|g" .tools/local_eslint.json || true
fi
# canonicalize local eslint JSON and ensure trailing newline
if [ -f .tools/local_eslint.json ] && command -v jq >/dev/null 2>&1; then
  jq -S -c '.' .tools/local_eslint.json > .tools/local_eslint.json.tmp || true
  mv .tools/local_eslint.json.tmp .tools/local_eslint.json || true
  printf '\n' >> .tools/local_eslint.json || true
fi

# Stylelint
echo "Stylelint (local) -> .tools/local_stylelint.json"
npx --yes stylelint 'assets/**/*.css' --formatter json > .tools/local_stylelint.json || true

# normalize paths in local stylelint output
if [ -f .tools/local_stylelint.json ]; then
  sed -i.bak "s|$ROOT|.|g" .tools/local_stylelint.json || true
fi
if [ -f .tools/local_stylelint.json ] && command -v jq >/dev/null 2>&1; then
  jq -S -c '.' .tools/local_stylelint.json > .tools/local_stylelint.json.tmp || true
  mv .tools/local_stylelint.json.tmp .tools/local_stylelint.json || true
  printf '\n' >> .tools/local_stylelint.json || true
fi

# PHPStan
echo "PHPStan (local) -> .tools/local_phpstan.json"
if [ -x vendor/bin/phpstan ]; then
  vendor/bin/phpstan analyse -c phpstan.neon -a stubs/php_core_functions.php --memory-limit=512M --error-format=json > .tools/local_phpstan.json || true
else
  echo "[]" > .tools/local_phpstan.json
fi

# normalize local phpstan paths and canonicalize JSON
if [ -f .tools/local_phpstan.json ]; then
  sed -i.bak "s|$ROOT|.|g" .tools/local_phpstan.json || true
  if command -v jq >/dev/null 2>&1; then
    jq -S -c '.' .tools/local_phpstan.json > .tools/local_phpstan.json.tmp || true
    mv .tools/local_phpstan.json.tmp .tools/local_phpstan.json || true
    printf '\n' >> .tools/local_phpstan.json || true
  fi
fi

echo "Running linters in Docker..."

# ESLint + Stylelint using node:20
echo "ESLint (docker) -> .tools/docker_eslint.json"
docker run --rm -v "$ROOT":/work -w /work node:20 bash -lc "npm ci --no-audit --no-fund >/dev/null 2>&1 || true; npx --yes eslint assets/app.js -f json" > .tools/docker_eslint.json || true

# normalize paths in docker eslint output
if [ -f .tools/docker_eslint.json ]; then
  sed -i.bak "s|/work|.|g" .tools/docker_eslint.json || true
fi
if [ -f .tools/docker_eslint.json ] && command -v jq >/dev/null 2>&1; then
  jq -S -c '.' .tools/docker_eslint.json > .tools/docker_eslint.json.tmp || true
  mv .tools/docker_eslint.json.tmp .tools/docker_eslint.json || true
  printf '\n' >> .tools/docker_eslint.json || true
fi

echo "Stylelint (docker) -> .tools/docker_stylelint.json"
docker run --rm -v "$ROOT":/work -w /work node:20 bash -lc "npm ci --no-audit --no-fund >/dev/null 2>&1 || true; npx --yes stylelint 'assets/**/*.css' --formatter json" > .tools/docker_stylelint.json || true

# normalize paths in docker stylelint output
if [ -f .tools/docker_stylelint.json ]; then
  sed -i.bak "s|/work|.|g" .tools/docker_stylelint.json || true
fi
if [ -f .tools/docker_stylelint.json ] && command -v jq >/dev/null 2>&1; then
  jq -S -c '.' .tools/docker_stylelint.json > .tools/docker_stylelint.json.tmp || true
  mv .tools/docker_stylelint.json.tmp .tools/docker_stylelint.json || true
  printf '\n' >> .tools/docker_stylelint.json || true
fi

# PHPStan using php:8.3-cli
echo "PHPStan (docker) -> .tools/docker_phpstan.json"
docker run --rm -v "$ROOT":/work -w /work php:8.3-cli bash -lc '
 set -e
 apt-get update >/dev/null 2>&1 || true
 apt-get install -y unzip git libzip-dev zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev pkg-config >/dev/null 2>&1 || true
 # build and enable zip and gd extensions for deterministic PHPStan runs
 docker-php-ext-configure gd --with-jpeg --with-freetype >/dev/null 2>&1 || true
 docker-php-ext-install -j$(nproc) zip gd >/dev/null 2>&1 || true
 php -r "copy(\"https://getcomposer.org/installer\", \"composer-setup.php\");"
 php composer-setup.php --install-dir=/usr/local/bin --filename=composer >/dev/null 2>&1 || true
 git config --global --add safe.directory /work || true
  # Install including dev dependencies so phpstan (dev) is available
  composer install --no-interaction --prefer-dist --no-scripts || true
 if [ -x vendor/bin/phpstan ]; then
   vendor/bin/phpstan analyse -c phpstan.neon -a stubs/php_core_functions.php --memory-limit=512M --error-format=json
 else
   echo "[]"
 fi' > .tools/docker_phpstan.json || true

# normalize docker phpstan paths and canonicalize JSON
if [ -f .tools/docker_phpstan.json ]; then
  sed -i.bak "s|/work|.|g" .tools/docker_phpstan.json || true
  if command -v jq >/dev/null 2>&1; then
    jq -S -c '.' .tools/docker_phpstan.json > .tools/docker_phpstan.json.tmp || true
    mv .tools/docker_phpstan.json.tmp .tools/docker_phpstan.json || true
    printf '\n' >> .tools/docker_phpstan.json || true
  fi
fi

echo "Comparing results..."

DIFFS=0

for tool in eslint stylelint phpstan; do
  L=".tools/local_${tool}.json"
  D=".tools/docker_${tool}.json"
  if ! cmp -s "$L" "$D"; then
    echo "Mismatch detected for $tool:"
    echo "  Local: $L"
    echo "  Docker: $D"
    echo "  Showing unified diff:"
    diff -u "$L" "$D" || true
    DIFFS=$((DIFFS+1))
  else
    echo "$tool: outputs match"
  fi
done

if [ $DIFFS -ne 0 ]; then
  echo "Linters differ between local and docker. Commit aborted."
  exit 1
fi

echo "Linters match in local and docker."
exit 0
