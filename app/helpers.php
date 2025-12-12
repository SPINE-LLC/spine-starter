<?php

/**
 * Theme helper functions.
 */

namespace App;

/**
 * Check if any social links are configured.
 *
 * @return bool True if any social links are set, false otherwise.
 */
function has_social_links() {
    return get_theme_mod( 'organization_fb_url', '' ) ||
           get_theme_mod( 'organization_x_url', '' ) ||
           get_theme_mod( 'organization_li_url', '' ) ||
           get_theme_mod( 'organization_yt_url', '' ) ||
           get_theme_mod( 'organization_ig_url', '' ) ||
           get_theme_mod( 'organization_sc_url', '' );
}
