<?php
/**
 * Shoobu Theme Customizer
 *
 * @package Shoobu
 */

if (!defined('ABSPATH')) {
    exit;
}

function shoobu_customize_register($wp_customize) {
    $wp_customize->add_section('shoobu_hero', array(
        'title'    => __('Hero Section', 'shoobu'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('shoobu_hero_title', array(
        'default'           => 'Premium Tech at Your Fingertips',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('shoobu_hero_title', array(
        'label'   => __('Hero Title', 'shoobu'),
        'section' => 'shoobu_hero',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('shoobu_hero_subtitle', array(
        'default'           => 'Discover the latest in tech accessories',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('shoobu_hero_subtitle', array(
        'label'   => __('Hero Subtitle', 'shoobu'),
        'section' => 'shoobu_hero',
        'type'    => 'text',
    ));
}
add_action('customize_register', 'shoobu_customize_register');

function shoobu_get_option($key, $default = '') {
    return get_theme_mod('shoobu_' . $key, $default);
}
