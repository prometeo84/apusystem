#!/usr/bin/env bash
set -euo pipefail

GIT_ROOT=$(git rev-parse --show-toplevel)
TOOLS_DIR="$GIT_ROOT/.tools"
mkdir -p "$TOOLS_DIR"

if [ -x "$TOOLS_DIR/actionlint" ]; then
  echo "actionlint ya instalado en $TOOLS_DIR/actionlint"
  exit 0
fi

ARCH=$(uname -m)
if [ "$ARCH" = "x86_64" ]; then
  ASSET_MATCH="linux_amd64"
elif [[ "$ARCH" == "aarch64" || "$ARCH" == "arm64" ]]; then
  ASSET_MATCH="linux_arm64"
else
  ASSET_MATCH="linux_amd64"
fi

TMP_ARCHIVE=$(mktemp -t actionlint-XXX).tar.gz
echo "Buscando release de actionlint para $ASSET_MATCH..."
URL=$(curl -s "https://api.github.com/repos/rhysd/actionlint/releases/latest" \
  | jq -r --arg m "$ASSET_MATCH" '.assets[] | select(.name|test($m)) | .browser_download_url' \
  | head -n1)

if [ -z "$URL" ]; then
  echo "No se encontro un asset compatible en la ultima release de actionlint"
  exit 1
fi

echo "Descargando $URL"
curl -L "$URL" -o "$TMP_ARCHIVE"
tar -xzf "$TMP_ARCHIVE" -C "$TOOLS_DIR"

# Buscar binario ejecutable dentro de .tools
BIN=$(find "$TOOLS_DIR" -maxdepth 2 -type f -name 'actionlint*' -perm /111 | head -n1 || true)
if [ -z "$BIN" ]; then
  # fallback: any file extracted
  BIN=$(find "$TOOLS_DIR" -maxdepth 2 -type f | head -n1 || true)
fi

if [ -z "$BIN" ]; then
  echo "No se encontro el binario tras extraer el tarball"
  rm -f "$TMP_ARCHIVE"
  exit 1
fi

mv "$BIN" "$TOOLS_DIR/actionlint"
chmod +x "$TOOLS_DIR/actionlint"
rm -f "$TMP_ARCHIVE"
echo "actionlint instalado en $TOOLS_DIR/actionlint"
