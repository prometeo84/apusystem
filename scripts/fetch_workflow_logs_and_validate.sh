#!/usr/bin/env bash
set -euo pipefail

ROOT=$(cd "$(dirname "$0")/.." && pwd)
cd "$ROOT"

REPO_URL=$(git config --get remote.origin.url || true)
if [ -z "$REPO_URL" ]; then
  echo "No remote.origin.url found in .git/config" >&2
  exit 1
fi

# If a token is embedded in the remote URL (https://<token>@github.com/owner/repo.git), extract it but do NOT print it
TOKEN_FROM_URL=$(printf "%s" "$REPO_URL" | sed -nE 's#https://([^@]+)@github.com/.*#\1#p' || true)
if [ -z "${GH_TOKEN:-}" ] && [ -n "$TOKEN_FROM_URL" ]; then
  # Use token from URL for the download but avoid echoing it
  GH_TOKEN="$TOKEN_FROM_URL"
fi

# Normalize to owner/repo (remove any embedded token)
REPO=$(printf "%s" "$REPO_URL" | sed -E 's#https://([^@]+)@github.com/(.*)/(.*)\.git#\2/\3#; s#git@github.com:(.*)/(.*)\.git#\1/\2#; s#https://github.com/(.*)/(.*)\.git#\1/\2#; s#https://github.com/(.*)/(.*)#\1/\2#')
echo "Repository detected: $REPO"

if [ -z "${GH_TOKEN:-}" ]; then
  echo "Please set GH_TOKEN in your environment before running this script. Example:" >&2
  echo "  export GH_TOKEN=ghp_xxx" >&2
  exit 2
fi

mkdir -p .tools/github_logs

echo "Downloading latest workflow run logs via Docker (will run a Python container)..."

docker run --rm -e GH_TOKEN="$GH_TOKEN" -e REPO="$REPO" -v "$ROOT":/work -w /work python:3.11-slim bash -lc '
python3 - <<PY
import os,sys,urllib.request,json,zipfile,io
token=os.environ.get("GH_TOKEN")
repo=os.environ.get("REPO")
if not token or not repo:
    print("Missing GH_TOKEN or REPO", file=sys.stderr); sys.exit(2)
headers={"Authorization":f"Bearer {token}","Accept":"application/vnd.github.v3+json","User-Agent":"repo-log-fetcher"}
url=f"https://api.github.com/repos/{repo}/actions/runs?per_page=5"
req=urllib.request.Request(url, headers=headers)
with urllib.request.urlopen(req) as resp:
    data=json.load(resp)
runs=data.get("workflow_runs",[])
if not runs:
    print("No workflow runs found for repo", repo); sys.exit(0)
run_id=runs[0]["id"]
print("Latest run id:", run_id)
logs_url=f"https://api.github.com/repos/{repo}/actions/runs/{run_id}/logs"
req2=urllib.request.Request(logs_url, headers={"Authorization":f"Bearer {token}","User-Agent":"repo-log-fetcher"})
print("Downloading logs from:", logs_url)
with urllib.request.urlopen(req2) as r:
    data=r.read()
buf=io.BytesIO(data)
outdir=f".tools/github_logs/run_{run_id}"
import os
os.makedirs(outdir, exist_ok=True)
with zipfile.ZipFile(buf) as zf:
    zf.extractall(outdir)
print("Extracted logs to", outdir)
PY'

echo "Downloaded and extracted logs into .tools/github_logs/. You can inspect files there."

echo "Running actionlint in Docker (nektos/actionlint) -> .tools/actionlint.txt"
mkdir -p .tools
docker run --rm -v "$ROOT":/work -w /work nektos/actionlint actionlint .github/workflows/*.yml > .tools/actionlint.txt 2>&1 || true
echo "Actionlint output saved to .tools/actionlint.txt"

echo "Done."
