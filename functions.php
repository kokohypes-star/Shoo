<?php
/**
 * Shoobu Theme Functions
 *
 * @package Shoobu
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

define('SHOOBU_VERSION', '1.0.0');
define('SHOOBU_DIR', get_template_directory());
define('SHOOBU_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function shoobu_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    add_theme_support('customize-selective-refresh-widgets');

    register_nav_menus(array(
        'primary'       => __('Primary Menu', 'shoobu'),
        'mobile_footer' => __('Mobile Footer Menu', 'shoobu'),
    ));

    add_image_size('shoobu-product', 400, 400, true);
    add_image_size('shoobu-hero', 800, 600, true);
    add_image_size('shoobu-banner', 400, 300, true);
}
add_action('after_setup_theme', 'shoobu_setup');

/**
 * Enqueue Scripts and Styles
 */
function shoobu_scripts() {
    wp_enqueue_style('shoobu-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap', array(), null);
    wp_enqueue_style('shoobu-style', get_stylesheet_uri(), array(), SHOOBU_VERSION);
    wp_enqueue_style('shoobu-main', SHOOBU_URI . '/assets/css/main.css', array('shoobu-style'), SHOOBU_VERSION);

    wp_enqueue_script('shoobu-main', SHOOBU_URI . '/assets/js/main.js', array(), SHOOBU_VERSION, true);
    wp_enqueue_script('shoobu-cart', SHOOBU_URI . '/assets/js/cart.js', array('shoobu-main'), SHOOBU_VERSION, true);

    wp_localize_script('shoobu-main', 'shoobuData', array(
        'ajaxUrl'   => admin_url('admin-ajax.php'),
        'nonce'     => wp_create_nonce('shoobu_nonce'),
        'homeUrl'   => home_url(),
        'themeUrl'  => SHOOBU_URI,
    ));
}
add_action('wp_enqueue_scripts', 'shoobu_scripts');

/**
 * Register Custom Post Type: Products
 */
function shoobu_register_product_post_type() {
    $labels = array(
        'name'                  => __('Products', 'shoobu'),
        'singular_name'         => __('Product', 'shoobu'),
        'menu_name'             => __('Products', 'shoobu'),
        'add_new'               => __('Add New', 'shoobu'),
        'add_new_item'          => __('Add New Product', 'shoobu'),
        'edit_item'             => __('Edit Product', 'shoobu'),
        'new_item'              => __('New Product', 'shoobu'),
        'view_item'             => __('View Product', 'shoobu'),
        'search_items'          => __('Search Products', 'shoobu'),
        'not_found'             => __('No products found', 'shoobu'),
        'not_found_in_trash'    => __('No products found in trash', 'shoobu'),
        'all_items'             => __('All Products', 'shoobu'),
        'archives'              => __('Product Archives', 'shoobu'),
        'featured_image'        => __('Product Image', 'shoobu'),
        'set_featured_image'    => __('Set product image', 'shoobu'),
        'remove_featured_image' => __('Remove product image', 'shoobu'),
        'use_featured_image'    => __('Use as product image', 'shoobu'),
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'product'),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-products',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'        => true,
    );

    register_post_type('shoobu_product', $args);
}
add_action('init', 'shoobu_register_product_post_type');

/**
 * Register Product Categories Taxonomy
 */
function shoobu_register_product_taxonomy() {
    $labels = array(
        'name'              => __('Product Categories', 'shoobu'),
        'singular_name'     => __('Category', 'shoobu'),
        'search_items'      => __('Search Categories', 'shoobu'),
        'all_items'         => __('All Categories', 'shoobu'),
        'parent_item'       => __('Parent Category', 'shoobu'),
        'parent_item_colon' => __('Parent Category:', 'shoobu'),
        'edit_item'         => __('Edit Category', 'shoobu'),
        'update_item'       => __('Update Category', 'shoobu'),
        'add_new_item'      => __('Add New Category', 'shoobu'),
        'new_item_name'     => __('New Category Name', 'shoobu'),
        'menu_name'         => __('Categories', 'shoobu'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'product-category'),
        'show_in_rest'      => true,
    );

    register_taxonomy('shoobu_category', array('shoobu_product'), $args);
}
add_action('init', 'shoobu_register_product_taxonomy');

/**
 * Add Product Meta Boxes
 */
