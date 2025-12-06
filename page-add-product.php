<?php
/**
 * Template Name: Shoobu Add Product
 *
 * Passwordless product addition page with token-based access.
 *
 * @package Shoobu
 */

get_header();
?>

<main id="main-content" class="site-main">
    <div class="container py-8 px-4 md:px-6 lg:px-8">
        <?php echo do_shortcode('[shoobu_add_product]'); ?>
    </div>
</main>

<?php get_footer(); ?>
