<?php
/**
 * Shoobu Theme Customizer Settings
 *
 * @package Shoobu
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Customizer Settings
 */
function shoobu_customize_register($wp_customize) {
    
    // ======================================
    // PANEL: Homepage Sections
    // ======================================
    $wp_customize->add_panel('shoobu_homepage_panel', array(
        'title'       => __('Homepage Sections', 'shoobu'),
        'description' => __('Customize the homepage sections', 'shoobu'),
        'priority'    => 30,
    ));

    // ----------------------------------
    // Section: Hero Slider
    // ----------------------------------
    $wp_customize->add_section('shoobu_hero_section', array(
        'title'    => __('Hero Slider', 'shoobu'),
        'panel'    => 'shoobu_homepage_panel',
        'priority' => 10,
    ));

    // Slide 1
    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("shoobu_hero_slide{$i}_subtitle", array(
            'default'           => 'Hurry Up! Enjoy Sale Madness!',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("shoobu_hero_slide{$i}_subtitle", array(
            'label'   => sprintf(__('Slide %d Subtitle', 'shoobu'), $i),
            'section' => 'shoobu_hero_section',
            'type'    => 'text',
        ));

        $wp_customize->add_setting("shoobu_hero_slide{$i}_title", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("shoobu_hero_slide{$i}_title", array(
            'label'   => sprintf(__('Slide %d Title', 'shoobu'), $i),
            'section' => 'shoobu_hero_section',
            'type'    => 'text',
        ));

        $wp_customize->add_setting("shoobu_hero_slide{$i}_desc", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("shoobu_hero_slide{$i}_desc", array(
            'label'   => sprintf(__('Slide %d Description', 'shoobu'), $i),
            'section' => 'shoobu_hero_section',
            'type'    => 'textarea',
        ));

        $wp_customize->add_setting("shoobu_hero_slide{$i}_image", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "shoobu_hero_slide{$i}_image", array(
            'label'   => sprintf(__('Slide %d Image', 'shoobu'), $i),
            'section' => 'shoobu_hero_section',
        )));
    }

    // ----------------------------------
    // Section: Promotional Banners
    // ----------------------------------
    $wp_customize->add_section('shoobu_promo_section', array(
        'title'    => __('Promotional Banners', 'shoobu'),
        'panel'    => 'shoobu_homepage_panel',
        'priority' => 20,
    ));

    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("shoobu_promo{$i}_title", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("shoobu_promo{$i}_title", array(
            'label'   => sprintf(__('Banner %d Title', 'shoobu'), $i),
            'section' => 'shoobu_promo_section',
            'type'    => 'text',
        ));

        $wp_customize->add_setting("shoobu_promo{$i}_image", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "shoobu_promo{$i}_image", array(
            'label'   => sprintf(__('Banner %d Image', 'shoobu'), $i),
            'section' => 'shoobu_promo_section',
        )));

        $wp_customize->add_setting("shoobu_promo{$i}_link", array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("shoobu_promo{$i}_link", array(
            'label'   => sprintf(__('Banner %d Link', 'shoobu'), $i),
            'section' => 'shoobu_promo_section',
            'type'    => 'url',
        ));
    }

    // ----------------------------------
    // Section: Featured Products
    // ----------------------------------
    $wp_customize->add_section('shoobu_featured_section', array(
        'title'    => __('Featured Products', 'shoobu'),
        'panel'    => 'shoobu_homepage_panel',
        'priority' => 30,
    ));

    $wp_customize->add_setting('shoobu_featured_title', array(
        'default'           => __('Featured Products', 'shoobu'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('shoobu_featured_title', array(
        'label'   => __('Section Title', 'shoobu'),
        'section' => 'shoobu_featured_section',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('shoobu_featured_subtitle', array(
        'default'           => __('Trending items our customers love', 'shoobu'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('shoobu_featured_subtitle', array(
        'label'   => __('Section Subtitle', 'shoobu'),
        'section' => 'shoobu_featured_section',
        'type'    => 'text',
    ));

    // ----------------------------------
    // Section: Premium Tech Text
    // ----------------------------------
    $wp_customize->add_section('shoobu_premium_section', array(
        'title'    => __('Premium Tech Section', 'shoobu'),
        'panel'    => 'shoobu_homepage_panel',
        'priority' => 40,
    ));

    $wp_customize->add_setting('shoobu_premium_title', array(
        'default'           => __('Premium Tech,', 'shoobu'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('shoobu_premium_title', array(
        'label'   => __('Title', 'shoobu'),
        'section' => 'shoobu_premium_section',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('shoobu_premium_title_highlight', array(
        'default'           => __('Unbeatable Prices', 'shoobu'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('shoobu_premium_title_highlight', array(
        'label'   => __('Title Highlight (Gradient)', 'shoobu'),
        'section' => 'shoobu_premium_section',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('shoobu_premium_description', array(
        'default'           => __('Discover our curated collection of the latest tech gadgets and accessories. Fast shipping, secure checkout, and 30-day returns guaranteed.', 'shoobu'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('shoobu_premium_description', array(
        'label'   => __('Description', 'shoobu'),
        'section' => 'shoobu_premium_section',
        'type'    => 'textarea',
    ));

    // ----------------------------------
    // Section: Features Row
    // ----------------------------------
    $wp_customize->add_section('shoobu_features_section', array(
        'title'    => __('Features Row', 'shoobu'),
        'panel'    => 'shoobu_homepage_panel',
        'priority' => 50,
    ));

    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting("shoobu_feature{$i}_title", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("shoobu_feature{$i}_title", array(
            'label'   => sprintf(__('Feature %d Title', 'shoobu'), $i),
            'section' => 'shoobu_features_section',
            'type'    => 'text',
        ));

        $wp_customize->add_setting("shoobu_feature{$i}_desc", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));
        $wp_customize->add_control("shoobu_feature{$i}_desc", array(
            'label'   => sprintf(__('Feature %d Description', 'shoobu'), $i),
            'section' => 'shoobu_features_section',
            'type'    => 'text',
        ));
    }

    // ======================================
    // PANEL: Mobile Footer Navbar
    // ======================================
    $wp_customize->add_panel('shoobu_mobile_nav_panel', array(
        'title'       => __('Mobile Footer Navbar', 'shoobu'),
        'description' => __('Customize the mobile footer navigation', 'shoobu'),
        'priority'    => 35,
    ));

    $wp_customize->add_section('shoobu_mobile_nav_settings', array(
        'title'    => __('Navigation Settings', 'shoobu'),
        'panel'    => 'shoobu_mobile_nav_panel',
        'priority' => 10,
    ));

    $wp_customize->add_setting('shoobu_mobile_nav_show', array(
        'default'           => true,
        'sanitize_callback' => 'shoobu_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('shoobu_mobile_nav_show', array(
        'label'   => __('Show Mobile Footer Navigation', 'shoobu'),
        'section' => 'shoobu_mobile_nav_settings',
        'type'    => 'checkbox',
    ));

    // ======================================
    // PANEL: Theme Styling
    // ======================================
    $wp_customize->add_panel('shoobu_styling_panel', array(
        'title'       => __('Theme Styling', 'shoobu'),
        'description' => __('Customize colors and styling', 'shoobu'),
        'priority'    => 40,
    ));

    $wp_customize->add_section('shoobu_colors_section', array(
        'title'    => __('Colors', 'shoobu'),
        'panel'    => 'shoobu_styling_panel',
        'priority' => 10,
    ));

    $wp_customize->add_setting('shoobu_primary_color', array(
        'default'           => '#9333ea',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'shoobu_primary_color', array(
        'label'   => __('Primary Color', 'shoobu'),
        'section' => 'shoobu_colors_section',
    )));

    $wp_customize->add_setting('shoobu_secondary_color', array(
        'default'           => '#3b82f6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'shoobu_secondary_color', array(
        'label'   => __('Secondary Color', 'shoobu'),
        'section' => 'shoobu_colors_section',
    )));
}
add_action('customize_register', 'shoobu_customize_register');

/**
 * Sanitize Checkbox
 */
function shoobu_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Output Custom CSS
 */
function shoobu_customizer_css() {
    $primary = get_theme_mod('shoobu_primary_color', '#9333ea');
    $secondary = get_theme_mod('shoobu_secondary_color', '#3b82f6');
    ?>
    <style type="text/css">
        :root {
            --shoobu-primary: <?php echo esc_attr($primary); ?>;
            --shoobu-secondary: <?php echo esc_attr($secondary); ?>;
        }
        .bg-purple-600, .btn-primary { background-color: <?php echo esc_attr($primary); ?>; }
        .text-purple-600 { color: <?php echo esc_attr($primary); ?>; }
        .border-purple-500 { border-color: <?php echo esc_attr($primary); ?>; }
        .text-gradient {
            background: linear-gradient(to right, <?php echo esc_attr($primary); ?>, <?php echo esc_attr($secondary); ?>);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .animate-gradient-text {
            background: linear-gradient(to right, <?php echo esc_attr($primary); ?>, <?php echo esc_attr($secondary); ?>, <?php echo esc_attr($primary); ?>);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
    <?php
}
add_action('wp_head', 'shoobu_customizer_css');
