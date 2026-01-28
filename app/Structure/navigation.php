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
 * Clear menu caches when menus are updated.
 *
 * @return void
 */
add_action('wp_update_nav_menu', function () {
    global $wpdb;
    $blog_id = get_current_blog_id();
    $transient_keys = [
        'primary_nav_' . $blog_id,
        'primary_btns_nav_' . $blog_id,
        'compact_nav_' . $blog_id,
        'compact_btns_nav_' . $blog_id,
        'footer_nav_' . $blog_id,
        'privacy_nav_' . $blog_id,
    ];

    foreach ($transient_keys as $key_pattern) {
        $wpdb->query($wpdb->prepare(
            "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s",
            $wpdb->esc_like('_transient_' . $key_pattern) . '%'
        ));
        $wpdb->query($wpdb->prepare(
            "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s",
            $wpdb->esc_like('_transient_timeout_' . $key_pattern) . '%'
        ));
    }
});

/**
 * Primary navigation menu function.
 *
 * @return string
 */
function primary_nav() {
    global $wp;
    $current_url = md5(home_url(add_query_arg(array(), $wp->request)));
    $cache_key = 'primary_nav_' . get_current_blog_id() . '_' . $current_url;
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }
    $output = wp_nav_menu([
        'theme_location' => 'primary_navigation',
        'menu_class' => 'nav is-dropdown',
        'depth' => 3,
        'echo' => false,
        'walker' => new \App\Walker\Aria_Walker_Nav_Menu()
    ]);
    set_transient($cache_key, $output, HOUR_IN_SECONDS);
    return $output;
}

/**
 * Primary buttons menu function.
 *
 * @return string
 */
function primary_btns_nav() {
    global $wp;
    $current_url = md5(home_url(add_query_arg(array(), $wp->request)));
    $cache_key = 'primary_btns_nav_' . get_current_blog_id() . '_' . $current_url;
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }
    $output = wp_nav_menu([
        'theme_location' => 'primary_buttons',
        'menu_class' => 'nav button-nav wp-block-buttons',
        'depth' => 1,
        'echo' => false,
        'walker' => new \App\Walker\Button_Walker_Nav_Menu()
    ]);
    set_transient($cache_key, $output, HOUR_IN_SECONDS);
    return $output;
}

/**
 * Compact buttons menu function.
 *
 * @return string
 */
function compact_btns_nav() {
    global $wp;
    $current_url = md5(home_url(add_query_arg(array(), $wp->request)));
    $cache_key = 'compact_btns_nav_' . get_current_blog_id() . '_' . $current_url;
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }
    $output = wp_nav_menu(array(
        'theme_location' => 'compact_buttons',
        'menu_class' => 'nav button-nav wp-block-buttons',
        'depth' => 1,
        'echo' => false,
        'walker' => new \App\Walker\Button_Walker_Nav_Menu()
    ));
    set_transient($cache_key, $output, HOUR_IN_SECONDS);
    return $output;
}

/**
 * Compact navigation menu function.
 *
 * @return string
 */
function compact_nav() {
    global $wp;
    $current_url = md5(home_url(add_query_arg(array(), $wp->request)));
    $cache_key = 'compact_nav_' . get_current_blog_id() . '_' . $current_url;
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }
    $output = wp_nav_menu([
        'theme_location' => 'compact_navigation',
        'menu_class' => 'nav accordion',
        'depth' => 3,
        'echo' => false,
        'walker' => new \App\Walker\Accordion_Walker_Nav_Menu()
    ]);
    set_transient($cache_key, $output, HOUR_IN_SECONDS);
    return $output;
}

/**
 * Footer navigation menu function.
 *
 * @return string
 */
function footer_nav() {
    global $wp;
    $current_url = md5(home_url(add_query_arg(array(), $wp->request)));
    $cache_key = 'footer_nav_' . get_current_blog_id() . '_' . $current_url;
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }
    $output = wp_nav_menu([
        'theme_location' => 'footer_navigation',
        'menu_class' => 'nav vertical',
        'depth' => 1,
        'echo' => false,
    ]);
    set_transient($cache_key, $output, HOUR_IN_SECONDS);
    return $output;
}

/**
 * Privacy navigation menu function.
 *
 * @return string
 */
function privacy_nav() {
    global $wp;
    $current_url = md5(home_url(add_query_arg(array(), $wp->request)));
    $cache_key = 'privacy_nav_' . get_current_blog_id() . '_' . $current_url;
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }
    $output = wp_nav_menu([
        'theme_location' => 'privacy_navigation',
        'menu_class' => 'nav',
        'depth' => 1,
        'echo' => false,
    ]);
    set_transient($cache_key, $output, HOUR_IN_SECONDS);
    return $output;
}

