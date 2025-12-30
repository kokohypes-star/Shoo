<?php
/**
 * Template Name: Cart Page
 *
 * @package Shoobu
 */

get_header();
?>

<main id="main-content" class="site-main">
    <div class="container py-6 md:py-8 px-4 md:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6 md:mb-8"><?php _e('Shopping Cart', 'shoobu'); ?></h1>
        
        <div id="cart-container" class="cart-layout grid gap-6 md:gap-8" style="grid-template-columns: 1fr;">
            <!-- Cart Items -->
            <div id="cart-items" class="cart-items space-y-4">
                <div class="empty-cart text-center py-12" id="empty-cart">
                    <svg class="mx-auto mb-4 text-gray-300" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    <h2 class="text-xl font-semibold mb-2"><?php _e('Your cart is empty', 'shoobu'); ?></h2>
                    <p class="text-gray-500 mb-4"><?php _e('Looks like you haven\'t added any items to your cart yet.', 'shoobu'); ?></p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('shoobu_product')); ?>" class="btn btn-primary" data-testid="button-continue-shopping">
                        <?php _e('Continue Shopping', 'shoobu'); ?>
                    </a>
                </div>
                
                <!-- Cart items will be rendered here by JavaScript -->
                <div id="cart-items-list" class="space-y-4"></div>
            </div>

            <!-- Cart Summary - Mobile & Desktop -->
            <div id="cart-summary" class="cart-summary hidden">
                <!-- Mobile Cart Summary (Fixed Bottom) -->
                <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t p-4 z-40">
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600"><?php _e('Subtotal', 'shoobu'); ?></span>
                            <span id="cart-subtotal-mobile" class="font-semibold" data-testid="text-subtotal-mobile">&#8358;0</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600"><?php _e('Shipping', 'shoobu'); ?></span>
                            <span class="text-green-600 text-sm"><?php _e('Free', 'shoobu'); ?></span>
                        </div>
                        <div class="border-t pt-2 flex justify-between">
                            <span class="font-bold"><?php _e('Total', 'shoobu'); ?></span>
                            <span id="cart-total-mobile" class="text-lg font-bold text-purple-600" data-testid="text-total-mobile">&#8358;0</span>
                        </div>
                    </div>
                    <a href="<?php echo esc_url(home_url('/checkout/')); ?>" class="btn btn-primary w-full mb-2" data-testid="button-checkout-mobile">
                        <?php _e('Checkout', 'shoobu'); ?>
                    </a>
                </div>

                <!-- Desktop Cart Summary (Sidebar) -->
                <div class="hidden md:block card p-6 sticky top-24">
                    <h2 class="text-xl font-bold mb-4"><?php _e('Order Summary', 'shoobu'); ?></h2>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600"><?php _e('Subtotal', 'shoobu'); ?></span>
                            <span id="cart-subtotal-desktop" class="font-semibold" data-testid="text-subtotal-desktop">&#8358;0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600"><?php _e('Shipping', 'shoobu'); ?></span>
                            <span class="text-green-600"><?php _e('Free', 'shoobu'); ?></span>
                        </div>
                        <div class="border-t pt-3 flex justify-between">
                            <span class="font-bold"><?php _e('Total', 'shoobu'); ?></span>
                            <span id="cart-total-desktop" class="text-xl font-bold text-purple-600" data-testid="text-total-desktop">&#8358;0</span>
                        </div>
                    </div>
                    
                    <a href="<?php echo esc_url(home_url('/checkout/')); ?>" class="btn btn-primary btn-lg w-full mb-3" data-testid="button-checkout-desktop">
                        <?php _e('Proceed to Checkout', 'shoobu'); ?>
                    </a>
                    
                    <a href="<?php echo esc_url(get_post_type_archive_link('shoobu_product')); ?>" class="btn btn-outline w-full" data-testid="button-continue-shopping-summary">
                        <?php _e('Continue Shopping', 'shoobu'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    @media (min-width: 768px) {
        .cart-layout {
            grid-template-columns: 1fr 350px;
        }
    }
    
    .cart-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
    }
    
    .cart-item-image {
        width: 100px;
        height: 100px;
        border-radius: 0.375rem;
        overflow: hidden;
        flex-shrink: 0;
    }
    
    .cart-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .cart-item-details {
        flex: 1;
    }
    
    .cart-item-quantity {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .cart-item-quantity button {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e5e7eb;
        border-radius: 0.25rem;
        background: #fff;
        cursor: pointer;
    }
    
    .cart-item-quantity button:hover {
        background: #f3f4f6;
    }
    
    .cart-item-quantity input {
        width: 50px;
        text-align: center;
        border: 1px solid #e5e7eb;
        border-radius: 0.25rem;
        padding: 0.25rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function renderCart() {
        const cart = JSON.parse(localStorage.getItem('sf_cart') || '[]');
        const cartItemsList = document.getElementById('cart-items-list');
        const emptyCart = document.getElementById('empty-cart');
        const cartSummary = document.getElementById('cart-summary');
        
        // Update all subtotal and total elements
        const subtotalEls = [
            document.getElementById('cart-subtotal-mobile'),
            document.getElementById('cart-subtotal-desktop')
        ];
        const totalEls = [
            document.getElementById('cart-total-mobile'),
            document.getElementById('cart-total-desktop')
        ];
        
        if (cart.length === 0) {
            emptyCart.style.display = 'block';
            cartItemsList.innerHTML = '';
            cartSummary.classList.add('hidden');
            // Add padding to avoid overlap with footer nav on mobile
            document.body.style.paddingBottom = '80px';
            return;
        }
        
        emptyCart.style.display = 'none';
        cartSummary.classList.remove('hidden');
        // Add padding to avoid overlap with cart summary on mobile
        document.body.style.paddingBottom = '200px';
        
        let subtotal = 0;
        let html = '';
        
        cart.forEach(function(item, index) {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            
            html += `
                <div class="cart-item card" data-index="${index}">
                    <div class="flex gap-4">
                        <div class="cart-item-image flex-shrink-0">
                            <img src="${item.image}" alt="${item.name}">
                        </div>
                        <div class="cart-item-details flex-1">
                            <h3 class="font-semibold text-lg mb-1">${item.name}</h3>
                            <p class="text-purple-600 font-bold mb-3">&#8358;${item.price.toLocaleString()}</p>
                            <div class="cart-item-quantity flex items-center gap-2 flex-wrap">
                                <button type="button" class="qty-decrease px-2 py-1 border rounded" data-index="${index}">−</button>
                                <input type="number" value="${item.quantity}" min="1" readonly class="w-12 text-center border rounded py-1">
                                <button type="button" class="qty-increase px-2 py-1 border rounded" data-index="${index}">+</button>
                                <button type="button" class="remove-item ml-auto text-red-600 text-sm font-semibold hover:text-red-700" data-index="${index}">Remove</button>
                            </div>
                        </div>
                        <div class="cart-item-total text-right flex-shrink-0">
                            <p class="font-bold text-purple-600">&#8358;${itemTotal.toLocaleString()}</p>
                        </div>
                    </div>
                </div>
            `;
        });
        
        cartItemsList.innerHTML = html;
        
        // Update all subtotal and total displays
        subtotalEls.forEach(el => {
            if (el) el.textContent = '₦' + subtotal.toLocaleString();
        });
        totalEls.forEach(el => {
            if (el) el.textContent = '₦' + subtotal.toLocaleString();
        });
        
        // Attach event listeners
        cartItemsList.querySelectorAll('.qty-decrease').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const idx = parseInt(this.getAttribute('data-index'));
                if (cart[idx].quantity > 1) {
                    cart[idx].quantity--;
                    localStorage.setItem('sf_cart', JSON.stringify(cart));
                    window.dispatchEvent(new Event('storage'));
                    renderCart();
                }
            });
        });
        
        cartItemsList.querySelectorAll('.qty-increase').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const idx = parseInt(this.getAttribute('data-index'));
                cart[idx].quantity++;
                localStorage.setItem('sf_cart', JSON.stringify(cart));
                window.dispatchEvent(new Event('storage'));
                renderCart();
            });
        });
        
        cartItemsList.querySelectorAll('.remove-item').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const idx = parseInt(this.getAttribute('data-index'));
                cart.splice(idx, 1);
                localStorage.setItem('sf_cart', JSON.stringify(cart));
                window.dispatchEvent(new Event('storage'));
                renderCart();
            });
        });
    }
    
    renderCart();
    
    window.addEventListener('storage', renderCart);
});
</script>

<?php get_footer(); ?>
