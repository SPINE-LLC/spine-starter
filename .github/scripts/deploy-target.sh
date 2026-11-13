#!/usr/bin/env bash

# Prints one deployment target's settings as KEY=value lines for $GITHUB_ENV, and
# refuses a ref that may not deploy to it.
#
# Each site fills in its own values: the Cloudways server's ID and public IP, and
# for each application its ID, folder (the app's symlink), system user, and home
# URL. The Cloudways dashboard and the Cloudways MCP both list them. A target the
# site doesn't have stays empty, and the deploy for it stops with an error.

set -euo pipefail

target="${1:?Deployment target is required}"

theme_name=spine-starter
server_id=
server_ip=

case "$target" in
  dev)
    branch=dev
    app_id=
    app_folder=
    sys_user=
    site_url=
    ;;
  staging)
    branch=staging
    app_id=
    app_folder=
    sys_user=
    site_url=
    ;;
  prod)
    branch=main
    app_id=
    app_folder=
    sys_user=
    site_url=
    ;;
  *)
    echo "Unknown deployment target: $target" >&2
    exit 1
    ;;
esac

for value in "$server_id" "$server_ip" "$app_id" "$app_folder" "$sys_user" "$site_url"; do
  if [[ -z "$value" ]]; then
    echo "The $target target isn't configured in .github/scripts/deploy-target.sh" >&2
    exit 1
  fi
done

if [[ "$GITHUB_REF" != "refs/heads/$branch" && "$GITHUB_REF" != refs/tags/rebuild/"$target"/* ]]; then
  echo "Ref $GITHUB_REF cannot deploy to $target" >&2
  exit 1
fi

printf 'THEME_NAME=%s\nCLOUDWAYS_SERVER_ID=%s\nEXPECTED_SERVER_IP=%s\nDEPLOY_BRANCH=%s\nCLOUDWAYS_APP_ID=%s\nEXPECTED_APP_FOLDER=%s\nEXPECTED_SYS_USER=%s\nSITE_URL=%s\n' \
  "$theme_name" "$server_id" "$server_ip" "$branch" "$app_id" "$app_folder" "$sys_user" "$site_url"
