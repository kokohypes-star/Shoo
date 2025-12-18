<?php
/**
 * Shoobu Helper Functions
 *
 * @package Shoobu
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get Cart Items from Session/Cookie
 */
function shoobu_get_cart_items() {
    return array();
}

/**
 * Get Cart Count
 */
function shoobu_get_cart_count() {
    return 0;
}

/**
 * Get Product Price Display
 */
function shoobu_get_product_price($product_id) {
    $price = get_post_meta($product_id, '_shoobu_price', true);
    $sale_price = get_post_meta($product_id, '_shoobu_sale_price', true);
    
    if ($sale_price && $sale_price < $price) {
        return '<span class="sale-price">' . shoobu_format_price($sale_price) . '</span> <span class="original-price line-through text-gray-400">' . shoobu_format_price($price) . '</span>';
    }
    
    return shoobu_format_price($price);
}

/**
 * Check if Mobile Footer Nav Should Show
 */
function shoobu_show_mobile_nav() {
    return get_theme_mod('shoobu_mobile_nav_show', true);
}

/**
 * Get Category Icon SVG
 */
function shoobu_get_category_icon($category_slug) {
    $icons = array(
        'audio' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/></svg>',
        'wearables' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="7"/><polyline points="12 9 12 12 13.5 13.5"/><path d="M16.51 17.35l-.35 3.83a2 2 0 0 1-2 1.82H9.83a2 2 0 0 1-2-1.82l-.35-3.83m.01-10.7l.35-3.83A2 2 0 0 1 9.83 1h4.35a2 2 0 0 1 2 1.82l.35 3.83"/></svg>',
        'cables' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 9a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9z"/><path d="M8 7V3m8 4V3M4 10h16"/></svg>',
        'accessories' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
        'chargers' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18h6"/><path d="M10 22h4"/><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14"/></svg>',
    );
    
    return isset($icons[$category_slug]) ? $icons[$category_slug] : '';
}

/**
 * Breadcrumb
 */
function shoobu_breadcrumb() {
    if (is_front_page()) {
        return;
    }
    
    echo '<nav class="breadcrumb text-sm text-gray-500 mb-4">';
    echo '<a href="' . esc_url(home_url('/')) . '">' . __('Home', 'shoobu') . '</a>';
    echo ' <span class="separator">/</span> ';
    
    if (is_singular('shoobu_product')) {
        echo '<a href="' . esc_url(get_post_type_archive_link('shoobu_product')) . '">' . __('Products', 'shoobu') . '</a>';
        echo ' <span class="separator">/</span> ';
        echo '<span class="current">' . get_the_title() . '</span>';
    } elseif (is_post_type_archive('shoobu_product')) {
        echo '<span class="current">' . __('Products', 'shoobu') . '</span>';
    } elseif (is_tax('shoobu_category')) {
        echo '<a href="' . esc_url(get_post_type_archive_link('shoobu_product')) . '">' . __('Products', 'shoobu') . '</a>';
        echo ' <span class="separator">/</span> ';
        echo '<span class="current">' . single_term_title('', false) . '</span>';
    } elseif (is_search()) {
        echo '<span class="current">' . sprintf(__('Search: %s', 'shoobu'), get_search_query()) . '</span>';
    } elseif (is_page()) {
        echo '<span class="current">' . get_the_title() . '</span>';
    }
    
    echo '</nav>';
}

/**
 * Pagination
 */
function shoobu_pagination($query = null) {
    global $wp_query;
    $query = $query ?: $wp_query;
    
    $big = 999999999;
    $pages = paginate_links(array(
        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'    => '?paged=%#%',
        'current'   => max(1, get_query_var('paged')),
        'total'     => $query->max_num_pages,
        'type'      => 'array',
        'prev_text' => '&laquo;',
        'next_text' => '&raquo;',
    ));
    
    if (is_array($pages) && count($pages) > 1) {
        echo '<nav class="pagination flex items-center justify-center gap-2 mt-8">';
        foreach ($pages as $page) {
            echo $page;
        }
        echo '</nav>';
    }
}
