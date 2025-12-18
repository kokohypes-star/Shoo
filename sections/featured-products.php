<?php
/**
 * Featured Products Section Template
 *
 * @package Shoobu
 */

$args = array(
    'post_type'      => 'shoobu_product',
    'posts_per_page' => 21,
    'orderby'        => 'date',
    'order'          => 'DESC',
);

$products = new WP_Query($args);
?>

<section id="featured-products-section" class="featured-products-section px-4 md:px-6 lg:px-8 w-full" style="margin-top: -0.5rem;">
    <div class="container space-y-4">
        <div>
            <h2 class="font-extrabold" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.5rem; font-weight: 800; margin-bottom: 0.1rem;">
                <?php echo esc_html(get_theme_mod('shoobu_featured_title', __('Featured Products', 'shoobu'))); ?>
            </h2>
            <p class="text-gray-500" style="font-size: 0.9rem; font-weight: 350;">
                <?php echo esc_html(get_theme_mod('shoobu_featured_subtitle', __('Trending items our customers love', 'shoobu'))); ?>
            </p>
        </div>

        <?php if ($products->have_posts()) : ?>
            <div class="products-grid grid gap-4 md:gap-6" style="grid-template-columns: repeat(3, 1fr);">
                <?php 
                $count = 0;
                while ($products->have_posts()) : $products->the_post(); 
                    $count++;
                    $price = get_post_meta(get_the_ID(), '_shoobu_price', true);
                    $rating = get_post_meta(get_the_ID(), '_shoobu_rating', true) ?: 4.5;
                    $image = get_the_post_thumbnail_url(get_the_ID(), 'shoobu-product');
                    if (!$image) {
                        $image = 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=400&fit=crop';
                    }
                ?>
                    <article class="product-card card overflow-hidden group cursor-pointer bg-white" data-product-id="<?php the_ID(); ?>" data-testid="card-product-<?php the_ID(); ?>">
                        <div class="product-image h-32 md:h-48 overflow-hidden bg-gray-100 relative">
                            <img src="<?php echo esc_url($image); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-300 md:group-hover:scale-110">
                            <div class="absolute top-2 md:top-4 right-2 md:right-4 bg-white px-2 md:px-4 py-0.5 md:py-1.5 rounded-full shadow-md">
                                <p class="text-xs md:text-base font-semibold text-purple-600"><?php echo shoobu_format_price($price); ?></p>
                            </div>
                            <div class="product-overlay absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 transition-opacity duration-300 hidden md:flex items-center justify-center md:group-hover:opacity-100">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                    <circle cx="9" cy="21" r="1"/>
                                    <circle cx="20" cy="21" r="1"/>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                </svg>
                            </div>
                        </div>
                        <div class="product-info p-2 md:p-6 space-y-2 md:space-y-4">
                            <div>
                                <div class="product-rating flex items-center gap-0.5 md:gap-1.5 mb-1 md:mb-3">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <svg class="w-3 md:w-5 h-3 md:h-5 <?php echo $i <= floor($rating) ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300'; ?>" viewBox="0 0 24 24" fill="<?php echo $i <= floor($rating) ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="2">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    <?php endfor; ?>
                                    <span class="text-xs md:text-sm text-gray-500 ml-0.5 md:ml-2">(<?php echo number_format($rating, 1); ?>)</span>
                                </div>
                                <h3 class="product-title text-xs md:text-base font-semibold line-clamp-2 leading-tight md:leading-snug"><?php the_title(); ?></h3>
                            </div>
                            
                            <!-- Mobile action buttons (shown on tap) -->
                            <div class="mobile-actions md:hidden space-y-1 hidden">
                                <button type="button" class="btn btn-primary w-full gap-2 h-7 add-to-cart-btn" data-product-id="<?php the_ID(); ?>" data-product-name="<?php the_title_attribute(); ?>" data-product-price="<?php echo esc_attr($price); ?>" data-product-image="<?php echo esc_url($image); ?>" data-testid="button-add-to-cart-<?php the_ID(); ?>">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 5v14M5 12h14"/>
                                    </svg>
                                    <?php _e('Add to Cart', 'shoobu'); ?>
                                </button>
                                <a href="<?php the_permalink(); ?>" class="btn btn-outline w-full h-7" data-testid="button-view-details-<?php the_ID(); ?>">
                                    <?php _e('View Details', 'shoobu'); ?>
                                </a>
                            </div>

                            <!-- Desktop add to cart button -->
                            <button type="button" class="btn btn-primary w-full gap-2 hidden md:flex justify-center add-to-cart-btn" data-product-id="<?php the_ID(); ?>" data-product-name="<?php the_title_attribute(); ?>" data-product-price="<?php echo esc_attr($price); ?>" data-product-image="<?php echo esc_url($image); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 5v14M5 12h14"/>
                                </svg>
                                <?php _e('Add to Cart', 'shoobu'); ?>
                            </button>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <!-- Shop More Button -->
            <div class="flex justify-center pt-6">
                <a href="<?php echo esc_url(get_post_type_archive_link('shoobu_product')); ?>" class="btn btn-primary btn-lg gap-2 px-8" data-testid="button-shop-more">
                    <?php _e('Shop More', 'shoobu'); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        <?php else : ?>
            <div class="text-center py-12">
                <p class="text-gray-500 mb-4"><?php _e('No products found. Add some products to get started!', 'shoobu'); ?></p>
                <?php if (current_user_can('edit_posts')) : ?>
                    <a href="<?php echo esc_url(admin_url('post-new.php?post_type=shoobu_product')); ?>" class="btn btn-primary">
                        <?php _e('Add Product', 'shoobu'); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</section>

<style>
    @media (min-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(7, 1fr);
        }
    }
    
    .text-yellow-400 { color: #facc15; }
    .fill-yellow-400 { fill: #facc15; }
    
    .product-card.active .mobile-actions {
        display: block !important;
    }
</style>
