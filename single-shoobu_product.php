<?php
/**
 * Single Product Template
 *
 * @package Shoobu
 */

get_header();

if (have_posts()) : while (have_posts()) : the_post();
    $product_id = get_the_ID();
    $price = get_post_meta($product_id, '_shoobu_price', true);
    $sale_price = get_post_meta($product_id, '_shoobu_sale_price', true);
    $short_desc = get_post_meta($product_id, '_shoobu_short_description', true);
    $rating = get_post_meta($product_id, '_shoobu_rating', true) ?: 4.5;
    $stock = get_post_meta($product_id, '_shoobu_stock', true) ?: 0;
    $gallery = get_post_meta($product_id, '_shoobu_gallery', true);
    $gallery = is_array($gallery) ? $gallery : array();
    
    $main_image = get_the_post_thumbnail_url($product_id, 'large');
    if (!$main_image) {
        $main_image = 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&h=800&fit=crop';
    }
?>

<main id="main-content" class="site-main">
    <div class="container py-8 px-4 md:px-6 lg:px-8">
        <?php shoobu_breadcrumb(); ?>
        
        <div class="product-single grid gap-8" style="grid-template-columns: 1fr;">
            <!-- Product Images -->
            <div class="product-images">
                <div class="main-image rounded-md overflow-hidden bg-gray-100 mb-4" style="height: 400px;">
                    <img id="main-product-image" src="<?php echo esc_url($main_image); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover">
                </div>
                
                <?php if (!empty($gallery)) : ?>
                    <div class="gallery-thumbs grid gap-2" style="grid-template-columns: repeat(5, 1fr);">
                        <button type="button" class="thumb active rounded-md overflow-hidden bg-gray-100" style="height: 80px;" data-image="<?php echo esc_url($main_image); ?>">
                            <img src="<?php echo esc_url($main_image); ?>" alt="" class="w-full h-full object-cover">
                        </button>
                        <?php foreach ($gallery as $image_id) : 
                            $thumb_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                            $full_url = wp_get_attachment_image_url($image_id, 'large');
                            if ($thumb_url) :
                        ?>
                            <button type="button" class="thumb rounded-md overflow-hidden bg-gray-100" style="height: 80px;" data-image="<?php echo esc_url($full_url); ?>">
                                <img src="<?php echo esc_url($thumb_url); ?>" alt="" class="w-full h-full object-cover">
                            </button>
                        <?php 
                            endif;
                        endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Product Info -->
            <div class="product-info space-y-6">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold mb-2" data-testid="text-product-title"><?php the_title(); ?></h1>
                    
                    <!-- Rating -->
                    <div class="product-rating flex items-center gap-2 mb-4">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <svg class="w-5 h-5 <?php echo $i <= floor($rating) ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300'; ?>" viewBox="0 0 24 24" fill="<?php echo $i <= floor($rating) ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="2">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        <?php endfor; ?>
                        <span class="text-gray-500">(<?php echo number_format($rating, 1); ?>)</span>
                    </div>
                </div>

                <!-- Price -->
                <div class="price-section">
                    <?php if ($sale_price && $sale_price < $price) : ?>
                        <div class="flex items-center gap-3">
                            <span class="text-3xl font-bold text-purple-600" data-testid="text-product-price"><?php echo shoobu_format_price($sale_price); ?></span>
                            <span class="text-xl text-gray-400 line-through"><?php echo shoobu_format_price($price); ?></span>
                            <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-sm font-semibold">
                                <?php echo round((($price - $sale_price) / $price) * 100); ?>% OFF
                            </span>
                        </div>
                    <?php else : ?>
                        <span class="text-3xl font-bold text-purple-600" data-testid="text-product-price"><?php echo shoobu_format_price($price); ?></span>
                    <?php endif; ?>
                </div>

                <!-- Short Description -->
                <?php if ($short_desc) : ?>
                    <p class="text-gray-600"><?php echo esc_html($short_desc); ?></p>
                <?php endif; ?>

                <!-- Stock Status -->
                <div class="stock-status">
                    <?php if ($stock > 0) : ?>
                        <span class="text-green-600 font-semibold flex items-center gap-2">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                            <?php _e('In Stock', 'shoobu'); ?> (<?php echo $stock; ?> <?php _e('available', 'shoobu'); ?>)
                        </span>
                    <?php else : ?>
                        <span class="text-red-600 font-semibold"><?php _e('Out of Stock', 'shoobu'); ?></span>
                    <?php endif; ?>
                </div>

                <!-- Quantity & Add to Cart -->
                <div class="add-to-cart-section flex items-center gap-4">
                    <div class="quantity-selector flex items-center border rounded-md">
                        <button type="button" class="qty-minus px-3 py-2 text-xl" data-testid="button-qty-minus">-</button>
                        <input type="number" id="product-qty" value="1" min="1" max="<?php echo $stock; ?>" class="w-16 text-center border-0 py-2" data-testid="input-quantity">
                        <button type="button" class="qty-plus px-3 py-2 text-xl" data-testid="button-qty-plus">+</button>
                    </div>
                    
                    <button type="button" id="add-to-cart-single" class="btn btn-primary btn-lg flex-1 gap-2" <?php echo $stock <= 0 ? 'disabled' : ''; ?> data-product-id="<?php echo $product_id; ?>" data-product-name="<?php the_title_attribute(); ?>" data-product-price="<?php echo esc_attr($sale_price ?: $price); ?>" data-product-image="<?php echo esc_url($main_image); ?>" data-testid="button-add-to-cart">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"/>
                            <circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                        <?php _e('Add to Cart', 'shoobu'); ?>
                    </button>
                </div>

                <!-- Categories -->
                <?php 
                $terms = get_the_terms($product_id, 'shoobu_category');
                if ($terms && !is_wp_error($terms)) : 
                ?>
                    <div class="product-categories">
                        <span class="text-gray-500"><?php _e('Category:', 'shoobu'); ?></span>
                        <?php foreach ($terms as $term) : ?>
                            <a href="<?php echo esc_url(get_term_link($term)); ?>" class="text-purple-600 hover:underline"><?php echo esc_html($term->name); ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Product Description -->
        <?php if (get_the_content()) : ?>
            <div class="product-description mt-12">
                <h2 class="text-xl font-bold mb-4"><?php _e('Description', 'shoobu'); ?></h2>
                <div class="prose text-gray-600">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Related Products -->
        <?php
        $related_args = array(
            'post_type'      => 'shoobu_product',
            'posts_per_page' => 4,
            'post__not_in'   => array($product_id),
            'orderby'        => 'rand',
        );
        
        if ($terms) {
            $related_args['tax_query'] = array(
                array(
                    'taxonomy' => 'shoobu_category',
                    'terms'    => wp_list_pluck($terms, 'term_id'),
                ),
            );
        }
        
        $related = new WP_Query($related_args);
        
        if ($related->have_posts()) :
        ?>
            <div class="related-products mt-12">
                <h2 class="text-xl font-bold mb-6"><?php _e('Related Products', 'shoobu'); ?></h2>
                <div class="grid gap-6" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));">
                    <?php while ($related->have_posts()) : $related->the_post(); 
                        $rel_price = get_post_meta(get_the_ID(), '_shoobu_price', true);
                        $rel_rating = get_post_meta(get_the_ID(), '_shoobu_rating', true) ?: 4.5;
                        $rel_image = get_the_post_thumbnail_url(get_the_ID(), 'shoobu-product') ?: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=400&fit=crop';
                    ?>
                        <a href="<?php the_permalink(); ?>" class="card overflow-hidden group">
                            <div class="h-48 overflow-hidden bg-gray-100">
                                <img src="<?php echo esc_url($rel_image); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold line-clamp-2 mb-2"><?php the_title(); ?></h3>
                                <p class="text-purple-600 font-bold"><?php echo shoobu_format_price($rel_price); ?></p>
                            </div>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php 
        endif; 
        wp_reset_postdata();
        ?>
    </div>
