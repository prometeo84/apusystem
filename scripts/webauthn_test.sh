#!/usr/bin/env bash
set -euo pipefail
cd /var/www/html/proyecto
mkdir -p /tmp/webauthn_test

# Fetch login page and extract CSRF token
curl -k -s -c /tmp/webauthn_test/cookies https://localhost/login -o /tmp/webauthn_test/login.html
TOKEN=$(grep -oP 'name="_csrf_token" value="\K[^"]+' /tmp/webauthn_test/login.html || true)
echo "TOKEN:$TOKEN" > /tmp/webauthn_test/token.txt

# Perform login (use regular user to avoid admin hardware attestation requirement)
curl -k -b /tmp/webauthn_test/cookies -c /tmp/webauthn_test/cookies -L -s -D /tmp/webauthn_test/headers -o /tmp/webauthn_test/after_login.html \
    -H "Origin: https://localhost" \
    -H "Referer: https://localhost/login" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    --data "_username=user@abc.com&_password=Admin123!&_csrf_token=${TOKEN}" \
    https://localhost/login || true

echo "--- AFTER LOGIN HTML (truncated) ---"
sed -n '1,120p' /tmp/webauthn_test/after_login.html || true
echo "--- HEADERS ---"
sed -n '1,200p' /tmp/webauthn_test/headers || true

echo "--- CALL REGISTER START ---"
curl -k -b /tmp/webauthn_test/cookies -s -X POST -H "Origin: https://localhost" -H "Referer: https://localhost/" https://localhost/webauthn/register/start -o /tmp/webauthn_test/register_start.json || true
cat /tmp/webauthn_test/register_start.json || true

# Build a basic clientDataJSON using the challenge from start
CHALLENGE=$(grep -oP '"challenge"\s*:\s*"\K[^\"]+' /tmp/webauthn_test/register_start.json || true)
if [ -z "$CHALLENGE" ] || [ "$CHALLENGE" = "null" ]; then
    echo "No challenge from start; aborting finish attempt"
