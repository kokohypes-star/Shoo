<?php
/**
 * Template Name: Login Page
 *
 * @package Shoobu
 */

get_header();
?>

<main id="main-content" class="site-main">
    <div class="container py-12 px-4 md:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            <div class="card p-8">
                <h1 class="text-3xl font-bold mb-2 text-center"><?php _e('Welcome Back', 'shoobu'); ?></h1>
                <p class="text-gray-500 text-center mb-6"><?php _e('Sign in to your account to continue', 'shoobu'); ?></p>

                <form method="post" class="space-y-4" data-testid="form-login">
                    <div>
                        <label for="username" class="block text-sm font-medium mb-2"><?php _e('Email or Username', 'shoobu'); ?></label>
                        <input type="text" id="username" name="username" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-600" data-testid="input-username">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium mb-2"><?php _e('Password', 'shoobu'); ?></label>
                        <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-600" data-testid="input-password">
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="remember" class="w-4 h-4 border border-gray-300 rounded" data-testid="checkbox-remember">
                            <span><?php _e('Remember me', 'shoobu'); ?></span>
                        </label>
                        <a href="<?php echo esc_url(home_url('/forgot-password/')); ?>" class="text-purple-600 hover:underline" data-testid="link-forgot-password"><?php _e('Forgot password?', 'shoobu'); ?></a>
                    </div>

                    <button type="submit" class="btn btn-primary w-full py-3" data-testid="button-login"><?php _e('Sign In', 'shoobu'); ?></button>
                </form>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500"><?php _e('or', 'shoobu'); ?></span>
                    </div>
                </div>

                <div class="space-y-3">
                    <button type="button" class="btn btn-outline w-full py-3 flex items-center justify-center gap-2" data-testid="button-google">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                        </svg>
                        <?php _e('Sign in with Google', 'shoobu'); ?>
                    </button>
                </div>

                <p class="text-center text-sm text-gray-600 mt-6">
                    <?php _e('Don\'t have an account?', 'shoobu'); ?>
                    <a href="<?php echo esc_url(home_url('/register/')); ?>" class="text-purple-600 font-semibold hover:underline" data-testid="link-register"><?php _e('Sign up', 'shoobu'); ?></a>
                </p>
            </div>

            <!-- Info Box -->
            <div class="mt-8 p-6 bg-blue-50 border border-blue-200 rounded-md">
                <h3 class="font-semibold mb-2 text-blue-900"><?php _e('Demo Information', 'shoobu'); ?></h3>
                <p class="text-sm text-blue-800"><?php _e('This is a preview site. Authentication is simulated for demonstration purposes.', 'shoobu'); ?></p>
            </div>
        </div>
    </div>
</main>

<style>
    .btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>

<?php get_footer(); ?>
