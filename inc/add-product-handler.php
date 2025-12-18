<?php
/**
 * Shoobu Add Product Handler
 *
 * @package Shoobu
 */

if (!defined('ABSPATH')) {
    exit;
}

function shoobu_handle_add_product() {
    if (!isset($_POST['shoobu_add_product_nonce']) || 
        !wp_verify_nonce($_POST['shoobu_add_product_nonce'], 'shoobu_add_product')) {
        return;
    }
    
    if (!is_user_logged_in()) {
        wp_redirect(wp_login_url());
        exit;
    }
    
    $title = sanitize_text_field($_POST['product_title']);
    $description = wp_kses_post($_POST['product_description']);
    $short_description = sanitize_textarea_field($_POST['product_short_description']);
    $price = floatval($_POST['product_price']);
    $sale_price = floatval($_POST['product_sale_price']);
    $sku = sanitize_text_field($_POST['product_sku']);
    $stock = intval($_POST['product_stock']);
    $category = intval($_POST['product_category']);
    
    $post_data = array(
        'post_title'   => $title,
        'post_content' => $description,
        'post_status'  => 'pending',
        'post_type'    => 'shoobu_product',
        'post_author'  => get_current_user_id(),
    );
    
    $post_id = wp_insert_post($post_data);
    
    if (!is_wp_error($post_id)) {
        update_post_meta($post_id, '_shoobu_price', $price);
        update_post_meta($post_id, '_shoobu_sale_price', $sale_price);
        update_post_meta($post_id, '_shoobu_short_description', $short_description);
        update_post_meta($post_id, '_shoobu_sku', $sku);
        update_post_meta($post_id, '_shoobu_stock', $stock);
        
        if ($category) {
            wp_set_object_terms($post_id, $category, 'shoobu_category');
        }
        
        if (!empty($_FILES['product_image']['name'])) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            
            $attachment_id = media_handle_upload('product_image', $post_id);
            if (!is_wp_error($attachment_id)) {
                set_post_thumbnail($post_id, $attachment_id);
            }
        }
        
        wp_redirect(add_query_arg('product_added', '1', get_permalink()));
        exit;
    }
}
add_action('template_redirect', 'shoobu_handle_add_product');

function shoobu_ajax_add_to_cart() {
    check_ajax_referer('shoobu_nonce', 'nonce');
    
    $product_id = intval($_POST['product_id']);
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    if (!$product_id) {
        wp_send_json_error(array('message' => __('Invalid product', 'shoobu')));
    }
    
    shoobu_add_to_cart($product_id, $quantity);
    
    wp_send_json_success(array(
        'message'    => __('Product added to cart', 'shoobu'),
        'cart_count' => shoobu_get_cart_count(),
        'cart_total' => shoobu_format_price(shoobu_get_cart_total()),
    ));
}
add_action('wp_ajax_shoobu_add_to_cart', 'shoobu_ajax_add_to_cart');
add_action('wp_ajax_nopriv_shoobu_add_to_cart', 'shoobu_ajax_add_to_cart');

function shoobu_ajax_remove_from_cart() {
    check_ajax_referer('shoobu_nonce', 'nonce');
    
    $product_id = intval($_POST['product_id']);
    
    if (!$product_id) {
        wp_send_json_error(array('message' => __('Invalid product', 'shoobu')));
    }
    
    shoobu_remove_from_cart($product_id);
    
    wp_send_json_success(array(
        'message'    => __('Product removed from cart', 'shoobu'),
        'cart_count' => shoobu_get_cart_count(),
        'cart_total' => shoobu_format_price(shoobu_get_cart_total()),
    ));
}
add_action('wp_ajax_shoobu_remove_from_cart', 'shoobu_ajax_remove_from_cart');
add_action('wp_ajax_nopriv_shoobu_remove_from_cart', 'shoobu_ajax_remove_from_cart');

function shoobu_ajax_update_cart() {
    check_ajax_referer('shoobu_nonce', 'nonce');
    
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    
    if (!$product_id) {
        wp_send_json_error(array('message' => __('Invalid product', 'shoobu')));
    }
    
    if ($quantity <= 0) {
        shoobu_remove_from_cart($product_id);
    } else {
        $_SESSION['shoobu_cart'][$product_id]['quantity'] = $quantity;
    }
    
    wp_send_json_success(array(
        'message'    => __('Cart updated', 'shoobu'),
        'cart_count' => shoobu_get_cart_count(),
        'cart_total' => shoobu_format_price(shoobu_get_cart_total()),
    ));
}
add_action('wp_ajax_shoobu_update_cart', 'shoobu_ajax_update_cart');
add_action('wp_ajax_nopriv_shoobu_update_cart', 'shoobu_ajax_update_cart');
