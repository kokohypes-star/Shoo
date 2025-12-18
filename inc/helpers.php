<?php
/**
 * Shoobu Helper Functions
 *
 * @package Shoobu
 */

if (!defined('ABSPATH')) {
    exit;
}

function shoobu_get_products($args = array()) {
    $defaults = array(
        'post_type'      => 'shoobu_product',
        'posts_per_page' => 12,
        'post_status'    => 'publish',
    );
    
    $args = wp_parse_args($args, $defaults);
    return new WP_Query($args);
}

function shoobu_get_featured_products($limit = 8) {
    return shoobu_get_products(array(
        'posts_per_page' => $limit,
        'meta_key'       => '_shoobu_featured',
        'meta_value'     => '1',
    ));
}

function shoobu_get_product_categories() {
    return get_terms(array(
        'taxonomy'   => 'shoobu_category',
        'hide_empty' => false,
    ));
}

function shoobu_get_cart() {
    if (!isset($_SESSION['shoobu_cart'])) {
        $_SESSION['shoobu_cart'] = array();
    }
    return $_SESSION['shoobu_cart'];
}

function shoobu_get_cart_count() {
    $cart = shoobu_get_cart();
    return array_sum(array_column($cart, 'quantity'));
}

function shoobu_get_cart_total() {
    $cart = shoobu_get_cart();
    $total = 0;
    
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    
    return $total;
}

function shoobu_add_to_cart($product_id, $quantity = 1) {
    if (!isset($_SESSION['shoobu_cart'])) {
        $_SESSION['shoobu_cart'] = array();
    }
    
    $price = get_post_meta($product_id, '_shoobu_sale_price', true);
    if (empty($price)) {
        $price = get_post_meta($product_id, '_shoobu_price', true);
    }
    
    if (isset($_SESSION['shoobu_cart'][$product_id])) {
        $_SESSION['shoobu_cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['shoobu_cart'][$product_id] = array(
            'product_id' => $product_id,
            'quantity'   => $quantity,
            'price'      => floatval($price),
        );
    }
    
    return true;
}

function shoobu_remove_from_cart($product_id) {
    if (isset($_SESSION['shoobu_cart'][$product_id])) {
        unset($_SESSION['shoobu_cart'][$product_id]);
    }
    return true;
}

function shoobu_clear_cart() {
    $_SESSION['shoobu_cart'] = array();
    return true;
}

function shoobu_get_breadcrumbs() {
    $breadcrumbs = array();
    $breadcrumbs[] = array(
        'title' => __('Home', 'shoobu'),
        'url'   => home_url('/'),
    );
    
    if (is_singular('shoobu_product')) {
        $breadcrumbs[] = array(
            'title' => __('Products', 'shoobu'),
            'url'   => get_post_type_archive_link('shoobu_product'),
        );
        $breadcrumbs[] = array(
            'title' => get_the_title(),
            'url'   => '',
        );
    } elseif (is_post_type_archive('shoobu_product')) {
        $breadcrumbs[] = array(
            'title' => __('Products', 'shoobu'),
            'url'   => '',
        );
    }
    
    return $breadcrumbs;
}
