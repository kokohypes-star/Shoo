<?php
/**
 * Minimal WordPress Bootstrap for Theme Preview
 * This simulates WordPress core functions to allow the theme to render
 */

session_start();

define('ABSPATH', __DIR__ . '/');
define('WP_CONTENT_DIR', __DIR__);

$_theme_uri = '';
$_theme_dir = __DIR__;
$_home_url = '';

function get_template_directory() {
    global $_theme_dir;
    return $_theme_dir;
}

function get_template_directory_uri() {
    global $_theme_uri;
    return $_theme_uri;
}

function get_stylesheet_uri() {
    return get_template_directory_uri() . '/style.css';
}

function home_url($path = '') {
    global $_home_url;
    return $_home_url . $path;
}

function admin_url($path = '') {
    return home_url('/admin/' . $path);
}

function esc_attr($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function esc_html($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function esc_url($url) {
    return filter_var($url, FILTER_SANITIZE_URL);
}

function esc_textarea($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function __($text, $domain = 'default') {
    return $text;
}

function _e($text, $domain = 'default') {
    echo $text;
}

function wp_kses_post($content) {
    return strip_tags($content, '<p><a><br><strong><em><ul><ol><li><h1><h2><h3><h4><h5><h6><img><span><div>');
}

function sanitize_text_field($str) {
    return trim(strip_tags($str));
}

function sanitize_textarea_field($str) {
    return trim(strip_tags($str));
}

function wp_parse_args($args, $defaults) {
    return array_merge($defaults, $args);
}

function add_action($tag, $callback, $priority = 10, $accepted_args = 1) {
    global $_actions;
    if (!isset($_actions)) $_actions = array();
    if (!isset($_actions[$tag])) $_actions[$tag] = array();
    $_actions[$tag][] = array('callback' => $callback, 'priority' => $priority);
}

function do_action($tag, ...$args) {
    global $_actions;
    if (isset($_actions[$tag])) {
        foreach ($_actions[$tag] as $action) {
            call_user_func_array($action['callback'], $args);
        }
    }
}

function add_theme_support($feature, $args = array()) {
    global $_theme_supports;
    if (!isset($_theme_supports)) $_theme_supports = array();
    $_theme_supports[$feature] = $args;
}

function register_nav_menus($locations) {
    global $_nav_menus;
    $_nav_menus = $locations;
}

function add_image_size($name, $width, $height, $crop = false) {
}

function register_post_type($post_type, $args) {
}

function register_taxonomy($taxonomy, $object_type, $args) {
}

function add_meta_box($id, $title, $callback, $screen, $context, $priority) {
}

function get_post_meta($post_id, $key, $single = false) {
    global $_current_post;
    $products = get_sample_products_array();
    
    foreach ($products as $product) {
        if ($product->ID == $post_id) {
            $meta_key = $key;
            if (property_exists($product, $meta_key)) {
                return $single ? $product->$meta_key : array($product->$meta_key);
            }
        }
    }
    
    if ($_current_post && property_exists($_current_post, $key)) {
        return $single ? $_current_post->$key : array($_current_post->$key);
    }
    
    return $single ? '' : array();
}

function update_post_meta($post_id, $key, $value) {
    return true;
}

function delete_post_meta($post_id, $key) {
    return true;
}

function wp_nonce_field($action, $name) {
    echo '<input type="hidden" name="' . esc_attr($name) . '" value="' . md5($action) . '">';
}

function wp_verify_nonce($nonce, $action) {
    return true;
}

function wp_create_nonce($action) {
    return md5($action . time());
}

function current_user_can($capability, $args = null) {
    return true;
}

function wp_enqueue_style($handle, $src = '', $deps = array(), $ver = false, $media = 'all') {
    global $_enqueued_styles;
    if (!isset($_enqueued_styles)) $_enqueued_styles = array();
    $_enqueued_styles[$handle] = $src;
}

function wp_enqueue_script($handle, $src = '', $deps = array(), $ver = false, $in_footer = false) {
    global $_enqueued_scripts;
    if (!isset($_enqueued_scripts)) $_enqueued_scripts = array();
    $_enqueued_scripts[$handle] = array('src' => $src, 'in_footer' => $in_footer);
}

function wp_localize_script($handle, $object_name, $data) {
    global $_localized_scripts;
    if (!isset($_localized_scripts)) $_localized_scripts = array();
    $_localized_scripts[$handle] = array('name' => $object_name, 'data' => $data);
}

function wp_head() {
    global $_enqueued_styles, $_enqueued_scripts, $_localized_scripts;
    
    if (isset($_enqueued_styles)) {
        foreach ($_enqueued_styles as $handle => $src) {
            if (!empty($src)) {
                echo '<link rel="stylesheet" href="' . esc_url($src) . '">' . "\n";
            }
        }
    }
    
    if (isset($_enqueued_scripts)) {
        foreach ($_enqueued_scripts as $handle => $data) {
            if (!$data['in_footer'] && !empty($data['src'])) {
                echo '<script src="' . esc_url($data['src']) . '"></script>' . "\n";
            }
        }
    }
    
    if (isset($_localized_scripts)) {
        foreach ($_localized_scripts as $handle => $data) {
            echo '<script>var ' . $data['name'] . ' = ' . json_encode($data['data']) . ';</script>' . "\n";
        }
    }
    
    do_action('wp_head');
}

function wp_footer() {
    global $_enqueued_scripts;
    
    if (isset($_enqueued_scripts)) {
        foreach ($_enqueued_scripts as $handle => $data) {
            if ($data['in_footer'] && !empty($data['src'])) {
                echo '<script src="' . esc_url($data['src']) . '"></script>' . "\n";
            }
        }
    }
    
    do_action('wp_footer');
}

function wp_body_open() {
    do_action('wp_body_open');
}

function body_class($class = '') {
    echo 'class="' . esc_attr($class) . '"';
}

function language_attributes($doctype = 'html') {
    echo 'lang="en"';
}

function bloginfo($show) {
    switch ($show) {
        case 'charset':
            echo 'UTF-8';
            break;
        case 'name':
            echo 'Shoobu';
            break;
        case 'description':
            echo 'Premium Tech at Your Fingertips';
            break;
        case 'url':
            echo home_url();
            break;
    }
}

function get_bloginfo($show) {
    ob_start();
    bloginfo($show);
    return ob_get_clean();
}

function has_custom_logo() {
    return false;
}

function the_custom_logo() {
    echo '<span class="site-logo">Shoobu</span>';
}

function wp_nav_menu($args = array()) {
    $items = array(
        array('title' => 'Home', 'url' => home_url('/')),
        array('title' => 'Products', 'url' => home_url('/products')),
        array('title' => 'Categories', 'url' => home_url('/categories')),
        array('title' => 'About', 'url' => home_url('/about')),
    );
    
    echo '<ul class="' . esc_attr($args['menu_class'] ?? 'nav-menu') . '">';
    foreach ($items as $item) {
        echo '<li><a href="' . esc_url($item['url']) . '">' . esc_html($item['title']) . '</a></li>';
    }
    echo '</ul>';
}

function has_nav_menu($location) {
    return true;
}

function get_theme_mod($name, $default = false) {
    global $_theme_mods;
    if (!isset($_theme_mods)) $_theme_mods = array();
    return isset($_theme_mods[$name]) ? $_theme_mods[$name] : $default;
}

function is_front_page() {
    return true;
}

function is_home() {
    return true;
}

function is_singular($post_types = '') {
    return false;
}

function is_page($page = '') {
    return false;
}

function is_single($post = '') {
    return false;
}

function is_archive() {
    return false;
}

function is_post_type_archive($post_types = '') {
    return false;
}

function is_user_logged_in() {
    return false;
}

function get_current_user_id() {
    return 0;
}

function get_the_title($post = null) {
    global $_current_post;
    if ($_current_post) {
        return $_current_post->post_title;
    }
    return 'Sample Product';
}

function the_title() {
    global $_current_post;
    if ($_current_post) {
        echo $_current_post->post_title;
    } else {
        echo get_the_title();
    }
}

function get_the_ID() {
    global $_current_post;
    if ($_current_post) {
        return $_current_post->ID;
    }
    return 1;
}

function get_the_content($more_link_text = null, $strip_teaser = false, $post = null) {
    return '<p>This is a sample product description.</p>';
}

function the_content() {
    echo get_the_content();
}

function get_the_excerpt($post = null) {
    return 'Sample product excerpt';
}

function the_excerpt() {
    echo get_the_excerpt();
}

function get_the_permalink($post = null) {
    global $_current_post;
    if ($_current_post) {
        return home_url('/product/' . $_current_post->ID);
    }
    return home_url('/product/sample');
}

function the_permalink() {
    echo get_the_permalink();
}

function get_permalink($post = null) {
    return get_the_permalink($post);
}

function get_post_type_archive_link($post_type) {
    return home_url('/products');
}

function has_post_thumbnail($post = null) {
    return false;
}

function get_the_post_thumbnail_url($post = null, $size = 'post-thumbnail') {
    global $_current_post;
    $products = get_sample_products_array();
    
    if ($post) {
        foreach ($products as $product) {
            if ($product->ID == $post) {
                if (property_exists($product, '_image')) {
                    return $product->_image;
                }
            }
        }
    }
    
    if ($_current_post && property_exists($_current_post, '_image')) {
        return $_current_post->_image;
    }
    
    return 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=400&fit=crop';
}

function the_post_thumbnail($size = 'post-thumbnail', $attr = array()) {
    echo '<img src="' . esc_url(get_the_post_thumbnail_url(null, $size)) . '" alt="">';
}

function get_terms($args = array()) {
    return array(
        (object)array('term_id' => 1, 'name' => 'Audio', 'slug' => 'audio', 'count' => 5),
        (object)array('term_id' => 2, 'name' => 'Wearables', 'slug' => 'wearables', 'count' => 8),
        (object)array('term_id' => 3, 'name' => 'Cables', 'slug' => 'cables', 'count' => 12),
        (object)array('term_id' => 4, 'name' => 'Accessories', 'slug' => 'accessories', 'count' => 15),
        (object)array('term_id' => 5, 'name' => 'Chargers', 'slug' => 'chargers', 'count' => 7),
    );
}

function term_exists($term, $taxonomy = '') {
    return true;
}

function wp_insert_term($term, $taxonomy, $args = array()) {
    return array('term_id' => rand(1, 100));
}

function wp_get_attachment_image_src($attachment_id, $size = 'thumbnail') {
    return array(get_template_directory_uri() . '/assets/images/screenshot.png', 400, 400);
}

function wp_login_url($redirect = '') {
    return home_url('/login');
}

function wp_redirect($location, $status = 302) {
    header('Location: ' . $location, true, $status);
}

function wp_insert_post($postarr, $wp_error = false) {
    return rand(1, 1000);
}

function is_wp_error($thing) {
    return false;
}

function wp_set_object_terms($object_id, $terms, $taxonomy, $append = false) {
    return array();
}

function get_query_var($var, $default = '') {
    return isset($_GET[$var]) ? $_GET[$var] : $default;
}

function add_query_arg($args, $url = '') {
    if (is_string($args) && is_string($url)) {
        $url = $url ?: $_SERVER['REQUEST_URI'];
        return $url . (strpos($url, '?') !== false ? '&' : '?') . $args . '=' . func_get_arg(1);
    }
    return $url ?: $_SERVER['REQUEST_URI'];
}

function wp_send_json_success($data = null) {
    header('Content-Type: application/json');
    echo json_encode(array('success' => true, 'data' => $data));
    exit;
}

function wp_send_json_error($data = null) {
    header('Content-Type: application/json');
    echo json_encode(array('success' => false, 'data' => $data));
    exit;
}

function check_ajax_referer($action = -1, $query_arg = false, $die = true) {
    return true;
}

function flush_rewrite_rules($hard = true) {
}

function wp_enqueue_media() {
}

$_current_post = null;
$_sample_products = array();

function get_sample_products_array() {
    return array(
        (object)array(
            'ID' => 1,
            'post_title' => 'Wireless Earbuds Pro',
            'post_content' => 'Premium wireless earbuds with noise cancellation',
            'post_excerpt' => 'High quality audio experience',
            '_shoobu_price' => 15000,
            '_shoobu_sale_price' => 12500,
            '_shoobu_rating' => 4.5,
            '_image' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=400&h=400&fit=crop',
        ),
        (object)array(
            'ID' => 2,
            'post_title' => 'Smart Watch Elite',
            'post_content' => 'Advanced smartwatch with health tracking',
            'post_excerpt' => 'Track your fitness goals',
            '_shoobu_price' => 45000,
            '_shoobu_sale_price' => 39999,
            '_shoobu_rating' => 4.8,
            '_image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=400&fit=crop',
        ),
        (object)array(
            'ID' => 3,
            'post_title' => 'USB-C Fast Charger',
            'post_content' => '65W USB-C fast charging adapter',
            'post_excerpt' => 'Fast charging for all devices',
            '_shoobu_price' => 8500,
            '_shoobu_sale_price' => '',
            '_shoobu_rating' => 4.2,
            '_image' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=400&h=400&fit=crop',
        ),
        (object)array(
            'ID' => 4,
            'post_title' => 'Bluetooth Speaker',
            'post_content' => 'Portable bluetooth speaker with deep bass',
            'post_excerpt' => 'Powerful sound anywhere',
            '_shoobu_price' => 22000,
            '_shoobu_sale_price' => 18500,
            '_shoobu_rating' => 4.6,
            '_image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=400&h=400&fit=crop',
        ),
        (object)array(
            'ID' => 5,
            'post_title' => 'Premium Headphones',
            'post_content' => 'Over-ear headphones with studio quality sound',
            'post_excerpt' => 'Immersive audio experience',
            '_shoobu_price' => 35000,
            '_shoobu_sale_price' => 29999,
            '_shoobu_rating' => 4.7,
            '_image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=400&fit=crop',
        ),
        (object)array(
            'ID' => 6,
            'post_title' => 'Fitness Tracker Band',
            'post_content' => 'Slim fitness band with heart rate monitor',
            'post_excerpt' => 'Your health companion',
            '_shoobu_price' => 12000,
            '_shoobu_sale_price' => 9500,
            '_shoobu_rating' => 4.3,
            '_image' => 'https://images.unsplash.com/photo-1557438159-51eec7a6c9e8?w=400&h=400&fit=crop',
        ),
        (object)array(
            'ID' => 7,
            'post_title' => 'Power Bank 20000mAh',
            'post_content' => 'High capacity portable charger',
            'post_excerpt' => 'Never run out of power',
            '_shoobu_price' => 15000,
            '_shoobu_sale_price' => '',
            '_shoobu_rating' => 4.4,
            '_image' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=400&h=400&fit=crop',
        ),
    );
}

class WP_Query {
    public $posts = array();
    public $post_count = 0;
    public $found_posts = 0;
    public $current_post = -1;
    public $post = null;
    
    public function __construct($args = array()) {
        $this->posts = get_sample_products_array();
        $this->post_count = count($this->posts);
        $this->found_posts = $this->post_count;
    }
    
    public function have_posts() {
        return ($this->current_post + 1) < $this->post_count;
    }
    
    public function the_post() {
        global $_current_post;
        $this->current_post++;
        $this->post = $this->posts[$this->current_post];
        $_current_post = $this->post;
        return $this->post;
    }
    
    public function rewind_posts() {
        $this->current_post = -1;
    }
}

function get_header($name = null) {
    include get_template_directory() . '/header.php';
}

function get_footer($name = null) {
    include get_template_directory() . '/footer.php';
}

function get_template_part($slug, $name = null, $args = array()) {
    $file = get_template_directory() . '/' . $slug . '.php';
    if (file_exists($file)) {
        if (!empty($args)) {
            extract($args);
        }
        include $file;
    }
}

function have_posts() {
    return false;
}

function the_post() {
    return null;
}

function wp_reset_postdata() {
    global $_current_post;
    $_current_post = null;
}

function get_the_archive_title() {
    return 'Archive';
}

function the_posts_pagination($args = array()) {
}

function get_term_by($field, $value, $taxonomy) {
    $terms = get_terms(array('taxonomy' => $taxonomy));
    foreach ($terms as $term) {
        if ($term->slug === $value || $term->name === $value) {
            return $term;
        }
    }
    return false;
}

function get_term_link($term, $taxonomy = '') {
    if (is_object($term)) {
        return home_url('/products?category=' . $term->slug);
    }
    return home_url('/products');
}

function get_search_query() {
    return isset($_GET['s']) ? $_GET['s'] : '';
}

function esc_attr_e($text, $domain = 'default') {
    echo esc_attr($text);
}

function the_title_attribute($args = array()) {
    global $_current_post;
    if ($_current_post) {
        echo esc_attr($_current_post->post_title);
    }
}

function the_ID() {
    global $_current_post;
    if ($_current_post) {
        echo $_current_post->ID;
    }
}

require_once __DIR__ . '/functions.php';

do_action('after_setup_theme');
do_action('init');
do_action('wp_enqueue_scripts');
