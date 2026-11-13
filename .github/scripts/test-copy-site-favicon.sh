#!/usr/bin/env bash

# Runs copy-site-favicon.sh against fixture theme and site folders.

set -euo pipefail

script="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/copy-site-favicon.sh"
test_root="$(mktemp -d)"
trap 'chmod -R u+w "$test_root"; rm -rf "$test_root"' EXIT

theme="$test_root/theme"
site="$test_root/site"
mkdir -p "$theme/resources/images" "$site"

# No favicon in the theme: the site's own stays.
printf 'site icon' > "$site/favicon.ico"
bash "$script" "$theme/" "$site" | grep -Fq 'site root keeps its own'
[[ "$(cat "$site/favicon.ico")" == 'site icon' ]]

# An empty theme favicon counts as none.
: > "$theme/resources/images/favicon.ico"
bash "$script" "$theme/" "$site" | grep -Fq 'site root keeps its own'

# A new theme favicon replaces the site's, with group write access.
printf 'theme icon' > "$theme/resources/images/favicon.ico"
bash "$script" "$theme/" "$site" | grep -Fq 'Copied'
cmp -s "$theme/resources/images/favicon.ico" "$site/favicon.ico"
[[ "$(stat -c '%a' "$site/favicon.ico" 2>/dev/null || stat -f '%Lp' "$site/favicon.ico")" == 664 ]]
test ! -e "$site/favicon.ico.deploy-tmp"

# A matching favicon is left alone.
bash "$script" "$theme/" "$site" | grep -Fq 'already matches'

# A site root the deploy user can't write to warns and still succeeds.
printf 'newer theme icon' > "$theme/resources/images/favicon.ico"
chmod a-w "$site"
output=$(bash "$script" "$theme/" "$site")
grep -Fq "::warning::Couldn't copy" <<< "$output"
[[ "$(cat "$site/favicon.ico")" == 'theme icon' ]]
test ! -e "$site/favicon.ico.deploy-tmp"
chmod u+w "$site"

# No favicon at the site root yet: the theme's is copied.
rm "$site/favicon.ico"
bash "$script" "$theme/" "$site" | grep -Fq 'Copied'
cmp -s "$theme/resources/images/favicon.ico" "$site/favicon.ico"

echo 'Favicon copy checks passed'
