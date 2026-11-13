#!/usr/bin/env node

// Checks that the build produced every entry the theme enqueues, and a generated
// theme.json with Tailwind's colors, fonts, and font sizes.

import { access, readFile } from 'node:fs/promises';
import path from 'node:path';

const build = path.resolve('public/build');
const manifest = JSON.parse(await readFile(path.join(build, 'manifest.json'), 'utf8'));
const expectedEntries = [
  'resources/css/app.css',
  'resources/css/editor.css',
  'resources/js/app.js',
  'resources/js/editor.js',
  'editor.deps.json',
];

for (const entry of expectedEntries) {
  const file = manifest[entry]?.file;

  if (!file) {
    throw new Error(`Manifest entry missing: ${entry}`);
  }

  await access(path.join(build, file));
}

const { settings } = JSON.parse(await readFile(path.join(build, 'assets/theme.json'), 'utf8'));

for (const [name, presets] of Object.entries({
  palette: settings?.color?.palette,
  fontFamilies: settings?.typography?.fontFamilies,
  fontSizes: settings?.typography?.fontSizes,
})) {
  if (!presets?.length) {
    throw new Error(`Generated theme.json has no ${name}`);
  }
}

console.log(`Verified ${expectedEntries.length} manifest entries, their output files and the generated theme.json`);
