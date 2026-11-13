#!/usr/bin/env bash

# Syncs a fixture tree through the filter create-rsync-filter.sh builds from
# .deployignore, and checks what reaches the server.

set -euo pipefail

theme_root="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
test_root="$(mktemp -d)"
trap 'rm -rf "$test_root"' EXIT

source_dir="$test_root/source"
destination_dir="$test_root/destination"
mkdir -p "$source_dir/.agents/skills/example" "$source_dir/.git" "$source_dir/.github/workflows" "$source_dir/docs" "$source_dir/public/build" "$source_dir/resources/js" "$source_dir/resources/scripts" "$source_dir/vendor" "$destination_dir/vendor" "$destination_dir/resources/js/removed"

cp "$theme_root/.deployignore" "$source_dir/.deployignore"
ln -s .agents "$source_dir/.claude"
printf '# Example skill\n' > "$source_dir/.agents/skills/example/SKILL.md"
printf '# Agent instructions\n' > "$source_dir/AGENTS.md"
printf '# Readme\n' > "$source_dir/README.md"
printf '[core]\n' > "$source_dir/.git/config"
printf 'name: CI\n' > "$source_dir/.github/workflows/ci.yml"
printf '# Notes\n' > "$source_dir/docs/notes.md"
printf '<?php // deployable fixture\n' > "$source_dir/functions.php"
printf '{}\n' > "$source_dir/public/build/manifest.json"
printf 'window.app = true;\n' > "$source_dir/resources/js/app.js"
printf 'console.log("tool");\n' > "$source_dir/resources/scripts/tool.mjs"
printf '<?php // local dependency\n' > "$source_dir/vendor/local.php"
printf '<?php // remote dependency\n' > "$destination_dir/vendor/remote.php"
printf 'window.removed = true;\n' > "$destination_dir/resources/js/removed/old.js"
printf '{}\n' > "$source_dir/composer.json"
printf '{}\n' > "$source_dir/composer.lock"
printf '{}\n' > "$source_dir/package.json"

(
  cd "$source_dir"
  bash "$theme_root/.github/scripts/create-rsync-filter.sh" .deployignore rsync_filter
)

rsync -a --delete \
  --filter="merge $source_dir/rsync_filter" \
  "$source_dir/" "$destination_dir/"

test ! -e "$destination_dir/.agents"
test ! -L "$destination_dir/.claude"
test ! -e "$destination_dir/AGENTS.md"
test ! -e "$destination_dir/README.md"
test ! -e "$destination_dir/.git"
test ! -e "$destination_dir/.github"
test ! -e "$destination_dir/docs"
test ! -e "$destination_dir/resources/scripts"
test ! -e "$destination_dir/composer.lock"
test ! -e "$destination_dir/package.json"
test ! -e "$destination_dir/rsync_filter"
test -e "$destination_dir/functions.php"
test -e "$destination_dir/public/build/manifest.json"
test -e "$destination_dir/resources/js/app.js"
test ! -e "$destination_dir/resources/js/removed/old.js"
test -e "$destination_dir/vendor/local.php"
test ! -e "$destination_dir/vendor/remote.php"
test -e "$destination_dir/composer.json"

echo 'Deploy filter excludes project-only files, ships runtime/build files and the production vendor tree, and deletes removed files'
