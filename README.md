# Spine Starter

SPINE's starter theme for WordPress sites: Sage 11 on Acorn 6, with Blade views, Vite and Tailwind CSS 4. It follows the conventions the EV Connect theme settled on, so a site built from it deploys and behaves the same way.

## Requirements

- PHP 8.4 and Composer
- Node 24 and pnpm 12.18.0
- WordPress 6.6 or later, served locally by Herd

## Setup

Run these from the theme folder:

```sh
composer install
pnpm install
pnpm build
```

`functions.php` loads Acorn from `vendor/`, so `composer install` must run before WordPress loads the theme.

| Command | What it does |
| --- | --- |
| `pnpm dev` | Runs the Vite dev server. Set `APP_URL` in `.env` to the local site's URL. Run `pnpm build` once first, because the editor reads `editor.deps.json` from the build. |
| `pnpm build` | Builds `public/build`, including the `theme.json` WordPress reads, generated from this folder's `theme.json` and Tailwind's colors, fonts and font sizes. |
| `pnpm run verify:build` | Checks that the build has every entry the theme enqueues and a complete generated `theme.json`. |
| `composer lint` | Checks PHP formatting with Pint. `vendor/bin/pint` fixes it. |

## How the theme works

- `index.php` renders `resources/views/layouts/app.blade.php`, which includes the matched view inside `main#main`. Views don't use `@extends`, because a view that extends the layout renders before `wp_head()` and the header, which changes the order WordPress hooks and generated IDs run in. The root `404.php` renders the same layout for Spine Toolkit, which loads it directly.
- `app/setup.php` enqueues the built stylesheet and scripts as WordPress handles, so Spine Toolkit can add its Content Security Policy nonce. Don't print Vite tags in a view.
- `app/Blocks/Supports.php` gives every block core's style controls, such as width, height, border and shadow, so editors style blocks from their settings instead of page CSS. `theme.json` turns the controls on with `appearanceTools`.
- `resources/css/editor.css` gives the editor canvas the front end's content styles, so posts look the same in both. WordPress adds it unscoped inside the canvas, beside the editor's own placeholders and buttons, so Tailwind's reset and the type styles sit in an `@scope` that stops at WordPress's components, and the header, footer, and menu styles stay out. The base font and line height come from `theme.json`, which WordPress applies to both. Import new block CSS into both `app.css` and `editor.css`, then compare the canvas with the front end at the same width.
- The menus render through the walkers in `app/Walker`.
- `functions.php` boots Acorn with the providers in `app/Providers`. Acorn leaves PHP warnings to WordPress, and its console kernel boots on plain PHP loads such as a server cron.

## Starting a site

1. Copy the theme into the site's repository under the folder name the site will use in `wp-content/themes`.
2. Set that folder name as `themeFolder` in `vite.config.js` and `theme_name` in `.github/scripts/deploy-target.sh`, and update the theme name and text domain in `style.css`.
3. Fill in the Cloudways server and each application in `.github/scripts/deploy-target.sh`. Leave a target empty when the site doesn't have it.
4. Add the repository secrets the deploy uses: `CLOUDWAYS_DEPLOY_ACCESS_TOKEN`, `CLOUDWAYS_DEV_APP_SSH_KEY`, `CLOUDWAYS_STAGING_APP_SSH_KEY`, `CLOUDWAYS_PRODUCTION_APP_SSH_KEY`, `PROXY_SERVER_IP`, `PROXY_SERVER_USER`, `PROXY_SERVER_SSH_KEY` and `SLACK_WEBHOOK`.

## Deploying

`.github/workflows/ci.yml` builds and checks every push and pull request. A push to `dev`, `staging` or `main`, or a `rebuild/<target>/…` tag at that branch's head, then runs `.github/workflows/deploy-theme.yml` for the matching target.

The deploy installs production Composer packages and syncs `vendor/` before the rest of the theme, so new code never runs against old packages. It verifies the exact Cloudways application and WordPress install first, then prunes superseded build assets, copies `resources/images/favicon.ico` to the site root when the theme has one, rebuilds Acorn's caches, purges WordPress, Spine Toolkit and Cloudways caches, and loads the home page to check the new build. `.deployignore` lists what stays out of the deploy. A theme deploy never changes the database.
