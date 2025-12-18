/**
 * Shoobu Theme - Cart JavaScript
 *
 * @package Shoobu
 * @version 1.0.0
 */

(function() {
    'use strict';

    const CART_STORAGE_KEY = 'sf_cart';

    /**
     * ShoobuCart - Shopping Cart Manager
     */
    window.ShoobuCart = {
        /**
         * Get current cart from localStorage
         * @returns {Array}
         */
        getCart: function() {
            try {
                return JSON.parse(localStorage.getItem(CART_STORAGE_KEY) || '[]');
            } catch (e) {
                console.error('Error reading cart:', e);
                return [];
            }
        },

        /**
         * Save cart to localStorage
         * @param {Array} cart
         */
        saveCart: function(cart) {
            try {
                localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
                this.dispatchUpdate();
            } catch (e) {
                console.error('Error saving cart:', e);
            }
        },

        /**
         * Dispatch cart update events
         */
        dispatchUpdate: function() {
            window.dispatchEvent(new Event('storage'));
            window.dispatchEvent(new CustomEvent('cart-updated', {
                detail: {
                    cart: this.getCart(),
                    count: this.getCount(),
                    total: this.getTotal()
                }
            }));
        },

        /**
         * Add item to cart
         * @param {string} productId
         * @param {string} name
         * @param {number} price
         * @param {string} image
         * @param {number} quantity
         */
        addToCart: function(productId, name, price, image, quantity) {
            quantity = parseInt(quantity) || 1;
            price = parseFloat(price) || 0;

            const cart = this.getCart();
            const existingIndex = cart.findIndex(item => item.id === productId);

            if (existingIndex > -1) {
                cart[existingIndex].quantity += quantity;
            } else {
                cart.push({
                    id: productId,
                    name: name,
                    price: price,
                    image: image || '',
                    quantity: quantity
                });
            }

            this.saveCart(cart);
            this.showNotification('Item added to cart');
        },

        /**
         * Remove item from cart
         * @param {string} productId
         */
        removeFromCart: function(productId) {
            const cart = this.getCart().filter(item => item.id !== productId);
            this.saveCart(cart);
            this.showNotification('Item removed from cart');
        },

        /**
         * Update item quantity
         * @param {string} productId
         * @param {number} quantity
         */
        updateQuantity: function(productId, quantity) {
            quantity = parseInt(quantity);
            const cart = this.getCart();
            const item = cart.find(item => item.id === productId);

            if (item) {
                if (quantity <= 0) {
                    this.removeFromCart(productId);
                } else {
                    item.quantity = quantity;
                    this.saveCart(cart);
                }
            }
        },

        /**
         * Increment item quantity
         * @param {string} productId
         */
        incrementQuantity: function(productId) {
            const cart = this.getCart();
            const item = cart.find(item => item.id === productId);

            if (item) {
                item.quantity++;
                this.saveCart(cart);
            }
        },

        /**
         * Decrement item quantity
         * @param {string} productId
         */
        decrementQuantity: function(productId) {
            const cart = this.getCart();
            const item = cart.find(item => item.id === productId);

            if (item) {
                if (item.quantity > 1) {
                    item.quantity--;
                    this.saveCart(cart);
                } else {
                    this.removeFromCart(productId);
                }
            }
        },

        /**
         * Get cart total
         * @returns {number}
         */
        getTotal: function() {
            return this.getCart().reduce((total, item) => {
                return total + (parseFloat(item.price) * parseInt(item.quantity));
            }, 0);
        },

        /**
         * Get cart item count
         * @returns {number}
         */
        getCount: function() {
            return this.getCart().reduce((count, item) => {
                return count + parseInt(item.quantity);
            }, 0);
        },

        /**
         * Clear all items from cart
         */
        clearCart: function() {
            localStorage.removeItem(CART_STORAGE_KEY);
            this.dispatchUpdate();
            this.showNotification('Cart cleared');
        },

        /**
         * Check if product is in cart
         * @param {string} productId
         * @returns {boolean}
         */
        isInCart: function(productId) {
            return this.getCart().some(item => item.id === productId);
        },

        /**
         * Get item from cart
         * @param {string} productId
         * @returns {Object|null}
         */
        getItem: function(productId) {
            return this.getCart().find(item => item.id === productId) || null;
        },

        /**
         * Format price with Naira symbol
         * @param {number} price
         * @returns {string}
         */
        formatPrice: function(price) {
            return '\u20A6' + parseFloat(price).toLocaleString();
        },

        /**
         * Show notification toast
         * @param {string} message
         */
        showNotification: function(message) {
            const existing = document.querySelector('.shoobu-toast');
            if (existing) {
                existing.remove();
            }

            const toast = document.createElement('div');
            toast.className = 'shoobu-toast';
            toast.innerHTML = `
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span>${message}</span>
            `;

            document.body.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.add('show');
            });

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 2500);
        }
    };

    const style = document.createElement('style');
    style.textContent = `
        .shoobu-toast {
            position: fixed;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: #1f2937;
            color: #fff;
            padding: 12px 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 9999;
        }
        .shoobu-toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }
        .shoobu-toast svg {
            color: #10b981;
            flex-shrink: 0;
        }
        @media (min-width: 768px) {
            .shoobu-toast {
                bottom: 30px;
            }
        }
    `;
    document.head.appendChild(style);
})();
