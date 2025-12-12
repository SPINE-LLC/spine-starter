<?php

/**
 * Navigation setup and functions.
 */

namespace App;

/**
 * Register the navigation menus.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
        'primary_buttons' => __('Primary Buttons', 'sage'),
        'compact_navigation' => __('Compact Navigation', 'sage'),
        'compact_buttons' => __('Compact Buttons', 'sage'),
        'privacy_navigation' => __('Privacy Navigation', 'sage'),
        'footer_navigation' => __('Footer Navigation', 'sage'),
    ]);
});

/**
 * Primary navigation menu function.
 *
 * @return string
 */
function primary_nav() {
    return wp_nav_menu([
        'theme_location' => 'primary_navigation',
        'menu_class' => 'nav is-dropdown',
        'depth' => 3,
        'echo' => false,
        'walker' => new \App\Walker\Aria_Walker_Nav_Menu()
    ]);
}

/**
 * Primary buttons menu function.
 *
 * @return string
 */
function primary_btns_nav() {
	return wp_nav_menu([
		'theme_location' => 'primary_buttons',
		'menu_class' => 'nav button-nav wp-block-buttons',
		'depth' => 1,
		'echo' => false,
		'walker' => new \App\Walker\Button_Walker_Nav_Menu()
	]);
}

/**
 * Compact buttons menu function.
 *
 * @return string
 */
function compact_btns_nav() {
	return wp_nav_menu(array(
		'theme_location' => 'compact_buttons',
		'menu_class' => 'nav button-nav wp-block-buttons',
		'depth' => 1,
		'echo' => false,
		'walker' => new \App\Walker\Button_Walker_Nav_Menu()
	));
}

/**
 * Compact navigation menu function.
 *
 * @return string
 */
function compact_nav() {
	return wp_nav_menu([
		'theme_location' => 'compact_navigation',
		'menu_class' => 'nav accordion',
		'depth' => 3,
		'echo' => false,
		'walker' => new \App\Walker\Accordion_Walker_Nav_Menu()
	]);
}

/**
 * Footer navigation menu function.
 *
 * @return string
 */
function footer_nav() {
    return wp_nav_menu([
        'theme_location' => 'footer_navigation',
        'menu_class' => 'nav',
        'depth' => 1,
        'echo' => false,
    ]);
}

/**
 * Privacy navigation menu function.
 *
 * @return string
 */
function privacy_nav() {
    return wp_nav_menu([
        'theme_location' => 'privacy_navigation',
        'menu_class' => 'nav',
        'depth' => 1,
        'echo' => false,
    ]);
}

