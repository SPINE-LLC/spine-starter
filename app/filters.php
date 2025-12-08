<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * Remove default WordPress color palette from theme.json.
 */
add_filter('wp_theme_json_data_default', function ($theme_json) {
    $data = $theme_json->get_data();
    // Empty the default color palette from core (removes CSS vars like --wp--preset--color--pale-pink)
    if (isset($data['settings']['color']['palette']['default'])) {
        $data['settings']['color']['palette']['default'] = [];
    }
    if (isset($data['settings']['color']['gradients']['default'])) {
        $data['settings']['color']['gradients']['default'] = [];
    }
    if (isset($data['settings']['color']['duotone']['default'])) {
        $data['settings']['color']['duotone']['default'] = [];
    }
    // Re-apply the updated data
    $theme_json->update_with($data);
    return $theme_json;
});
