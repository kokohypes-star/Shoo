<?php
/**
 * Main Template File
 *
 * @package Shoobu
 */

// Load page template if it exists
if (is_page()) {
    $template_name = get_page_template_slug();
    if ($template_name && file_exists(get_template_directory() . '/' . $template_name)) {
        include(get_template_directory() . '/' . $template_name);
        exit;
    }
}

get_header();
?>

<main id="main-content" class="site-main">
    <?php if (is_front_page()) : ?>
        <?php get_template_part('sections/hero'); ?>
        <?php get_template_part('sections/categories'); ?>
        <?php get_template_part('sections/featured-products'); ?>
        <?php get_template_part('sections/premium-tech'); ?>
        <?php get_template_part('sections/features'); ?>
    <?php elseif (is_home() || is_archive()) : ?>
        <div class="container py-8">
            <h1 class="text-3xl font-bold mb-6"><?php echo is_home() ? __('Latest Posts', 'shoobu') : get_the_archive_title(); ?></h1>
            <?php if (have_posts()) : ?>
                <div class="grid gap-6" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
                    <?php while (have_posts()) : the_post(); ?>
                        <article class="card p-6">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="mb-4 rounded-md overflow-hidden" style="height: 200px;">
                                    <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover')); ?>
                                </div>
                            <?php endif; ?>
                            <h2 class="text-xl font-semibold mb-2">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="text-gray-500 text-sm">
                                <?php the_excerpt(); ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                <?php the_posts_pagination(); ?>
            <?php else : ?>
                <p><?php _e('No posts found.', 'shoobu'); ?></p>
            <?php endif; ?>
        </div>
    <?php else : ?>
        <div class="container py-8">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article class="max-w-3xl mx-auto">
                        <h1 class="text-4xl font-bold mb-6"><?php the_title(); ?></h1>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="mb-8 rounded-md overflow-hidden">
                                <?php the_post_thumbnail('large', array('class' => 'w-full')); ?>
                            </div>
                        <?php endif; ?>
                        <div class="prose">
                            <?php the_content(); ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
