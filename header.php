<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link sr-only" href="#main-content"><?php _e('Skip to content', 'shoobu'); ?></a>

    <header id="masthead" class="site-header sticky top-0 z-40 bg-white border-b">
        <div class="container">
            <div class="header-inner flex items-center justify-between gap-4" style="height: 65px;">
                <?php /* Mobile view height is 65px, desktop is 108px */ ?>
                
                <!-- Logo -->
                <div class="site-branding">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                        <?php if (has_custom_logo()) : ?>
                            <?php the_custom_logo(); ?>
                        <?php else : ?>
                            <h1 class="site-title animate-gradient-text cursor-pointer text-4xl md:text-6xl" style="font-family: 'Nexa Bold', 'Montserrat', sans-serif; font-weight: 900; line-height: 1;">
                                SHOOBU
                            </h1>
                        <?php endif; ?>
                    </a>
                </div>

                <!-- Desktop Search Bar -->
                <div class="search-bar hidden md:flex flex-1 max-w-xl mx-4">
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-form flex w-full">
                        <input type="hidden" name="post_type" value="shoobu_product">
                        <input 
                            type="search" 
                            name="s" 
                            placeholder="<?php esc_attr_e('Search products...', 'shoobu'); ?>" 
                            value="<?php echo get_search_query(); ?>"
                            class="search-input flex-1 px-4 py-2 border border-gray-300 rounded-l-full focus:outline-none focus:border-purple-500"
                            data-testid="input-search"
                        >
                        <button type="submit" class="search-submit px-4 py-2 bg-purple-600 text-white border border-purple-600 rounded-r-full" data-testid="button-search">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"/>
                                <path d="m21 21-4.35-4.35"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Desktop Navigation -->
                <nav class="main-nav hidden md:flex items-center gap-6 text-base font-medium">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link"><?php _e('Home', 'shoobu'); ?></a>
                    <a href="<?php echo esc_url(get_post_type_archive_link('shoobu_product')); ?>" class="nav-link"><?php _e('Shop', 'shoobu'); ?></a>
                    <a href="<?php echo esc_url(home_url('/cart/')); ?>" class="nav-link"><?php _e('Cart', 'shoobu'); ?></a>
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(home_url('/account/')); ?>" class="nav-link"><?php _e('Account', 'shoobu'); ?></a>
                    <?php else : ?>
                        <a href="<?php echo esc_url(wp_login_url()); ?>" class="nav-link"><?php _e('Login', 'shoobu'); ?></a>
                    <?php endif; ?>
                </nav>

                <!-- Mobile Navigation -->
                <nav class="mobile-nav md:hidden flex items-center gap-6">
                    <!-- Search Icon -->
                    <button type="button" id="mobile-search-toggle" class="p-1" data-testid="button-mobile-search">
                        <svg class="search-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.35-4.35"/>
                        </svg>
                        <svg class="close-icon hidden" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 6 6 18M6 6l12 12"/>
                        </svg>
                    </button>

                    <!-- Cart Icon -->
                    <a href="<?php echo esc_url(home_url('/cart/')); ?>" class="cart-icon relative">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"/>
                            <circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                        <span id="cart-count" class="cart-badge absolute -top-2 -right-2 bg-purple-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">0</span>
                    </a>

                    <!-- Profile Icon -->
                    <a href="<?php echo is_user_logged_in() ? esc_url(home_url('/account/')) : esc_url(wp_login_url()); ?>" class="user-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Mobile Search Dropdown -->
        <div id="mobile-search-dropdown" class="mobile-search-dropdown md:hidden absolute left-0 right-0 top-full bg-white border-b shadow-lg overflow-hidden" style="max-height: 0; opacity: 0; transition: all 0.3s ease-in-out;">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="p-3">
                <input type="hidden" name="post_type" value="shoobu_product">
                <div class="flex gap-2">
                    <input 
                        type="search" 
                        name="s" 
                        placeholder="<?php esc_attr_e('Search products...', 'shoobu'); ?>" 
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:border-purple-500 text-sm"
                        data-testid="input-mobile-search"
                    >
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-full" data-testid="button-mobile-search-submit">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.35-4.35"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </header>

    <style>
        @media (min-width: 768px) {
            .header-inner {
                height: 108px !important;
            }
        }
    </style>
