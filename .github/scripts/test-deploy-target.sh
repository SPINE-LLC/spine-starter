#!/usr/bin/env bash

# Checks which refs may deploy to which target. The checks run on a copy of
# deploy-target.sh with placeholder values in its empty settings, so they pass
# before a site fills in its own.

set -euo pipefail

script_dir=$(cd "$(dirname "$0")" && pwd)
test_root=$(mktemp -d)
trap 'rm -rf "$test_root"' EXIT

script="$test_root/deploy-target.sh"
sed -E 's/^([[:space:]]*[a-z_]+)=$/\1=placeholder/' "$script_dir/deploy-target.sh" > "$script"

for pair in dev:refs/heads/dev staging:refs/heads/staging prod:refs/heads/main; do
  target=${pair%%:*}
  GITHUB_REF=${pair#*:} bash "$script" "$target" | grep -Fxq "DEPLOY_BRANCH=${pair#*:refs/heads/}"
  GITHUB_REF="refs/tags/rebuild/$target/test" bash "$script" "$target" >/dev/null
done

for ref in refs/heads/dev refs/heads/staging refs/tags/rebuild/dev/test refs/tags/rebuild/staging/test; do
  if GITHUB_REF="$ref" bash "$script" prod >/dev/null 2>&1; then
    echo "Non-production ref $ref was allowed to deploy production" >&2
    exit 1
  fi
done

if GITHUB_REF=refs/heads/dev bash "$script" staging >/dev/null 2>&1; then
  echo 'Dev branch was allowed to deploy staging' >&2
  exit 1
fi

# The real script either has a complete production target or says it has none.
if ! output=$(GITHUB_REF=refs/heads/main bash "$script_dir/deploy-target.sh" prod 2>&1); then
  grep -Fq "isn't configured" <<< "$output"
fi

echo 'Deployment target checks passed'
