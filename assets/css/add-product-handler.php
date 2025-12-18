<?php
/**
 * Passwordless Add Product Handler
 *
 * @package Shoobu
 */

if (!defined('ABSPATH')) {
    exit;
}

define('SHOOBU_ADMIN_TOKEN', 'shoobu-secret-2025');

/**
 * Check if user has access via token
 */
function shoobu_has_admin_access() {
    if (isset($_GET['admin']) && $_GET['admin'] === SHOOBU_ADMIN_TOKEN) {
        return true;
    }
    return false;
}

/**
 * Handle Product Submission
 */
function shoobu_handle_product_submission() {
    if (!isset($_POST['shoobu_add_product_nonce']) || !wp_verify_nonce($_POST['shoobu_add_product_nonce'], 'shoobu_add_product')) {
        return array('error' => __('Security check failed.', 'shoobu'));
    }

    if (!shoobu_has_admin_access()) {
        return array('error' => __('Access denied.', 'shoobu'));
    }

    $title = isset($_POST['product_title']) ? sanitize_text_field($_POST['product_title']) : '';
    $price = isset($_POST['product_price']) ? floatval($_POST['product_price']) : 0;
    $description = isset($_POST['product_description']) ? sanitize_textarea_field($_POST['product_description']) : '';
    $short_desc = isset($_POST['product_short_desc']) ? sanitize_textarea_field($_POST['product_short_desc']) : '';
    $category = isset($_POST['product_category']) ? sanitize_text_field($_POST['product_category']) : '';
    $rating = isset($_POST['product_rating']) ? floatval($_POST['product_rating']) : 4.5;
    $stock = isset($_POST['product_stock']) ? intval($_POST['product_stock']) : 100;

    if (empty($title)) {
        return array('error' => __('Product title is required.', 'shoobu'));
    }

    if ($price <= 0) {
        return array('error' => __('Valid price is required.', 'shoobu'));
    }

    $post_data = array(
        'post_title'   => $title,
        'post_content' => $description,
        'post_excerpt' => $short_desc,
        'post_status'  => 'publish',
        'post_type'    => 'shoobu_product',
    );

    $post_id = wp_insert_post($post_data);

    if (is_wp_error($post_id)) {
        return array('error' => $post_id->get_error_message());
    }

    update_post_meta($post_id, '_shoobu_price', $price);
    update_post_meta($post_id, '_shoobu_short_description', $short_desc);
    update_post_meta($post_id, '_shoobu_rating', $rating);
    update_post_meta($post_id, '_shoobu_stock', $stock);

    if (!empty($category)) {
        $term = get_term_by('slug', $category, 'shoobu_category');
        if (!$term) {
            $term = get_term_by('name', $category, 'shoobu_category');
        }
        if ($term) {
            wp_set_object_terms($post_id, $term->term_id, 'shoobu_category');
        }
    }

    if (!empty($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        $attachment_id = media_handle_upload('product_image', $post_id);
        
        if (!is_wp_error($attachment_id)) {
            set_post_thumbnail($post_id, $attachment_id);
        }
    }

    return array(
        'success'    => true,
        'product_id' => $post_id,
        'permalink'  => get_permalink($post_id),
    );
}

/**
 * Render Add Product Form
 */
function shoobu_render_add_product_form() {
    $message = '';
    $message_type = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['shoobu_add_product_nonce'])) {
        $result = shoobu_handle_product_submission();
        
        if (isset($result['error'])) {
            $message = $result['error'];
            $message_type = 'error';
        } elseif (isset($result['success'])) {
            $message = sprintf(
                __('Product created successfully! <a href="%s">View Product</a>', 'shoobu'),
                esc_url($result['permalink'])
            );
            $message_type = 'success';
        }
    }

    $categories = get_terms(array(
        'taxonomy'   => 'shoobu_category',
        'hide_empty' => false,
    ));

    ob_start();
    ?>
    <div class="shoobu-add-product-form max-w-2xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6"><?php _e('Add New Product', 'shoobu'); ?></h1>
        
        <?php if ($message) : ?>
            <div class="message <?php echo $message_type === 'error' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'; ?> p-4 rounded-md mb-6">
                <?php echo wp_kses_post($message); ?>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="space-y-6">
            <?php wp_nonce_field('shoobu_add_product', 'shoobu_add_product_nonce'); ?>
            
            <div class="form-group">
                <label for="product_title" class="block font-semibold mb-2"><?php _e('Product Title', 'shoobu'); ?> *</label>
                <input type="text" id="product_title" name="product_title" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-500" data-testid="input-product-title">
            </div>

            <div class="form-group">
                <label for="product_price" class="block font-semibold mb-2"><?php _e('Price', 'shoobu'); ?> *</label>
                <input type="number" id="product_price" name="product_price" required min="0" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-500" data-testid="input-product-price">
            </div>

            <div class="form-group">
                <label for="product_category" class="block font-semibold mb-2"><?php _e('Category', 'shoobu'); ?></label>
                <select id="product_category" name="product_category" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-500" data-testid="select-product-category">
                    <option value=""><?php _e('Select Category', 'shoobu'); ?></option>
                    <?php if (!is_wp_error($categories)) : ?>
                        <?php foreach ($categories as $cat) : ?>
                            <option value="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="product_short_desc" class="block font-semibold mb-2"><?php _e('Short Description', 'shoobu'); ?></label>
                <textarea id="product_short_desc" name="product_short_desc" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-500" data-testid="textarea-product-short-desc"></textarea>
            </div>

            <div class="form-group">
                <label for="product_description" class="block font-semibold mb-2"><?php _e('Full Description', 'shoobu'); ?></label>
                <textarea id="product_description" name="product_description" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-500" data-testid="textarea-product-description"></textarea>
            </div>

            <div class="form-group">
                <label for="product_rating" class="block font-semibold mb-2"><?php _e('Rating (1-5)', 'shoobu'); ?></label>
                <input type="number" id="product_rating" name="product_rating" value="4.5" min="1" max="5" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-500" data-testid="input-product-rating">
            </div>

            <div class="form-group">
                <label for="product_stock" class="block font-semibold mb-2"><?php _e('Stock Quantity', 'shoobu'); ?></label>
                <input type="number" id="product_stock" name="product_stock" value="100" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-500" data-testid="input-product-stock">
            </div>

            <div class="form-group">
                <label for="product_image" class="block font-semibold mb-2"><?php _e('Product Image', 'shoobu'); ?></label>
                <input type="file" id="product_image" name="product_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-500" data-testid="input-product-image">
                <p class="text-sm text-gray-500 mt-1"><?php _e('Recommended size: 400x400 pixels', 'shoobu'); ?></p>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-full" data-testid="button-submit-product">
                <?php _e('Add Product', 'shoobu'); ?>
            </button>
        </form>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Shortcode for Add Product Form
 */
function shoobu_add_product_shortcode() {
    if (!shoobu_has_admin_access()) {
        return '<div class="access-denied text-center py-12"><h2 class="text-2xl font-bold text-red-600">' . __('Access Denied', 'shoobu') . '</h2><p class="text-gray-500 mt-2">' . __('You do not have permission to access this page.', 'shoobu') . '</p></div>';
    }
    
    return shoobu_render_add_product_form();
}
add_shortcode('shoobu_add_product', 'shoobu_add_product_shortcode');
