<?php

/**
 * Vertical position detection setup and functions.
 */

namespace App;

/**
 * Add top position detection element.
 *
 * @return void
 */
function add_top_detection() {
	echo '<div id="position-top" data-position="is-at-top"></div>';
}
add_action( 'wp_body_open', 'App\add_top_detection' );

/**
 * Add bottom position detection element.
 *
 * @return void
 */
function add_bottom_detection() {
    echo '<div id="position-bottom" data-position="is-at-bottom"></div>';
}
add_action( 'wp_footer', 'App\add_bottom_detection' );