</main>

<style>
    @media (min-width: 768px) {
        .product-single {
            grid-template-columns: 1fr 1fr;
        }
    }
    
    .thumb {
        opacity: 0.6;
        transition: opacity 0.2s;
        cursor: pointer;
    }
    
    .thumb:hover, .thumb.active {
        opacity: 1;
    }
    
    .thumb.active {
        border: 2px solid var(--shoobu-primary, #9333ea);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const thumbs = document.querySelectorAll('.thumb');
    const mainImage = document.getElementById('main-product-image');
    
    thumbs.forEach(function(thumb) {
        thumb.addEventListener('click', function() {
            const newSrc = this.getAttribute('data-image');
            mainImage.src = newSrc;
            thumbs.forEach(function(t) { t.classList.remove('active'); });
            this.classList.add('active');
        });
    });
    
    const qtyInput = document.getElementById('product-qty');
    const minusBtn = document.querySelector('.qty-minus');
    const plusBtn = document.querySelector('.qty-plus');
    
    if (minusBtn && plusBtn && qtyInput) {
        minusBtn.addEventListener('click', function() {
            const current = parseInt(qtyInput.value) || 1;
            if (current > 1) qtyInput.value = current - 1;
        });
        
        plusBtn.addEventListener('click', function() {
            const current = parseInt(qtyInput.value) || 1;
            const max = parseInt(qtyInput.max) || 100;
            if (current < max) qtyInput.value = current + 1;
        });
    }
});
</script>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
