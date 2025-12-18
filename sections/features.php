<?php
/**
 * Features Section Template
 *
 * @package Shoobu
 */

$features = array(
    array(
        'icon'  => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>',
        'title' => get_theme_mod('shoobu_feature1_title', __('Free Shipping', 'shoobu')),
        'desc'  => get_theme_mod('shoobu_feature1_desc', __('On orders over $50', 'shoobu')),
    ),
    array(
        'icon'  => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
        'title' => get_theme_mod('shoobu_feature2_title', __('Secure Payment', 'shoobu')),
        'desc'  => get_theme_mod('shoobu_feature2_desc', __('100% protected', 'shoobu')),
    ),
    array(
        'icon'  => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
        'title' => get_theme_mod('shoobu_feature3_title', __('Quality Products', 'shoobu')),
        'desc'  => get_theme_mod('shoobu_feature3_desc', __('Curated selection', 'shoobu')),
    ),
    array(
        'icon'  => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>',
        'title' => get_theme_mod('shoobu_feature4_title', __('30-Day Returns', 'shoobu')),
        'desc'  => get_theme_mod('shoobu_feature4_desc', __('Easy refunds', 'shoobu')),
    ),
);
?>

<section id="features-section" class="features-section py-12 bg-gray-50">
    <div class="container px-4 md:px-6 lg:px-8">
        <div class="grid gap-6" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
            <?php foreach ($features as $feature) : ?>
                <div class="feature-card text-center p-6">
                    <div class="feature-icon flex justify-center mb-4 text-purple-600">
                        <?php echo $feature['icon']; ?>
                    </div>
                    <h3 class="font-semibold mb-2"><?php echo esc_html($feature['title']); ?></h3>
                    <p class="text-sm text-gray-500"><?php echo esc_html($feature['desc']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
