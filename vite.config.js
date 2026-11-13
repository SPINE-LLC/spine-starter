import { defaultAllowedOrigins, defineConfig, loadEnv } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin';
import { wordpressPlugin, wordpressThemeJson } from '@roots/vite-plugin';

// The theme's folder under wp-content/themes, which asset URLs in the CSS start from.
const themeFolder = 'spine-starter';

export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), '');
  let appUrl;

  try {
    appUrl = env.APP_URL ? new URL(env.APP_URL) : undefined;
  } catch {
    appUrl = undefined;
  }

  return {
    base: `/wp-content/themes/${themeFolder}/public/build/`,
    plugins: [
      tailwindcss({
        theme: {
          screens: {
            sm: '600px' /* to be in line with WordPress breakpoints */,
          },
        },
      }),
      laravel({
        input: [
          'resources/css/app.css',
          'resources/js/app.js',
          'resources/css/editor.css',
          'resources/js/editor.js',
        ],
        refresh: true,
        assets: ['resources/images/**', 'resources/fonts/**'],
        detectTls: appUrl?.host ?? null,
      }),

      wordpressPlugin(),

      // Generate the theme.json file in the public/build/assets directory
      // based on the Tailwind config and the theme.json file from base theme folder
      wordpressThemeJson({
        disableTailwindColors: false,
        disableTailwindFonts: false,
        disableTailwindFontSizes: false,
      }),
    ],
    build: {
      minify: mode === 'production',
      sourcemap: mode === 'development',
    },
    css: {
      devSourcemap: true,
      // Lightning CSS lowers and prefixes for Vite's default browser targets.
      transformer: 'lightningcss',
      lightningcss: {
        drafts: { customMedia: true },
      },
    },
    server: {
      headers: {
        'Cross-Origin-Resource-Policy': 'cross-origin',
      },
      cors: {
        origin: [
          defaultAllowedOrigins,
          appUrl?.origin,
          /^https?:\/\/.*\.(local|test)(:\d+)?$/,
        ].filter(Boolean),
      },
      open: appUrl?.href,
    },
    resolve: {
      alias: {
        '@scripts': '/resources/js',
        '@styles': '/resources/css',
        '@fonts': '/resources/fonts',
        '@images': '/resources/images',
      },
    },
  };
});
