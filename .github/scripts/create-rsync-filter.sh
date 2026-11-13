#!/usr/bin/env bash

set -euo pipefail

ignore_file="${1:-.deployignore}"
filter_file="${2:-rsync_filter}"

printf '# rsync filter rules converted from %s\n' "$ignore_file" > "$filter_file"

while IFS= read -r pattern || [[ -n "$pattern" ]]; do
  case "$pattern" in
    ''|'#'*)
      continue
      ;;
    '!'*)
      printf '+ %s\n' "${pattern:1}" >> "$filter_file"
      ;;
    'P '*)
      printf 'P %s\n' "${pattern:2}" >> "$filter_file"
      ;;
    *)
      pattern="${pattern//\*\*/***}"

      if [[ -d "$pattern" && ! -L "$pattern" && "$pattern" != */ ]]; then
        pattern="${pattern}/"
      fi

      printf -- '- %s\n' "$pattern" >> "$filter_file"
      ;;
  esac
done < "$ignore_file"

printf -- '- %s\n' "$filter_file" >> "$filter_file"
printf '+ *\n' >> "$filter_file"