else
    # Build clientDataJSON without jq
    CLIENT_JSON=$(printf '{"type":"webauthn.create","challenge":"%s","origin":"https://localhost"}' "$CHALLENGE")
    CLIENT_B64=$(printf '%s' "$CLIENT_JSON" | openssl base64 -A | tr '+/' '-_' | tr -d '=')

    # Prepare temporary files
    TMPDIR=/tmp/webauthn_test
    TMPAUTH="$TMPDIR/authdata.bin"
    ATTOBJ="$TMPDIR/attobj.bin"
    RAWID_BIN="$TMPDIR/rawid.bin"
    rm -f "$TMPAUTH" "$ATTOBJ" "$RAWID_BIN"

    # rpIdHash = sha256("localhost") -> binary (use openssl to avoid xxd)
    printf '%s' "localhost" | openssl dgst -sha256 -binary > "$TMPAUTH"

    # flags: UP (0x01) + AT (0x40) => 0x41
    printf '%b' '\x41' >> "$TMPAUTH"
    # signCount (4 bytes)
    printf '%b' '\x00\x00\x00\x01' >> "$TMPAUTH"

    # aaguid (16 random bytes)
    openssl rand -out "$TMPDIR/aaguid.bin" 16
    cat "$TMPDIR/aaguid.bin" >> "$TMPAUTH"

    # credentialId (16 bytes) preceded by 2-byte big-endian length (0x0010)
    openssl rand -out "$TMPDIR/credid.bin" 16
    printf '%b' '\x00\x10' >> "$TMPAUTH"
    cat "$TMPDIR/credid.bin" >> "$TMPAUTH"

    # Generate an EC P-256 key and build a COSE EC2 public key (alg -7)
    openssl ecparam -name prime256v1 -genkey -noout -out "$TMPDIR/ec.key"
    # Extract uncompressed public key hex (starts with 04 + X(32) + Y(32))
    PUBHEX=$(openssl ec -in "$TMPDIR/ec.key" -pubout -conv_form uncompressed -noout -text | sed -n '/pub:/,/^$/p' | grep -o '[0-9a-fA-F:]\+' | tr -d ':\n' | tr -d ' \n' || true)
    if [ -z "$PUBHEX" ]; then
        # fallback: empty COSE map
        printf '%b' '\xA0' >> "$TMPAUTH"
    else
        # strip leading 04
        PUBXY=${PUBHEX#04}
        XHEX=${PUBXY:0:64}
        YHEX=${PUBXY:64:64}
        echo "$XHEX" > "$TMPDIR/x.hex"
        echo "$YHEX" > "$TMPDIR/y.hex"
        if command -v xxd >/dev/null 2>&1; then
            xxd -r -p "$TMPDIR/x.hex" > "$TMPDIR/x.bin"
            xxd -r -p "$TMPDIR/y.hex" > "$TMPDIR/y.bin"
        else
            # fallback to php for hex->bin conversion (php is available in container)
            php -r "file_put_contents('$TMPDIR/x.bin', hex2bin(trim(file_get_contents('$TMPDIR/x.hex'))));"
            php -r "file_put_contents('$TMPDIR/y.bin', hex2bin(trim(file_get_contents('$TMPDIR/y.hex'))));"
        fi

        # Build COSE EC2 key CBOR bytes:
        # map(5) A5
        # 1 => 2 (kty EC2)
        # 3 => -7 (alg)
        # -1 => 1 (crv P-256)
        # -2 => x coord (bytes)
        # -3 => y coord (bytes)
        TMPCOSE="$TMPDIR/cose.bin"
        printf '%b' '\xA5' > "$TMPCOSE"
        printf '%b' '\x01' >> "$TMPCOSE"; printf '%b' '\x02' >> "$TMPCOSE"
        printf '%b' '\x03' >> "$TMPCOSE"; printf '%b' '\x26' >> "$TMPCOSE"    # -7 -> 0x26
        printf '%b' '\x20' >> "$TMPCOSE"; printf '%b' '\x01' >> "$TMPCOSE"
        printf '%b' '\x21' >> "$TMPCOSE"; printf '%b' '\x58\x20' >> "$TMPCOSE"; cat "$TMPDIR/x.bin" >> "$TMPCOSE"
        printf '%b' '\x22' >> "$TMPCOSE"; printf '%b' '\x58\x20' >> "$TMPCOSE"; cat "$TMPDIR/y.bin" >> "$TMPCOSE"

        # append COSE key directly as credentialPublicKey
        cat "$TMPCOSE" >> "$TMPAUTH"
    fi

    # Build attestationObject as CBOR map: {"fmt":"none","authData":h'...bytes...','attStmt':{}}
    authLen=$(stat -c%s "$TMPAUTH")
    rm -f "$ATTOBJ"
    # map of 3 pairs
    printf '%b' '\xA3' > "$ATTOBJ"
    # key "fmt" (text len 3 -> 0x63) + value "none" (text len 4 -> 0x64)
    printf '%b' '\x63' >> "$ATTOBJ"; printf 'fmt' >> "$ATTOBJ"
    printf '%b' '\x64' >> "$ATTOBJ"; printf 'none' >> "$ATTOBJ"
    # key "authData" (text len 8 -> 0x68) and byte string header 0x58 <len>
    printf '%b' '\x68' >> "$ATTOBJ"; printf 'authData' >> "$ATTOBJ"
    printf '%b' '\x58' >> "$ATTOBJ"
    printf '%b' "\\x$(printf '%02x' "$authLen")" >> "$ATTOBJ"
    cat "$TMPAUTH" >> "$ATTOBJ"
    # key "attStmt" (text len 7 -> 0x67) + empty map 0xA0
    printf '%b' '\x67' >> "$ATTOBJ"; printf 'attStmt' >> "$ATTOBJ"
    printf '%b' '\xA0' >> "$ATTOBJ"

    ATTB64=$(openssl base64 -A < "$ATTOBJ" | tr '+/' '-_' | tr -d '=')

    # rawId
    openssl rand -out "$RAWID_BIN" 16
    RAWID_B64=$(openssl base64 -A < "$RAWID_BIN" | tr '+/' '-_' | tr -d '=')

    JSON_PAY=$(printf '{"attestationObject":"%s","clientDataJSON":"%s","rawId":"%s"}' "$ATTB64" "$CLIENT_B64" "$RAWID_B64")

    echo "--- CALL REGISTER FINISH (emulated) ---"
    curl -k -b /tmp/webauthn_test/cookies -s -X POST -H "Content-Type: application/json" -H "Origin: https://localhost" -d "$JSON_PAY" https://localhost/webauthn/register/finish -o /tmp/webauthn_test/register_finish.json || true
    cat /tmp/webauthn_test/register_finish.json || true
fi

echo "--- TAIL security.log ---"
tail -n 200 /var/www/html/proyecto/var/log/security.log || true
echo "--- TAIL dev.log ---"
tail -n 200 /var/www/html/proyecto/var/log/dev.log || true

echo Done
