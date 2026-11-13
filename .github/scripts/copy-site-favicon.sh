#!/usr/bin/env bash

# Copies the theme's resources/images/favicon.ico to the site's web root, where
# browsers request /favicon.ico. The web server serves that file before WordPress
# can redirect the request to the Site Icon. Runs on the server after a deploy.
#
# Usage: copy-site-favicon.sh <theme path> <WordPress root>
#
# A theme without a favicon.ico leaves the root alone, and so does a matching one.
# A failed copy warns without failing the deploy, because the theme itself shipped.

set -uo pipefail

theme_favicon="${1%/}/resources/images/favicon.ico"
site_favicon="${2%/}/favicon.ico"
staged="$site_favicon.deploy-tmp"

if [[ ! -s "$theme_favicon" ]]; then
  echo 'The theme has no favicon.ico, so the site root keeps its own'
  exit 0
fi

if cmp -s "$theme_favicon" "$site_favicon"; then
  echo 'The site root favicon.ico already matches the theme'
  exit 0
fi

# Stage beside the target and rename, so a request never reads a half-written file.
umask 0002
if cp "$theme_favicon" "$staged" && chmod 664 "$staged" && mv -f "$staged" "$site_favicon"; then
  echo 'Copied the theme favicon.ico to the site root'
else
  rm -f "$staged"
  echo "::warning::Couldn't copy the theme favicon.ico to $site_favicon"
fi
