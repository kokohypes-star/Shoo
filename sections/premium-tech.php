<?php
/**
 * Premium Tech Section Template
 *
 * @package Shoobu
 */

$title = get_theme_mod('shoobu_premium_title', __('Premium Tech,', 'shoobu'));
$title_highlight = get_theme_mod('shoobu_premium_title_highlight', __('Unbeatable Prices', 'shoobu'));
$description = get_theme_mod('shoobu_premium_description', __('Discover our curated collection of the latest tech gadgets and accessories. Fast shipping, secure checkout, and 30-day returns guaranteed.', 'shoobu'));
?>

<section id="premium-tech-section" class="premium-tech-section">
    <div class="container px-4 md:px-6 lg:px-8">
        <div class="space-y-8 text-center py-12">
            <div class="space-y-4">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    <span class="block md:inline"><?php echo esc_html($title); ?></span>
                    <span class="block md:inline text-gradient md:ml-2">
                        <?php echo esc_html($title_highlight); ?>
                    </span>
                </h1>
                <p class="text-gray-500 max-w-2xl mx-auto leading-relaxed" style="font-size: 0.80rem; font-weight: 500;">
                    <?php echo esc_html($description); ?>
                </p>
            </div>
        </div>
    </div>
</section>
