    <footer id="colophon" class="site-footer">
        <!-- Desktop Footer -->
        <div class="hidden md:block border-t bg-gray-50 py-12">
            <div class="container">
                <div class="grid gap-8" style="grid-template-columns: repeat(4, 1fr);">
                    <!-- Brand -->
                    <div>
                        <h3 class="animate-gradient-text text-3xl font-black mb-4" style="font-family: 'Nexa Bold', 'Montserrat', sans-serif;">SHOOBU</h3>
                        <p class="text-gray-500 text-sm">Premium tech products at unbeatable prices. Fast shipping, secure checkout, and 30-day returns guaranteed.</p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="font-semibold mb-4"><?php _e('Quick Links', 'shoobu'); ?></h4>
                        <ul class="space-y-2 text-sm text-gray-500">
                            <li><a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-purple-600"><?php _e('Home', 'shoobu'); ?></a></li>
                            <li><a href="<?php echo esc_url(get_post_type_archive_link('shoobu_product')); ?>" class="hover:text-purple-600"><?php _e('Shop', 'shoobu'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/cart/')); ?>" class="hover:text-purple-600"><?php _e('Cart', 'shoobu'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/about/')); ?>" class="hover:text-purple-600"><?php _e('About Us', 'shoobu'); ?></a></li>
                        </ul>
                    </div>

                    <!-- Categories -->
                    <div>
                        <h4 class="font-semibold mb-4"><?php _e('Categories', 'shoobu'); ?></h4>
                        <ul class="space-y-2 text-sm text-gray-500">
                            <?php
                            $categories = get_terms(array(
                                'taxonomy'   => 'shoobu_category',
                                'hide_empty' => false,
                                'number'     => 5,
                            ));
                            if (!is_wp_error($categories) && !empty($categories)) :
                                foreach ($categories as $category) :
                            ?>
                                <li>
                                    <a href="<?php echo esc_url(get_term_link($category)); ?>" class="hover:text-purple-600">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                </li>
                            <?php 
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h4 class="font-semibold mb-4"><?php _e('Contact', 'shoobu'); ?></h4>
                        <ul class="space-y-2 text-sm text-gray-500">
                            <li class="flex items-center gap-2">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                                support@shoobu.com
                            </li>
                            <li class="flex items-center gap-2">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                                +234 800 123 4567
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t mt-8 pt-8 text-center text-sm text-gray-500">
                    &copy; <?php echo date('Y'); ?> SHOOBU &mdash; <?php _e('All Rights Reserved', 'shoobu'); ?>
                </div>
            </div>
        </div>

        <!-- Mobile Footer (simple) -->
        <div class="md:hidden w-full text-center text-sm text-gray-500 py-6 border-t" style="padding-bottom: 80px;">
            &copy; <?php echo date('Y'); ?> SHOOBU &mdash; <?php _e('All Rights Reserved', 'shoobu'); ?>
        </div>

        <!-- Mobile Footer Navigation Bar -->
        <nav id="mobile-footer-nav" class="mobile-footer-nav md:hidden fixed bottom-0 left-0 w-full bg-white border-t z-50" style="right: 0; height: auto; border-color: var(--shoobu-border);">
            <div class="flex items-center justify-center w-full" style="padding: 1rem 0; gap: 2rem;">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-nav-item flex flex-col items-center justify-center gap-1" style="color: var(--shoobu-text-light); transition: all 0.2s ease;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    <span class="text-xs font-medium" style="letter-spacing: 0.3px;"><?php _e('Home', 'shoobu'); ?></span>
                </a>

                <a href="<?php echo esc_url(get_post_type_archive_link('shoobu_product')); ?>" class="mobile-nav-item flex flex-col items-center justify-center gap-1" style="color: var(--shoobu-text-light); transition: all 0.2s ease;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 9l12-1L18.5 4m4.5 8l-3 12H4.5l-3-12m3 0L7 4m10 5l-3.5-9"/>
                    </svg>
                    <span class="text-xs font-medium" style="letter-spacing: 0.3px;"><?php _e('Shop', 'shoobu'); ?></span>
                </a>

                <a href="<?php echo esc_url(home_url('/cart/')); ?>" class="mobile-nav-item flex flex-col items-center justify-center gap-1" style="color: var(--shoobu-primary); transition: all 0.2s ease;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    <span class="text-xs font-medium" style="letter-spacing: 0.3px;"><?php _e('Cart', 'shoobu'); ?></span>
                </a>

                <a href="<?php echo esc_url(home_url('/login/')); ?>" class="mobile-nav-item flex flex-col items-center justify-center gap-1" style="color: var(--shoobu-text-light); transition: all 0.2s ease;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 12h18M12 3l9 9-9 9"/>
                    </svg>
                    <span class="text-xs font-medium" style="letter-spacing: 0.3px;"><?php _e('Login', 'shoobu'); ?></span>
                </a>
            </div>
        </nav>
        
        <style>
            @media (max-width: 767px) {
                #page {
                    width: 100% !important;
                    height: auto !important;
                    overflow-x: hidden;
                }
                
                .mobile-nav-item:hover {
                    color: var(--shoobu-primary);
                }
                
                .mobile-nav-item svg {
                    transition: transform 0.2s ease;
                }
                
                .mobile-nav-item:hover svg {
                    transform: scale(1.05);
                }
                
                .hero-slider, .carousel-container, .swiper-container {
                    margin-bottom: 30px !important;
                    width: 100% !important;
                    height: auto !important;
                }
            }
        </style>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
