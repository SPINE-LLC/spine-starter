<?php

/**
 * Customizer settings.
 */

namespace App;

/**
 * Register customizer settings.
 *
 * @param  WP_Customize_Manager  $wp_customize
 * @return void
 */
add_action(
    'customize_register',
    function ($wp_customize) {
        // Organization Section
        $wp_customize->add_section(
            'organization',
            [
                'title' => __('Organization', 'sage'),
                'priority' => 30,
            ]
        );

        // Facebook URL
        $wp_customize->add_setting(
            'organization_fb_url',
            [
                'default' => '',
                'sanitize_callback' => 'esc_url_raw',
            ]
        );

        $wp_customize->add_control(
            'organization_fb_url',
            [
                'label' => __('Facebook URL', 'sage'),
                'section' => 'organization',
                'type' => 'url',
            ]
        );

        // X URL
        $wp_customize->add_setting(
            'organization_x_url',
            [
                'default' => '',
                'sanitize_callback' => 'esc_url_raw',
            ]
        );

        $wp_customize->add_control(
            'organization_x_url',
            [
                'label' => __('X URL', 'sage'),
                'section' => 'organization',
                'type' => 'url',
            ]
        );

        // LinkedIn URL
        $wp_customize->add_setting(
            'organization_li_url',
            [
                'default' => '',
                'sanitize_callback' => 'esc_url_raw',
            ]
        );

        $wp_customize->add_control(
            'organization_li_url',
            [
                'label' => __('LinkedIn URL', 'sage'),
                'section' => 'organization',
                'type' => 'url',
            ]
        );

        // YouTube URL
        $wp_customize->add_setting(
            'organization_yt_url',
            [
                'default' => '',
                'sanitize_callback' => 'esc_url_raw',
            ]
        );

        $wp_customize->add_control(
            'organization_yt_url',
            [
                'label' => __('YouTube URL', 'sage'),
                'section' => 'organization',
                'type' => 'url',
            ]
        );

        // YouTube Subscribe Popup
        $wp_customize->add_setting(
            'organization_yt_sub',
            [
                'default' => true,
                'sanitize_callback' => 'wp_validate_boolean',
            ]
        );

        $wp_customize->add_control(
            'organization_yt_sub',
            [
                'label' => __('YouTube Subscribe Popup', 'sage'),
                'description' => __('Open the subscription popup on YouTube?', 'sage'),
                'section' => 'organization',
                'type' => 'checkbox',
            ]
        );

        // Instagram URL
        $wp_customize->add_setting(
            'organization_ig_url',
            [
                'default' => '',
                'sanitize_callback' => 'esc_url_raw',
            ]
        );

        $wp_customize->add_control(
            'organization_ig_url',
            [
                'label' => __('Instagram URL', 'sage'),
                'section' => 'organization',
                'type' => 'url',
            ]
        );

        // Snapchat URL
        $wp_customize->add_setting(
            'organization_sc_url',
            [
                'default' => '',
                'sanitize_callback' => 'esc_url_raw',
            ]
        );

        $wp_customize->add_control(
            'organization_sc_url',
            [
                'label' => __('Snapchat URL', 'sage'),
                'section' => 'organization',
                'type' => 'url',
            ]
        );
    }
);
