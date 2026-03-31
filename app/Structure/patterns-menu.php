<?php

/**
 * Add Patterns to the Appearance menu in wp-admin.
 */

namespace App;

add_action('admin_menu', function () {
    add_submenu_page(
        'themes.php',
        __('Patterns', 'sage'),
        __('Patterns', 'sage'),
        'edit_posts',
        'edit.php?post_type=wp_block'
    );
});
