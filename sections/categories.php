<?php
/**
 * Categories Section Template
 *
 * @package Shoobu
 */

$categories = array(
    array(
        'name'     => __('Audio', 'shoobu'),
        'icon'     => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/></svg>',
        'bg_light' => 'bg-blue-100',
        'slug'     => 'audio',
    ),
    array(
        'name'     => __('Wearables', 'shoobu'),
        'icon'     => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="7"/><polyline points="12 9 12 12 13.5 13.5"/><path d="M16.51 17.35l-.35 3.83a2 2 0 0 1-2 1.82H9.83a2 2 0 0 1-2-1.82l-.35-3.83m.01-10.7l.35-3.83A2 2 0 0 1 9.83 1h4.35a2 2 0 0 1 2 1.82l.35 3.83"/></svg>',
        'bg_light' => 'bg-purple-100',
        'slug'     => 'wearables',
    ),
    array(
        'name'     => __('Cables', 'shoobu'),
        'icon'     => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 9a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9z"/><path d="M8 7V3m8 4V3M4 10h16"/></svg>',
        'bg_light' => 'bg-orange-100',
        'slug'     => 'cables',
    ),
    array(
        'name'     => __('Accessories', 'shoobu'),
        'icon'     => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
        'bg_light' => 'bg-green-100',
        'slug'     => 'accessories',
    ),
    array(
        'name'     => __('Chargers', 'shoobu'),
        'icon'     => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18h6"/><path d="M10 22h4"/><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14"/></svg>',
        'bg_light' => 'bg-red-100',
        'slug'     => 'chargers',
    ),
);
?>

<section id="categories-section" class="categories-section px-4 md:px-6 lg:px-8 w-full" style="margin-bottom: 30px;">
    <div class="container space-y-8">
        <div class="grid gap-1 md:gap-4" style="grid-template-columns: repeat(5, 1fr); margin-top: -1.5rem;">
            <?php foreach ($categories as $cat) : 
                $term = get_term_by('slug', $cat['slug'], 'shoobu_category');
                $link = $term ? get_term_link($term) : get_post_type_archive_link('shoobu_product') . '?category=' . $cat['slug'];
            ?>
                <a href="<?php echo esc_url($link); ?>" class="category-card group p-2 md:p-6 border transition text-center flex flex-col items-center justify-center" style="border-radius: 0.3rem;">
                    <!-- Mobile: Icon with background -->
                    <div class="md:hidden">
                        <div class="category-icon-mobile w-12 h-12 <?php echo esc_attr($cat['bg_light']); ?> flex items-center justify-center" style="border-radius: 0.3rem;">
                            <?php echo $cat['icon']; ?>
                        </div>
                    </div>
                    <!-- Desktop: Icon only -->
                    <div class="hidden md:block category-icon text-gray-800 group-hover:text-gray-900">
                        <?php echo str_replace('width="32"', 'width="40"', str_replace('height="32"', 'height="40"', $cat['icon'])); ?>
                    </div>
                    <p class="hidden md:block text-xs md:text-lg font-semibold text-gray-800 mt-2"><?php echo esc_html($cat['name']); ?></p>
                    <p class="text-xs text-gray-700 opacity-0 group-hover:opacity-100 transition-opacity"><?php _e('Shop now', 'shoobu'); ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
    .category-card svg {
        stroke: #1f2937;
    }
    .bg-blue-100 { background-color: #dbeafe; }
    .bg-purple-100 { background-color: #f3e8ff; }
    .bg-orange-100 { background-color: #ffedd5; }
    .bg-green-100 { background-color: #dcfce7; }
    .bg-red-100 { background-color: #fee2e2; }
</style>
