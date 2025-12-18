/**
 * Shoobu Theme - Main JavaScript
 *
 * @package Shoobu
 * @version 1.0.0
 */

(function() {
    'use strict';

    /**
     * Hero Slider
     */
    const HeroSlider = {
        currentSlide: 0,
        totalSlides: 0,
        autoPlayInterval: null,
        autoPlayDelay: 5000,
        touchStartX: 0,
        touchEndX: 0,

        init: function() {
            const slider = document.getElementById('hero-slider');
            if (!slider) return;

            const slides = slider.querySelectorAll('.hero-slide');
            this.totalSlides = slides.length;

            if (this.totalSlides <= 1) return;

            const prevBtn = slider.querySelector('.hero-nav-prev');
            const nextBtn = slider.querySelector('.hero-nav-next');

            if (prevBtn) {
                prevBtn.addEventListener('click', () => this.prevSlide());
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => this.nextSlide());
            }

            slider.addEventListener('touchstart', (e) => {
                this.touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            slider.addEventListener('touchend', (e) => {
                this.touchEndX = e.changedTouches[0].screenX;
                this.handleSwipe();
            }, { passive: true });

            this.startAutoPlay();

            slider.addEventListener('mouseenter', () => this.stopAutoPlay());
            slider.addEventListener('mouseleave', () => this.startAutoPlay());
        },

        goToSlide: function(index) {
            const slider = document.getElementById('hero-slider');
            if (!slider) return;

            const slides = slider.querySelectorAll('.hero-slide');

            if (index >= this.totalSlides) index = 0;
            if (index < 0) index = this.totalSlides - 1;

            slides.forEach((slide, i) => {
                slide.classList.remove('opacity-100');
                slide.classList.add('opacity-0');
                if (i === index) {
                    slide.classList.remove('opacity-0');
                    slide.classList.add('opacity-100');
                }
            });

            this.currentSlide = index;
        },

        nextSlide: function() {
            this.goToSlide(this.currentSlide + 1);
        },

        prevSlide: function() {
            this.goToSlide(this.currentSlide - 1);
        },

        handleSwipe: function() {
            const swipeThreshold = 50;
            const diff = this.touchStartX - this.touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    this.nextSlide();
                } else {
                    this.prevSlide();
                }
            }
        },

        startAutoPlay: function() {
            this.stopAutoPlay();
            this.autoPlayInterval = setInterval(() => this.nextSlide(), this.autoPlayDelay);
        },

        stopAutoPlay: function() {
            if (this.autoPlayInterval) {
                clearInterval(this.autoPlayInterval);
                this.autoPlayInterval = null;
            }
        }
    };

    /**
     * Mobile Search Toggle
     */
    const MobileSearch = {
        init: function() {
            const toggleBtn = document.getElementById('mobile-search-toggle');
            const dropdown = document.getElementById('mobile-search-dropdown');

            if (!toggleBtn || !dropdown) return;

            const searchIcon = toggleBtn.querySelector('.search-icon');
            const closeIcon = toggleBtn.querySelector('.close-icon');
            const searchInput = dropdown.querySelector('input[type="search"]');

            toggleBtn.addEventListener('click', () => {
                const isOpen = dropdown.style.maxHeight !== '0px' && dropdown.style.maxHeight !== '';

                if (isOpen) {
                    dropdown.style.maxHeight = '0px';
                    dropdown.style.opacity = '0';
                    if (searchIcon) searchIcon.classList.remove('hidden');
                    if (closeIcon) closeIcon.classList.add('hidden');
                } else {
                    dropdown.style.maxHeight = '80px';
                    dropdown.style.opacity = '1';
                    if (searchIcon) searchIcon.classList.add('hidden');
                    if (closeIcon) closeIcon.classList.remove('hidden');
                    if (searchInput) {
                        setTimeout(() => searchInput.focus(), 300);
                    }
                }
            });

            document.addEventListener('click', (e) => {
                if (!toggleBtn.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.maxHeight = '0px';
                    dropdown.style.opacity = '0';
                    if (searchIcon) searchIcon.classList.remove('hidden');
                    if (closeIcon) closeIcon.classList.add('hidden');
                }
            });
        }
    };

    /**
     * Cart Count Badge
     */
    const CartBadge = {
        init: function() {
            this.updateCount();
            window.addEventListener('storage', () => this.updateCount());
            window.addEventListener('cart-updated', () => this.updateCount());
        },

        updateCount: function() {
            const badges = document.querySelectorAll('#cart-count, .cart-count');
            const cart = JSON.parse(localStorage.getItem('sf_cart') || '[]');
            const count = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);

            badges.forEach(badge => {
                badge.textContent = count;
                if (count > 0) {
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            });
        }
    };

    /**
     * Smooth Scroll
     */
    const SmoothScroll = {
        init: function() {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href === '#' || href === '#main-content') return;

                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        }
    };

    /**
     * Add to Cart Button Handler
     */
    const AddToCartButtons = {
        init: function() {
            document.addEventListener('click', (e) => {
                const btn = e.target.closest('[data-add-to-cart]');
                if (!btn) return;

                e.preventDefault();

                const productId = btn.getAttribute('data-product-id');
                const productName = btn.getAttribute('data-product-name');
                const productPrice = parseFloat(btn.getAttribute('data-product-price'));
                const productImage = btn.getAttribute('data-product-image');

                if (!productId || !productName || isNaN(productPrice)) {
                    console.error('Missing product data');
                    return;
                }

                if (typeof ShoobuCart !== 'undefined') {
                    ShoobuCart.addToCart(productId, productName, productPrice, productImage, 1);
                } else {
                    const cart = JSON.parse(localStorage.getItem('sf_cart') || '[]');
                    const existingIndex = cart.findIndex(item => item.id === productId);

                    if (existingIndex > -1) {
                        cart[existingIndex].quantity++;
                    } else {
                        cart.push({
                            id: productId,
                            name: productName,
                            price: productPrice,
                            image: productImage,
                            quantity: 1
                        });
                    }

                    localStorage.setItem('sf_cart', JSON.stringify(cart));
                    window.dispatchEvent(new CustomEvent('cart-updated', {
                        detail: { cart: cart }
                    }));
                }

                const originalText = btn.innerHTML;
                btn.innerHTML = '<svg class="animate-spin" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" stroke-dasharray="32" stroke-dashoffset="8"/></svg> Added!';
                btn.disabled = true;

                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 1500);
            });
        }
    };

    /**
     * Lazy Loading Images
     */
    const LazyImages = {
        init: function() {
            if ('loading' in HTMLImageElement.prototype) {
                document.querySelectorAll('img[loading="lazy"]').forEach(img => {
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                    }
                });
            } else if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                            }
                            observer.unobserve(img);
                        }
                    });
                });

                document.querySelectorAll('img[data-src]').forEach(img => {
                    observer.observe(img);
                });
            }
        }
    };

    /**
     * Initialize all modules
     */
    function init() {
        HeroSlider.init();
        MobileSearch.init();
        CartBadge.init();
        SmoothScroll.init();
        AddToCartButtons.init();
        LazyImages.init();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
