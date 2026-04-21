#!/usr/bin/env bash
set -euo pipefail
TMPDIR=/tmp/seedtest
rm -rf "$TMPDIR" || true
mkdir -p "$TMPDIR"
cd /var/www/html/proyecto
# Fetch login page and store cookies
curl -s -c "$TMPDIR/cookies.txt" -L "http://127.0.0.1/login" -o "$TMPDIR/login.html"
# Extract any csrf token from login page (if present)
CSRF_LOGIN=$(grep -Po 'name="_csrf_token" value="\K[^"]+' "$TMPDIR/login.html" || true)
# Post login with credentials admin@abc.com / Admin123!
USER_FIELD='_username'; PASS_FIELD='_password';
if ! grep -q 'name="_username"' "$TMPDIR/login.html"; then USER_FIELD='username'; fi
if ! grep -q 'name="_password"' "$TMPDIR/login.html"; then PASS_FIELD='password'; fi
curl -s -b "$TMPDIR/cookies.txt" -c "$TMPDIR/cookies.txt" -L \
  -d "$USER_FIELD=admin@abc.com" -d "$PASS_FIELD=Admin123!" \
  -d "_csrf_token=$CSRF_LOGIN" \
  'http://127.0.0.1/login' -o "$TMPDIR/after_login.html"
# Get create form and extract CSRF token
curl -s -b "$TMPDIR/cookies.txt" -L 'http://127.0.0.1/items/create' -o "$TMPDIR/create.html"
CSRF_ITEM=$(grep -Po 'name="_token" value="\K[^"]+' "$TMPDIR/create.html" || true)
echo "CSRF_ITEM=$CSRF_ITEM"
# Submit POST to create item
curl -s -b "$TMPDIR/cookies.txt" -L -D "$TMPDIR/headers.txt" \
  -X POST 'http://127.0.0.1/items/create' \
  -d "_token=$CSRF_ITEM" -d "code=QA-R-TEST" -d "name=Rubro 123" -d "unit=m²" \
  -o "$TMPDIR/post_result.html"
# Output snippet
echo '--- Headers ---'
sed -n '1,200p' "$TMPDIR/headers.txt"
echo '--- Body snippet ---'
sed -n '1,200p' "$TMPDIR/post_result.html"
