<?php
/**
 * Archive Template (fallback for all custom post type archives)
 *
 * @package Shoobu
 */

// For custom post types like shoobu_product, use the post type template
if (is_post_type_archive('shoobu_product')) {
    include(get_template_directory() . '/archive-shoobu_product.php');
} else {
    // Default archive display
    get_header();
    ?>
    <main id="main-content" class="site-main">
        <div class="container py-8">
            <h1><?php the_archive_title(); ?></h1>
            <?php
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    ?>
                    <article class="mb-8">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="entry-content">
                            <?php the_excerpt(); ?>
                        </div>
                    </article>
                    <?php
                endwhile;
            else :
                echo '<p>' . __('Sorry, no posts found.', 'shoobu') . '</p>';
            endif;
            ?>
        </div>
    </main>
    <?php
    get_footer();
}