function shoobu_add_product_meta_boxes() {
    add_meta_box(
        'shoobu_product_details',
        __('Product Details', 'shoobu'),
        'shoobu_product_meta_box_callback',
        'shoobu_product',
        'normal',
        'high'
    );

    add_meta_box(
        'shoobu_product_gallery',
        __('Product Gallery', 'shoobu'),
        'shoobu_gallery_meta_box_callback',
        'shoobu_product',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'shoobu_add_product_meta_boxes');

/**
 * Product Details Meta Box Callback
 */
function shoobu_product_meta_box_callback($post) {
    wp_nonce_field('shoobu_product_meta', 'shoobu_product_meta_nonce');

    $price = get_post_meta($post->ID, '_shoobu_price', true);
    $sale_price = get_post_meta($post->ID, '_shoobu_sale_price', true);
    $short_desc = get_post_meta($post->ID, '_shoobu_short_description', true);
    $sku = get_post_meta($post->ID, '_shoobu_sku', true);
    $stock = get_post_meta($post->ID, '_shoobu_stock', true);
    $rating = get_post_meta($post->ID, '_shoobu_rating', true);
    ?>
    <div class="shoobu-meta-box">
        <p>
            <label for="shoobu_price"><strong><?php _e('Price', 'shoobu'); ?></strong></label><br>
            <input type="number" id="shoobu_price" name="shoobu_price" value="<?php echo esc_attr($price); ?>" step="0.01" min="0" style="width: 100%;">
        </p>
        <p>
            <label for="shoobu_sale_price"><strong><?php _e('Sale Price (optional)', 'shoobu'); ?></strong></label><br>
            <input type="number" id="shoobu_sale_price" name="shoobu_sale_price" value="<?php echo esc_attr($sale_price); ?>" step="0.01" min="0" style="width: 100%;">
        </p>
        <p>
            <label for="shoobu_short_description"><strong><?php _e('Short Description', 'shoobu'); ?></strong></label><br>
            <textarea id="shoobu_short_description" name="shoobu_short_description" rows="3" style="width: 100%;"><?php echo esc_textarea($short_desc); ?></textarea>
        </p>
        <p>
            <label for="shoobu_sku"><strong><?php _e('SKU', 'shoobu'); ?></strong></label><br>
            <input type="text" id="shoobu_sku" name="shoobu_sku" value="<?php echo esc_attr($sku); ?>" style="width: 100%;">
        </p>
        <p>
            <label for="shoobu_stock"><strong><?php _e('Stock Quantity', 'shoobu'); ?></strong></label><br>
            <input type="number" id="shoobu_stock" name="shoobu_stock" value="<?php echo esc_attr($stock); ?>" min="0" style="width: 100%;">
        </p>
        <p>
            <label for="shoobu_rating"><strong><?php _e('Rating (1-5)', 'shoobu'); ?></strong></label><br>
            <input type="number" id="shoobu_rating" name="shoobu_rating" value="<?php echo esc_attr($rating); ?>" min="1" max="5" step="0.1" style="width: 100%;">
        </p>
    </div>
    <?php
}

/**
 * Gallery Meta Box Callback
 */
function shoobu_gallery_meta_box_callback($post) {
    $gallery_ids = get_post_meta($post->ID, '_shoobu_gallery', true);
    $gallery_ids = is_array($gallery_ids) ? $gallery_ids : array();
    ?>
    <div id="shoobu-gallery-container">
        <div id="shoobu-gallery-images">
            <?php foreach ($gallery_ids as $id) : 
                $image = wp_get_attachment_image_src($id, 'thumbnail');
                if ($image) : ?>
                    <div class="shoobu-gallery-image" data-id="<?php echo esc_attr($id); ?>">
                        <img src="<?php echo esc_url($image[0]); ?>" alt="">
                        <button type="button" class="remove-image">&times;</button>
                        <input type="hidden" name="shoobu_gallery[]" value="<?php echo esc_attr($id); ?>">
                    </div>
                <?php endif;
            endforeach; ?>
        </div>
        <button type="button" id="shoobu-add-gallery" class="button"><?php _e('Add Images', 'shoobu'); ?></button>
    </div>
    <style>
        #shoobu-gallery-images { display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 10px; }
        .shoobu-gallery-image { position: relative; width: 60px; height: 60px; }
        .shoobu-gallery-image img { width: 100%; height: 100%; object-fit: cover; border-radius: 4px; }
        .shoobu-gallery-image .remove-image { position: absolute; top: -5px; right: -5px; background: #dc3232; color: #fff; border: none; border-radius: 50%; width: 18px; height: 18px; cursor: pointer; font-size: 12px; line-height: 1; }
    </style>
    <?php
}

/**
 * Save Product Meta
 */
function shoobu_save_product_meta($post_id) {
    if (!isset($_POST['shoobu_product_meta_nonce']) || !wp_verify_nonce($_POST['shoobu_product_meta_nonce'], 'shoobu_product_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array(
        'shoobu_price'             => '_shoobu_price',
        'shoobu_sale_price'        => '_shoobu_sale_price',
        'shoobu_short_description' => '_shoobu_short_description',
        'shoobu_sku'               => '_shoobu_sku',
        'shoobu_stock'             => '_shoobu_stock',
        'shoobu_rating'            => '_shoobu_rating',
    );

    foreach ($fields as $post_key => $meta_key) {
        if (isset($_POST[$post_key])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$post_key]));
        }
    }

    if (isset($_POST['shoobu_gallery'])) {
        $gallery = array_map('intval', $_POST['shoobu_gallery']);
        update_post_meta($post_id, '_shoobu_gallery', $gallery);
    } else {
        delete_post_meta($post_id, '_shoobu_gallery');
    }
}
add_action('save_post_shoobu_product', 'shoobu_save_product_meta');

