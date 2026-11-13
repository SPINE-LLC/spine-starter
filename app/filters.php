<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Keeps Acorn's version out of the response headers.
 */
add_filter('acorn/powered_by', '__return_false');

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});
