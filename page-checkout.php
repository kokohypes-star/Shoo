<?php
/**
 * Template Name: Checkout Page
 *
 * @package Shoobu
 */

get_header();
?>

<main id="main-content" class="site-main">
    <div class="container py-8 px-4 md:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-8"><?php _e('Checkout', 'shoobu'); ?></h1>

        <div class="grid gap-8" style="grid-template-columns: 1fr;">
            <!-- Checkout Form -->
            <div class="checkout-form">
                <form method="post" class="space-y-6" data-testid="form-checkout">
                    <!-- Shipping Information -->
                    <section class="card p-6">
                        <h2 class="text-xl font-bold mb-4"><?php _e('Shipping Address', 'shoobu'); ?></h2>
                        <div class="grid gap-4" style="grid-template-columns: repeat(2, 1fr);">
                            <input type="text" name="first_name" placeholder="<?php _e('First Name', 'shoobu'); ?>" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-600" required data-testid="input-first-name">
                            <input type="text" name="last_name" placeholder="<?php _e('Last Name', 'shoobu'); ?>" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-600" required data-testid="input-last-name">
                        </div>
                        <input type="email" name="email" placeholder="<?php _e('Email Address', 'shoobu'); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-600 mt-4" required data-testid="input-email">
                        <input type="text" name="phone" placeholder="<?php _e('Phone Number', 'shoobu'); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-600 mt-4" required data-testid="input-phone">
                        <input type="text" name="address" placeholder="<?php _e('Street Address', 'shoobu'); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-600 mt-4" required data-testid="input-address">
                        <div class="grid gap-4 mt-4" style="grid-template-columns: repeat(2, 1fr);">
                            <input type="text" name="city" placeholder="<?php _e('City', 'shoobu'); ?>" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-600" required data-testid="input-city">
                            <input type="text" name="state" placeholder="<?php _e('State', 'shoobu'); ?>" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-600" required data-testid="input-state">
                        </div>
                        <input type="text" name="postcode" placeholder="<?php _e('Post Code', 'shoobu'); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-600 mt-4" required data-testid="input-postcode">
                    </section>

                    <!-- Payment Information -->
                    <section class="card p-6">
                        <h2 class="text-xl font-bold mb-4"><?php _e('Payment Method', 'shoobu'); ?></h2>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3">
                                <input type="radio" name="payment" value="card" checked class="w-4 h-4">
                                <span><?php _e('Credit/Debit Card', 'shoobu'); ?></span>
                            </label>
                            <label class="flex items-center gap-3">
                                <input type="radio" name="payment" value="bank_transfer" class="w-4 h-4">
                                <span><?php _e('Bank Transfer', 'shoobu'); ?></span>
                            </label>
                            <label class="flex items-center gap-3">
                                <input type="radio" name="payment" value="ussd" class="w-4 h-4">
                                <span><?php _e('USSD', 'shoobu'); ?></span>
                            </label>
                        </div>
                    </section>

                    <!-- Order Summary -->
                    <section class="card p-6">
                        <h2 class="text-xl font-bold mb-4"><?php _e('Order Summary', 'shoobu'); ?></h2>
                        <div id="order-items" class="space-y-2 mb-4">
                            <!-- Items will be populated by JavaScript -->
                        </div>
                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between">
                                <span><?php _e('Subtotal', 'shoobu'); ?></span>
                                <span id="order-subtotal">₦0</span>
                            </div>
                            <div class="flex justify-between">
                                <span><?php _e('Shipping', 'shoobu'); ?></span>
                                <span class="text-green-600"><?php _e('Free', 'shoobu'); ?></span>
                            </div>
                            <div class="flex justify-between font-bold text-lg border-t pt-2">
                                <span><?php _e('Total', 'shoobu'); ?></span>
                                <span id="order-total" class="text-purple-600">₦0</span>
                            </div>
                        </div>
                    </section>

                    <button type="submit" class="btn btn-primary btn-lg w-full py-3" data-testid="button-place-order"><?php _e('Place Order', 'shoobu'); ?></button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cart = JSON.parse(localStorage.getItem('sf_cart') || '[]');
    const orderItems = document.getElementById('order-items');
    const subtotalEl = document.getElementById('order-subtotal');
    const totalEl = document.getElementById('order-total');

    if (cart.length === 0) {
        orderItems.innerHTML = '<p class="text-gray-500"><?php _e('Your cart is empty', 'shoobu'); ?></p>';
        return;
    }

    let subtotal = 0;
    let html = '';

    cart.forEach(function(item) {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;
        html += '<div class="flex justify-between text-sm"><span>' + item.name + ' x' + item.quantity + '</span><span>₦' + itemTotal.toLocaleString() + '</span></div>';
    });

    orderItems.innerHTML = html;
    subtotalEl.textContent = '₦' + subtotal.toLocaleString();
    totalEl.textContent = '₦' + subtotal.toLocaleString();

    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('<?php _e('Thank you for your order! This is a demo site. Your order has been received.', 'shoobu'); ?>');
        localStorage.setItem('sf_cart', '[]');
        window.location.href = '<?php echo esc_js(home_url('/')); ?>';
    });
});
</script>

<?php get_footer(); ?>