/**
 * Include Customizer Settings
 */
require_once SHOOBU_DIR . '/inc/customizer.php';

/**
 * Include Helper Functions
 */
require_once SHOOBU_DIR . '/inc/helpers.php';

/**
 * Include Add Product Handler
 */
require_once SHOOBU_DIR . '/inc/add-product-handler.php';

/**
 * Create Default Product Categories on Theme Activation
 */
function shoobu_create_default_categories() {
    $categories = array('Audio', 'Wearables', 'Cables', 'Accessories', 'Chargers');
    
    foreach ($categories as $cat) {
        if (!term_exists($cat, 'shoobu_category')) {
            wp_insert_term($cat, 'shoobu_category');
        }
    }
}
add_action('after_switch_theme', 'shoobu_create_default_categories');

/**
 * Create Default Pages (Cart, Checkout, Login, Account) on Theme Activation
 */
function shoobu_create_default_pages() {
    $pages = array(
        'cart' => array(
            'title'    => 'Shopping Cart',
            'template' => 'page-cart.php'
        ),
        'checkout' => array(
            'title'    => 'Checkout',
            'template' => 'page-checkout.php'
        ),
        'login' => array(
            'title'    => 'Login',
            'template' => 'page-login.php'
        ),
        'account' => array(
            'title'    => 'My Account',
            'template' => 'page-account.php'
        )
    );
    
    foreach ($pages as $slug => $page_data) {
        // Check if page already exists
        $existing_page = get_page_by_path($slug);
        
        if (!$existing_page) {
            // Create the page
            $page_id = wp_insert_post(array(
                'post_type'   => 'page',
                'post_title'  => $page_data['title'],
                'post_name'   => $slug,
                'post_status' => 'publish',
                'post_content' => ''
            ));
            
            // Set the page template
            if ($page_id && !is_wp_error($page_id)) {
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
        }
    }
}
add_action('after_switch_theme', 'shoobu_create_default_pages');

/**
 * Flush Rewrite Rules on Theme Activation
 */
function shoobu_flush_rewrite_rules() {
    shoobu_register_product_post_type();
    shoobu_register_product_taxonomy();
    flush_rewrite_rules(false); // false means don't use cache
}
add_action('after_switch_theme', 'shoobu_flush_rewrite_rules');

/**
 * Ensure Rewrite Rules are Flushed After Theme Init
 */
function shoobu_maybe_flush_rewrite_rules() {
    if (!get_option('shoobu_rewrite_flushed')) {
        flush_rewrite_rules(false);
        update_option('shoobu_rewrite_flushed', 1);
    }
}
add_action('wp_loaded', 'shoobu_maybe_flush_rewrite_rules');

/**
 * Admin Scripts for Media Uploader
 */
function shoobu_admin_scripts($hook) {
    global $post;
    
    if ($hook === 'post-new.php' || $hook === 'post.php') {
        if (isset($post) && $post->post_type === 'shoobu_product') {
            wp_enqueue_media();
            wp_enqueue_script('shoobu-admin', SHOOBU_URI . '/assets/js/admin.js', array('jquery'), SHOOBU_VERSION, true);
        }
    }
}
add_action('admin_enqueue_scripts', 'shoobu_admin_scripts');

/**
 * Format Price Helper
 */
function shoobu_format_price($price) {
    return '&#8358;' . number_format((float)$price);
}

/**
 * Get Product Rating Stars HTML
 */
function shoobu_get_rating_stars($rating = 5) {
    $rating = floatval($rating);
    $html = '<div class="product-rating">';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= floor($rating)) {
            $html .= '<svg class="star filled" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        } else {
            $html .= '<svg class="star empty" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        }
    }
    $html .= '<span class="rating-value">(' . number_format($rating, 1) . ')</span>';
    $html .= '</div>';
    return $html;
}
