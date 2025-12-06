<?php
/**
 * Product Archive Template
 *
 * @package Shoobu
 */

get_header();

$search_query = get_search_query();
$category_filter = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
?>

<main id="main-content" class="site-main">
    <div class="container py-8 px-4 md:px-6 lg:px-8">
        <?php shoobu_breadcrumb(); ?>
        
        <div class="archive-header mb-8">
            <h1 class="text-3xl font-bold mb-2">
                <?php 
                if (is_search()) {
                    printf(__('Search Results for: %s', 'shoobu'), esc_html($search_query));
                } elseif (is_tax('shoobu_category')) {
                    single_term_title();
                } else {
                    _e('All Products', 'shoobu');
                }
                ?>
            </h1>
            <p class="text-gray-500">
                <?php
                global $wp_query;
                printf(
                    _n('%d product found', '%d products found', $wp_query->found_posts, 'shoobu'),
                    $wp_query->found_posts
                );
                ?>
            </p>
        </div>

        <div class="archive-layout grid gap-8" style="grid-template-columns: 1fr;">
            <!-- Sidebar Filters -->
            <aside class="filters-sidebar hidden md:block">
                <div class="filters-wrapper sticky top-24 space-y-6">
                    <!-- Categories -->
                    <div class="filter-section">
                        <h3 class="font-semibold mb-3"><?php _e('Categories', 'shoobu'); ?></h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="<?php echo esc_url(get_post_type_archive_link('shoobu_product')); ?>" class="text-sm <?php echo !$category_filter && !is_tax() ? 'text-purple-600 font-semibold' : 'text-gray-600 hover:text-purple-600'; ?>">
                                    <?php _e('All Products', 'shoobu'); ?>
                                </a>
                            </li>
                            <?php
                            $categories = get_terms(array(
                                'taxonomy'   => 'shoobu_category',
                                'hide_empty' => false,
                            ));
                            
                            if (!is_wp_error($categories)) :
                                foreach ($categories as $cat) :
                                    $is_active = (is_tax('shoobu_category', $cat->slug)) || ($category_filter === $cat->slug);
                            ?>
                                <li>
                                    <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="text-sm <?php echo $is_active ? 'text-purple-600 font-semibold' : 'text-gray-600 hover:text-purple-600'; ?>">
                                        <?php echo esc_html($cat->name); ?>
                                        <span class="text-gray-400">(<?php echo $cat->count; ?>)</span>
                                    </a>
                                </li>
                            <?php 
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </div>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="products-archive">
                <?php if (have_posts()) : ?>
                    <div class="products-grid grid gap-4 md:gap-6" style="grid-template-columns: repeat(2, 1fr);">
                        <?php while (have_posts()) : the_post(); 
                            $price = get_post_meta(get_the_ID(), '_shoobu_price', true);
                            $rating = get_post_meta(get_the_ID(), '_shoobu_rating', true) ?: 4.5;
                            $image = get_the_post_thumbnail_url(get_the_ID(), 'shoobu-product');
                            if (!$image) {
                                $image = 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=400&fit=crop';
                            }
                        ?>
                            <article class="product-card card overflow-hidden group" data-testid="card-product-<?php the_ID(); ?>">
                                <a href="<?php the_permalink(); ?>" class="block">
                                    <div class="product-image h-48 md:h-56 overflow-hidden bg-gray-100 relative">
                                        <img src="<?php echo esc_url($image); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                        <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full shadow-md">
                                            <p class="text-sm font-semibold text-purple-600"><?php echo shoobu_format_price($price); ?></p>
                                        </div>
                                    </div>
                                </a>
                                <div class="product-info p-4 space-y-3">
                                    <div class="product-rating flex items-center gap-1">
                                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                                            <svg class="w-4 h-4 <?php echo $i <= floor($rating) ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300'; ?>" viewBox="0 0 24 24" fill="<?php echo $i <= floor($rating) ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="2">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                        <?php endfor; ?>
                                        <span class="text-xs text-gray-500 ml-1">(<?php echo number_format($rating, 1); ?>)</span>
                                    </div>
                                    <h3 class="product-title font-semibold line-clamp-2">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <button type="button" class="btn btn-primary w-full gap-2 add-to-cart-btn" data-product-id="<?php the_ID(); ?>" data-product-name="<?php the_title_attribute(); ?>" data-product-price="<?php echo esc_attr($price); ?>" data-product-image="<?php echo esc_url($image); ?>" data-testid="button-add-to-cart-<?php the_ID(); ?>">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M12 5v14M5 12h14"/>
                                        </svg>
                                        <?php _e('Add to Cart', 'shoobu'); ?>
                                    </button>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    
                    <?php shoobu_pagination(); ?>
                    
                <?php else : ?>
                    <div class="no-products text-center py-12">
                        <svg class="mx-auto mb-4 text-gray-300" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.35-4.35"/>
                        </svg>
                        <h2 class="text-xl font-semibold mb-2"><?php _e('No products found', 'shoobu'); ?></h2>
                        <p class="text-gray-500 mb-4"><?php _e('Try adjusting your search or filter to find what you\'re looking for.', 'shoobu'); ?></p>
                        <a href="<?php echo esc_url(get_post_type_archive_link('shoobu_product')); ?>" class="btn btn-primary">
                            <?php _e('View All Products', 'shoobu'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<style>
    @media (min-width: 768px) {
        .archive-layout {
            grid-template-columns: 200px 1fr;
        }
        .products-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (min-width: 1024px) {
        .products-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
</style>

<?php get_footer(); ?>
