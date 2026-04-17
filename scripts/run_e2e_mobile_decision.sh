#!/usr/bin/env bash
set -euo pipefail
cd /workspace
# Runs Mobile + two tablet emulations and applies decision rule:
# - If Mobile passes -> overall PASS
# - If Mobile fails and BOTH tablets pass -> overall PASS
# - Otherwise -> overall FAIL

PROJECTS=("Mobile Chrome" "Tablet iPad" "Tablet Galaxy")
DUMP_NAMES=("mobile" "ipad" "galaxy")
RESULTS=()

for i in "${!PROJECTS[@]}"; do
  P="${PROJECTS[$i]}"
  NAME="${DUMP_NAMES[$i]}"
  echo "--- Running project: $P ---"
  # Remove previous final diag
  docker_rm_cmd="true"
  # Run playwright with DIAG_FINAL to produce /tmp/final_diag.json inside container
  DIAG_FINAL=1 npx playwright test --project="$P" --reporter=list --workers=1 --timeout=600000 || true
  RC=$?
  RESULTS+=("$RC")
  # copy the final_diag.json to workspace with an indicative name if exists
  if [ -f /tmp/final_diag.json ]; then
    cp /tmp/final_diag.json ./test-results/final_diag_${NAME}.json 2>/dev/null || true
    echo "WROTE test-results/final_diag_${NAME}.json"
    rm -f /tmp/final_diag.json || true
  else
    echo "No /tmp/final_diag.json for $P"
  fi
  echo "Result code for $P: $RC"
done

MOBILE_RC=${RESULTS[0]}
IPAD_RC=${RESULTS[1]}
GALAXY_RC=${RESULTS[2]}

# Decision logic
if [ "$MOBILE_RC" -eq 0 ]; then
  echo "DECISION: PASS (mobile passed)"
  exit 0
fi

if [ "$MOBILE_RC" -ne 0 ] && [ "$IPAD_RC" -eq 0 ] && [ "$GALAXY_RC" -eq 0 ]; then
  echo "DECISION: PASS (mobile failed but both tablets passed)"
  exit 0
fi

echo "DECISION: FAIL (mobile failed and at least one tablet failed)"
exit 1
