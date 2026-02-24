<?php

/**
 * Theme setup.
 */

namespace App;

require_once __DIR__ . '/Walker/Aria_Walker_Nav_Menu.php';
require_once __DIR__ . '/Walker/Accordion_Walker_Nav_Menu.php';
require_once __DIR__ . '/Walker/Button_Walker_Nav_Menu.php';
require_once __DIR__ . '/Structure/navigation.php';
require_once __DIR__ . '/Structure/detect-vertical-positions.php';

use Illuminate\Support\Facades\Vite;



/**
 * Inject styles into the block editor.
 *
 * @return array
 */
add_filter('block_editor_settings_all', function ($settings) {
    $style = Vite::asset('resources/css/editor.css');

    $settings['styles'][] = [
        'css' => "@import url('{$style}')",
    ];

    return $settings;
});

/**
 * Disable the block directory to prevent easy plugin installations.
 */
remove_action('enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets');



/**
 * Inject scripts into the block editor.
 *
 * @return void
 */
add_filter('admin_head', function () {
    if (! get_current_screen()?->is_block_editor()) {
        return;
    }

    $dependencies = json_decode(Vite::content('editor.deps.json'));

    foreach ($dependencies as $dependency) {
        if (! wp_script_is($dependency)) {
            wp_enqueue_script($dependency);
        }
    }

    echo Vite::withEntryPoints([
        'resources/js/editor.js',
    ])->toHtml();
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
 * Enqueue global styles to register the handle.
 *
 * @return void
 */
add_action('init', function () {
    wp_enqueue_global_styles();
});






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
 * @return void
 */
add_action( 'wp_head', function() {
	echo "<script id=\"no-js\">(function(){'use strict';document.documentElement.classList.remove('no-js')})();</script>\n";
}, 1 );



