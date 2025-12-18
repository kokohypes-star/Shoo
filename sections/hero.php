<?php
/**
 * Hero Section Template
 *
 * @package Shoobu
 */

$hero_slides = array(
    array(
        'subtitle' => get_theme_mod('shoobu_hero_slide1_subtitle', 'Hurry Up! Enjoy Sale Madness!'),
        'title'    => get_theme_mod('shoobu_hero_slide1_title', 'Ember Sales! Operation Everybody Must Buy'),
        'desc'     => get_theme_mod('shoobu_hero_slide1_desc', 'Don\'t miss out on our exclusive sale. Limited time offer on premium tech products.'),
        'image'    => get_theme_mod('shoobu_hero_slide1_image', 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&h=600&fit=crop'),
    ),
    array(
        'subtitle' => get_theme_mod('shoobu_hero_slide2_subtitle', 'Hurry Up! Enjoy Sale Madness!'),
        'title'    => get_theme_mod('shoobu_hero_slide2_title', 'Tech Revolution! Get the Latest Gadgets'),
        'desc'     => get_theme_mod('shoobu_hero_slide2_desc', 'Upgrade your tech collection with our curated selection of premium devices.'),
        'image'    => get_theme_mod('shoobu_hero_slide2_image', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&h=600&fit=crop'),
    ),
    array(
        'subtitle' => get_theme_mod('shoobu_hero_slide3_subtitle', 'Hurry Up! Enjoy Sale Madness!'),
        'title'    => get_theme_mod('shoobu_hero_slide3_title', 'Smart Living Starts Here'),
        'desc'     => get_theme_mod('shoobu_hero_slide3_desc', 'Experience the future with our cutting-edge smart home and wearable technology.'),
        'image'    => get_theme_mod('shoobu_hero_slide3_image', 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=800&h=600&fit=crop'),
    ),
);

$promo_banners = array(
    array(
        'title' => get_theme_mod('shoobu_promo1_title', 'Precious Sustainably Stylish'),
        'image' => get_theme_mod('shoobu_promo1_image', 'https://images.unsplash.com/photo-1600298881974-6be191ceeda1?w=400&h=300&fit=crop'),
        'link'  => get_theme_mod('shoobu_promo1_link', '#'),
    ),
    array(
        'title' => get_theme_mod('shoobu_promo2_title', 'Sound Innovation Collection'),
        'image' => get_theme_mod('shoobu_promo2_image', 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=300&fit=crop'),
        'link'  => get_theme_mod('shoobu_promo2_link', '#'),
    ),
    array(
        'title' => get_theme_mod('shoobu_promo3_title', 'Contemporary Elegance Line'),
        'image' => get_theme_mod('shoobu_promo3_image', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop'),
        'link'  => get_theme_mod('shoobu_promo3_link', '#'),
    ),
);
?>

<section id="hero-section" class="hero-section pt-8 px-4 md:px-6 lg:px-8" style="background: linear-gradient(to bottom, #f9fafb, #fff); margin-bottom: -2.375rem;">
    <div class="container">
        <!-- Two Column Layout - 60/40 Split -->
        <div class="hero-grid grid gap-6" style="grid-template-columns: 1fr; ">
            <!-- Left Column: Slider (60% width on desktop) -->
            <div class="hero-slider-wrapper">
                <div id="hero-slider" class="hero-slider banner-hover relative w-full overflow-hidden bg-black border border-gray-200" style="height: clamp(250px, 50vw, 381px); border-radius: 0.3rem;">
                    <!-- Slides -->
                    <?php foreach ($hero_slides as $index => $slide) : ?>
                        <div class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out <?php echo $index === 0 ? 'opacity-100' : 'opacity-0'; ?>" data-slide="<?php echo $index; ?>">
                            <img src="<?php echo esc_url($slide['image']); ?>" alt="<?php echo esc_attr($slide['title']); ?>" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black" style="opacity: 0.3;"></div>
                            
                            <!-- Content -->
                            <div class="absolute inset-0 flex flex-col justify-center px-4 md:px-8 py-6 md:py-12">
                                <div style="max-width: 28rem;">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 md:w-5 md:h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                                        </svg>
                                        <p class="text-xs md:text-sm font-semibold text-white"><?php echo esc_html($slide['subtitle']); ?></p>
                                    </div>
                                    <h2 class="text-lg md:text-2xl lg:text-3xl font-bold text-white leading-tight mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                        <?php echo esc_html($slide['title']); ?>
                                    </h2>
                                    <p class="text-xs md:text-sm text-white leading-relaxed mb-3">
                                        <?php echo esc_html($slide['desc']); ?>
                                    </p>
                                    <a href="<?php echo esc_url(get_post_type_archive_link('shoobu_product')); ?>" class="btn btn-white btn-sm inline-flex items-center gap-2">
                                        <?php _e('Shop Now', 'shoobu'); ?>
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M5 12h14M12 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- Navigation Arrows (Desktop) -->
                    <div class="hero-nav hidden md:block">
                        <button type="button" class="hero-nav-prev absolute left-4 top-1/2 -translate-y-1/2 z-10 bg-white/20 hover:bg-white/40 text-white p-2 rounded-full transition">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M15 18l-6-6 6-6"/>
                            </svg>
                        </button>
                        <button type="button" class="hero-nav-next absolute right-4 top-1/2 -translate-y-1/2 z-10 bg-white/20 hover:bg-white/40 text-white p-2 rounded-full transition">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Column: Promotional Banners (40% width on desktop) -->
            <div class="promo-banners hidden lg:flex flex-col gap-6">
                <!-- Top Banner -->
                <a href="<?php echo esc_url($promo_banners[0]['link']); ?>" class="banner-hover relative overflow-hidden bg-white border border-gray-200" style="height: 190px; border-radius: 0.3rem;">
                    <img src="<?php echo esc_url($promo_banners[0]['image']); ?>" alt="<?php echo esc_attr($promo_banners[0]['title']); ?>" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black" style="opacity: 0.3;"></div>
                    <div class="absolute inset-0 flex flex-col justify-center px-4 py-6">
                        <div style="max-width: 18rem;">
                            <h3 class="text-lg font-bold text-white line-clamp-2 leading-tight mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                <?php echo esc_html($promo_banners[0]['title']); ?>
                            </h3>
                            <span class="btn btn-white btn-sm inline-flex items-center gap-2">
                                <?php _e('Shop Now', 'shoobu'); ?>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Bottom Two Banners -->
                <div class="grid gap-6" style="grid-template-columns: repeat(2, 1fr); height: 170px;">
                    <?php foreach (array_slice($promo_banners, 1) as $banner) : ?>
                        <a href="<?php echo esc_url($banner['link']); ?>" class="banner-hover relative overflow-hidden bg-white border border-gray-200" style="border-radius: 0.3rem;">
                            <img src="<?php echo esc_url($banner['image']); ?>" alt="<?php echo esc_attr($banner['title']); ?>" class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black" style="opacity: 0.3;"></div>
                            <div class="absolute inset-0 flex flex-col justify-center px-3 py-4">
                                <div style="max-width: 18rem;">
                                    <h3 class="text-xs font-bold text-white line-clamp-1 leading-tight mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                        <?php echo esc_html($banner['title']); ?>
                                    </h3>
                                    <span class="btn btn-white btn-sm text-xs inline-flex items-center gap-1" style="padding: 0.25rem 0.75rem; height: 1.5rem;">
                                        <?php _e('Shop Now', 'shoobu'); ?>
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M5 12h14M12 5l7 7-7 7"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @media (min-width: 1024px) {
        .hero-grid {
            grid-template-columns: 3fr 2fr;
        }
    }
</style>
