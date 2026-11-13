<?php

/**
 * Theme setup.
 */

namespace App;

require_once __DIR__.'/Walker/Aria_Walker_Nav_Menu.php';
require_once __DIR__.'/Walker/Accordion_Walker_Nav_Menu.php';
require_once __DIR__.'/Walker/Button_Walker_Nav_Menu.php';
require_once __DIR__.'/Structure/navigation.php';
require_once __DIR__.'/Structure/detect-vertical-positions.php';
require_once __DIR__.'/Structure/patterns-menu.php';

use Illuminate\Support\Facades\Vite;

/**
 * Disable the block directory to prevent easy plugin installations.
 */
remove_action('enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets');

/**
 * Enqueues the theme stylesheet and script last, so they follow every plugin's.
 *
 * Enqueued handles, not printed tags, let Spine Toolkit stamp its Content Security
 * Policy nonce on them.
 */
add_action('wp_enqueue_scripts', function (): void {
    if (Vite::isRunningHot()) {
        wp_enqueue_script('vite-client', Vite::asset('@vite/client'), [], null, false);
    }

    wp_enqueue_style('theme', Vite::asset('resources/css/app.css'), [], null);
    wp_enqueue_script('theme', Vite::asset('resources/js/app.js'), [], null, true);
}, 9999999);

/**
 * Loads the theme's ES module scripts as modules.
 */
add_filter('script_loader_tag', function (string $tag, string $handle): string {
    if (in_array($handle, ['vite-client', 'theme', 'theme-editor'], true) && ! str_contains($tag, 'type=')) {
        $tag = str_replace('<script ', '<script type="module" ', $tag);
    }

    return $tag;
}, 10, 2);

/**
 * Enqueues the block editor script with the WordPress packages it imports, which
 * the build lists in `editor.deps.json`.
 */
add_action('enqueue_block_editor_assets', function (): void {
    wp_enqueue_script(
        'theme-editor',
        Vite::asset('resources/js/editor.js'),
        json_decode(Vite::content('editor.deps.json')),
        null,
        true
    );
});

/**
 * Loads the editor stylesheet into the editor canvas from the Vite dev server, which
 * editor styles can't point at. The editor loads block assets inside its iframe.
 */
add_action('enqueue_block_assets', function (): void {
    if (! Vite::isRunningHot() || ! is_admin()) {
        return;
    }

    wp_enqueue_script('vite-client', Vite::asset('@vite/client'), [], null, false);
    wp_enqueue_style('theme-editor', Vite::asset('resources/css/editor.css'), [], null);
});

/**
 * Use the generated theme.json file.
 *
 * @return string
 */
add_filter('theme_file_path', function ($path, $file) {
    return $file === 'theme.json'
        ? public_path('build/assets/theme.json')
        : $path;
}, 10, 2);

/**
 * Prints the global styles before the block styles, so a block style variation,
 * such as the outline button's border, wins over the global element styles.
 * WordPress enqueues them later on the same hook.
 */
add_action('wp_enqueue_scripts', 'wp_enqueue_global_styles', 0);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Style the editor canvas with the built editor stylesheet. Editor styles take a
     * path relative to the theme, so they can't point at the Vite dev server.
     */
    add_theme_support('editor-styles');

    if (! Vite::isRunningHot()) {
        add_editor_style(str_replace(get_theme_file_uri().'/', '', Vite::asset('resources/css/editor.css')));
    }

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable responsive embed support.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);

    /**
     * Enable custom logo support.
     *
     * @link https://developer.wordpress.org/themes/functionality/custom-logo/
     */
    add_theme_support('custom-logo', [
        'height' => 0,
        'width' => 0,
        'flex-height' => true,
        'flex-width' => true,
    ]);
}, 20);

/**
 * Add no-js class removal script to head.
 *
 * Printed through wp_print_inline_script_tag() rather than echoed, so it leaves
 * through WordPress's own inline-script API. That is the seam a strict Content
 * Security Policy recognises, so the tag is given the response nonce; a raw
 * echo carries no proof of where it came from and the browser refuses to run
 * it.
 *
 * Priority 0 is the earliest slot WordPress offers on wp_head, so the class is
 * gone before the title tag, enqueued styles and preload hints are emitted.
 *
 * @return void
 */
add_action('wp_head', function () {
    wp_print_inline_script_tag(
        "(function(){'use strict';document.documentElement.classList.remove('no-js')})();",
        ['id' => 'no-js']
    );
}, 0);
