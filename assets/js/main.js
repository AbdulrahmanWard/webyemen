/**
 * Main JavaScript for Dammam Insulation & Renovation
 * Handles core functionality, navigation, and interactions
 */

(function() {
    'use strict';

    // ===== CONFIGURATION =====
    const CONFIG = {
        breakpoints: {
            sm: 640,
            md: 768,
            lg: 1024,
            xl: 1280
        },
        animations: {
            duration: 300,
            easing: 'cubic-bezier(0.4, 0, 0.2, 1)'
        },
        scroll: {
            offset: 80,
            behavior: 'smooth'
        }
    };

    // ===== UTILITY FUNCTIONS =====
    const utils = {
        // Get element by selector
        $(selector) {
            return document.querySelector(selector);
        },

        // Get elements by selector
        $$(selector) {
            return document.querySelectorAll(selector);
        },

        // Check if element exists
        exists(selector) {
            return document.querySelector(selector) !== null;
        },

        // Debounce function
        debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        },

        // Throttle function
        throttle(func, limit) {
            let inThrottle;
            return function() {
                const args = arguments;
                const context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            };
        },

        // Get viewport dimensions
        getViewport() {
            return {
                width: window.innerWidth,
                height: window.innerHeight
            };
        },

        // Check if device is mobile
        isMobile() {
            return window.innerWidth < CONFIG.breakpoints.md;
        },

        // Smooth scroll to element
        scrollTo(target, offset = CONFIG.scroll.offset) {
            const element = typeof target === 'string' ? this.$(target) : target;
            if (!element) return;

            const elementPosition = element.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - offset;

            window.scrollTo({
                top: offsetPosition,
                behavior: CONFIG.scroll.behavior
            });
        },

        // Add class with animation
        addClass(element, className, duration = CONFIG.animations.duration) {
            element.classList.add(className);
            return new Promise(resolve => {
                setTimeout(resolve, duration);
            });
        },

        // Remove class with animation
        removeClass(element, className, duration = CONFIG.animations.duration) {
            element.classList.remove(className);
            return new Promise(resolve => {
                setTimeout(resolve, duration);
            });
        },

        // Toggle class
        toggleClass(element, className) {
            element.classList.toggle(className);
        },

        // Get scroll position
        getScrollPosition() {
            return window.pageYOffset || document.documentElement.scrollTop;
        }
    };

    // ===== DARK MODE HANDLER =====
    const DarkMode = {
        init() {
            this.toggleBtn = utils.$('.dark-mode-toggle');
            this.currentTheme = this.getTheme();
            
            this.setTheme(this.currentTheme);
            this.bindEvents();
        },

        getTheme() {
            const saved = localStorage.getItem('theme');
            if (saved) return saved;
            
            return window.matchMedia('(prefers-color-scheme: dark)').matches 
                ? 'dark' 
                : 'light';
        },

        setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            this.currentTheme = theme;
            
            // Update meta theme-color
            const metaTheme = utils.$('meta[name="theme-color"]');
            if (metaTheme) {
                metaTheme.setAttribute('content', 
                    theme === 'dark' ? '#1f2937' : '#ffffff'
                );
            }
        },

        toggle() {
            const newTheme = this.currentTheme === 'light' ? 'dark' : 'light';
            this.setTheme(newTheme);
            
            // Animate toggle button
            if (this.toggleBtn) {
                this.toggleBtn.style.transform = 'translateY(-50%) scale(0.8)';
                setTimeout(() => {
                    this.toggleBtn.style.transform = 'translateY(-50%) scale(1)';
                }, 150);
            }
        },

        bindEvents() {
            if (this.toggleBtn) {
                this.toggleBtn.addEventListener('click', () => this.toggle());
            }

            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)')
                .addEventListener('change', (e) => {
                    if (!localStorage.getItem('theme')) {
                        this.setTheme(e.matches ? 'dark' : 'light');
                    }
                });
        }
    };

    // ===== NAVIGATION HANDLER =====
    const Navigation = {
        init() {
            this.header = utils.$('.main-header');
            this.nav = utils.$('.main-nav');
            this.mobileToggle = utils.$('.mobile-menu-toggle');
            this.navMenu = utils.$('.nav-menu');
            this.dropdowns = utils.$$('.has-dropdown');
            
            this.bindEvents();
            this.handleScroll();
        },

        bindEvents() {
            // Mobile menu toggle
            if (this.mobileToggle) {
                this.mobileToggle.addEventListener('click', () => this.toggleMobileMenu());
            }

            // Dropdown hover effects
            this.dropdowns.forEach(dropdown => {
                const menu = dropdown.querySelector('.dropdown-menu');
                
                dropdown.addEventListener('mouseenter', () => {
                    this.showDropdown(menu);
                });
                
                dropdown.addEventListener('mouseleave', () => {
                    this.hideDropdown(menu);
                });
            });

            // Scroll handler
            window.addEventListener('scroll', 
                utils.throttle(() => this.handleScroll(), 100)
            );

            // Handle nav link clicks
            utils.$$('.nav-link[href^="#"]').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = link.getAttribute('href');
                    utils.scrollTo(target);
                });
            });

            // Close mobile menu on outside click
            document.addEventListener('click', (e) => {
                if (!this.nav.contains(e.target) && this.navMenu.classList.contains('mobile-open')) {
                    this.closeMobileMenu();
                }
            });

            // Handle keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.navMenu.classList.contains('mobile-open')) {
                    this.closeMobileMenu();
                }
            });
        },

        toggleMobileMenu() {
            const isOpen = this.navMenu.classList.contains('mobile-open');
            
            if (isOpen) {
                this.closeMobileMenu();
            } else {
                this.openMobileMenu();
            }
        },

        openMobileMenu() {
            this.navMenu.classList.add('mobile-open');
            this.mobileToggle.setAttribute('aria-expanded', 'true');
            this.animateHamburger(true);
            document.body.style.overflow = 'hidden';
        },

        closeMobileMenu() {
            this.navMenu.classList.remove('mobile-open');
            this.mobileToggle.setAttribute('aria-expanded', 'false');
            this.animateHamburger(false);
            document.body.style.overflow = '';
        },

        animateHamburger(isOpen) {
            const lines = this.mobileToggle.querySelectorAll('.hamburger-line');
            
            if (isOpen) {
                lines[0].style.transform = 'rotate(45deg) translate(6px, 6px)';
                lines[1].style.opacity = '0';
                lines[2].style.transform = 'rotate(-45deg) translate(6px, -6px)';
            } else {
                lines[0].style.transform = '';
                lines[1].style.opacity = '';
                lines[2].style.transform = '';
            }
        },

        showDropdown(menu) {
            if (menu) {
                menu.style.display = 'block';
                requestAnimationFrame(() => {
                    menu.style.opacity = '1';
                    menu.style.visibility = 'visible';
                    menu.style.transform = 'translateY(0)';
                });
            }
        },

        hideDropdown(menu) {
            if (menu) {
                menu.style.opacity = '0';
                menu.style.visibility = 'hidden';
                menu.style.transform = 'translateY(-10px)';
                
                setTimeout(() => {
                    if (menu.style.opacity === '0') {
                        menu.style.display = 'none';
                    }
                }, CONFIG.animations.duration);
            }
        },

        handleScroll() {
            const scrollTop = utils.getScrollPosition();
            
            // Add/remove scrolled class
            if (scrollTop > 50) {
                this.header.classList.add('scrolled');
            } else {
                this.header.classList.remove('scrolled');
            }

            // Update active nav link
            this.updateActiveNavLink();
        },

        updateActiveNavLink() {
            const sections = utils.$$('section[id]');
            const scrollPos = utils.getScrollPosition() + CONFIG.scroll.offset;

            sections.forEach(section => {
                const top = section.offsetTop;
                const bottom = top + section.offsetHeight;
                const id = section.getAttribute('id');
                const navLink = utils.$(`.nav-link[href="#${id}"]`);

                if (scrollPos >= top && scrollPos < bottom) {
                    // Remove active class from all nav links
                    utils.$$('.nav-link.active').forEach(link => {
                        link.classList.remove('active');
                    });
                    
                    // Add active class to current nav link
                    if (navLink) {
                        navLink.classList.add('active');
                    }
                }
            });
        }
    };

    // ===== LOADING HANDLER =====
    const Loading = {
        init() {
            this.overlay = utils.$('#loading-overlay');
            this.hideOnLoad();
        },

        show() {
            if (this.overlay) {
                this.overlay.classList.add('active');
                this.overlay.setAttribute('aria-hidden', 'false');
            }
        },

        hide() {
            if (this.overlay) {
                this.overlay.classList.remove('active');
                this.overlay.setAttribute('aria-hidden', 'true');
            }
        },

        hideOnLoad() {
            if (document.readyState === 'loading') {
                this.show();
                window.addEventListener('load', () => {
                    setTimeout(() => this.hide(), 500);
                });
            }
        }
    };

    // ===== BACK TO TOP HANDLER =====
    const BackToTop = {
        init() {
            this.button = utils.$('#back-to-top');
            this.bindEvents();
        },

        bindEvents() {
            if (this.button) {
                this.button.addEventListener('click', () => this.scrollToTop());
                
                window.addEventListener('scroll', 
                    utils.throttle(() => this.handleScroll(), 100)
                );
            }
        },

        handleScroll() {
            const scrollTop = utils.getScrollPosition();
            
            if (scrollTop > 300) {
                this.show();
            } else {
                this.hide();
            }
        },

        show() {
            if (this.button) {
                this.button.style.opacity = '1';
                this.button.style.visibility = 'visible';
                this.button.style.transform = 'translateY(0)';
            }
        },

        hide() {
            if (this.button) {
                this.button.style.opacity = '0';
                this.button.style.visibility = 'hidden';
                this.button.style.transform = 'translateY(20px)';
            }
        },

        scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: CONFIG.scroll.behavior
            });
        }
    };

    // ===== LAZY LOADING HANDLER =====
    const LazyLoad = {
        init() {
            this.images = utils.$$('img[data-src]');
            this.observer = null;
            this.setupObserver();
        },

        setupObserver() {
            if ('IntersectionObserver' in window) {
                this.observer = new IntersectionObserver(
                    (entries) => this.handleIntersection(entries),
                    {
                        rootMargin: '50px 0px',
                        threshold: 0.01
                    }
                );

                this.images.forEach(img => this.observer.observe(img));
            } else {
                // Fallback for older browsers
                this.loadAllImages();
            }
        },

        handleIntersection(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.loadImage(entry.target);
                    this.observer.unobserve(entry.target);
                }
            });
        },

        loadImage(img) {
            const src = img.getAttribute('data-src');
            if (src) {
                img.src = src;
                img.classList.add('loaded');
                img.removeAttribute('data-src');
            }
        },

        loadAllImages() {
            this.images.forEach(img => this.loadImage(img));
        }
    };

    // ===== SCROLL ANIMATIONS =====
    const ScrollAnimations = {
        init() {
            this.elements = utils.$$('[data-animate]');
            this.observer = null;
            this.setupObserver();
        },

        setupObserver() {
            if ('IntersectionObserver' in window) {
                this.observer = new IntersectionObserver(
                    (entries) => this.handleIntersection(entries),
                    {
                        rootMargin: '-10% 0px',
                        threshold: 0.1
                    }
                );

                this.elements.forEach(el => this.observer.observe(el));
            }
        },

        handleIntersection(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateElement(entry.target);
                    this.observer.unobserve(entry.target);
                }
            });
        },

        animateElement(element) {
            const animation = element.getAttribute('data-animate');
            const delay = element.getAttribute('data-animate-delay') || 0;
            
            setTimeout(() => {
                element.classList.add(`animate-${animation}`);
            }, parseInt(delay));
        }
    };

    // ===== PERFORMANCE OPTIMIZATION =====
    const Performance = {
        init() {
            this.optimizeImages();
            this.prefetchLinks();
            this.enableServiceWorker();
        },

        optimizeImages() {
            // Add loading="lazy" to images that don't have it
            utils.$$('img:not([loading])').forEach(img => {
                img.setAttribute('loading', 'lazy');
            });
        },

        prefetchLinks() {
            // Prefetch important pages on hover
            utils.$$('a[href^="/"], a[href^="./"]').forEach(link => {
                link.addEventListener('mouseenter', () => {
                    this.prefetch(link.href);
                }, { once: true });
            });
        },

        prefetch(url) {
            const link = document.createElement('link');
            link.rel = 'prefetch';
            link.href = url;
            document.head.appendChild(link);
        },

        enableServiceWorker() {
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/sw.js')
                    .catch(() => {
                        // Service worker registration failed - ignore silently
                    });
            }
        }
    };

    // ===== ACCESSIBILITY ENHANCEMENTS =====
    const Accessibility = {
        init() {
            this.handleKeyboardNavigation();
            this.improveScreenReader();
            this.handleReducedMotion();
        },

        handleKeyboardNavigation() {
            // Skip links
            const skipLink = utils.$('.skip-link');
            if (skipLink) {
                skipLink.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = skipLink.getAttribute('href');
                    utils.scrollTo(target);
                    utils.$(target).focus();
                });
            }

            // Trap focus in modals
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Tab') {
                    this.handleTabNavigation(e);
                }
            });
        },

        handleTabNavigation(e) {
            const activeModal = utils.$('.modal.active');
            if (activeModal) {
                this.trapFocus(e, activeModal);
            }
        },

        trapFocus(e, container) {
            const focusableElements = container.querySelectorAll(
                'a[href], button, textarea, input, select, [tabindex]:not([tabindex="-1"])'
            );
            
            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];

            if (e.shiftKey && document.activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            } else if (!e.shiftKey && document.activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        },

        improveScreenReader() {
            // Add aria-labels where missing
            utils.$$('button:not([aria-label]):not([aria-labelledby])').forEach(btn => {
                const text = btn.textContent.trim();
                if (text) {
                    btn.setAttribute('aria-label', text);
                }
            });

            // Announce dynamic content changes
            this.createAriaLiveRegion();
        },

        createAriaLiveRegion() {
            const liveRegion = document.createElement('div');
            liveRegion.setAttribute('aria-live', 'polite');
            liveRegion.setAttribute('aria-atomic', 'true');
            liveRegion.className = 'sr-only';
            liveRegion.id = 'aria-live-region';
            document.body.appendChild(liveRegion);

            // Expose globally for other scripts to use
            window.announceToScreenReader = (message) => {
                liveRegion.textContent = message;
                setTimeout(() => {
                    liveRegion.textContent = '';
                }, 1000);
            };
        },

        handleReducedMotion() {
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
            
            if (prefersReducedMotion.matches) {
                document.documentElement.classList.add('reduce-motion');
            }

            prefersReducedMotion.addEventListener('change', (e) => {
                if (e.matches) {
                    document.documentElement.classList.add('reduce-motion');
                } else {
                    document.documentElement.classList.remove('reduce-motion');
                }
            });
        }
    };

    // ===== ERROR HANDLING =====
    const ErrorHandler = {
        init() {
            window.addEventListener('error', (e) => this.handleError(e));
            window.addEventListener('unhandledrejection', (e) => this.handleRejection(e));
        },

        handleError(error) {
            console.error('Script error:', error);
            // Optionally send to error reporting service
        },

        handleRejection(event) {
            console.error('Unhandled promise rejection:', event.reason);
            // Optionally send to error reporting service
        }
    };

    // ===== INITIALIZATION =====
    const App = {
        init() {
            // Wait for DOM to be ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => this.initializeModules());
            } else {
                this.initializeModules();
            }
        },

        initializeModules() {
            try {
                // Initialize core modules
                DarkMode.init();
                Navigation.init();
                Loading.init();
                BackToTop.init();
                LazyLoad.init();
                ScrollAnimations.init();
                Performance.init();
                Accessibility.init();
                ErrorHandler.init();

                // Mark app as initialized
                document.documentElement.classList.add('app-initialized');
                
                console.log('🚀 Dammam Insulation & Renovation website initialized successfully!');
            } catch (error) {
                console.error('❌ Error initializing app:', error);
            }
        }
    };

    // ===== EXPOSE UTILITIES =====
    window.DamamamApp = {
        utils,
        DarkMode,
        Navigation,
        Loading,
        BackToTop,
        LazyLoad,
        ScrollAnimations,
        Performance,
        Accessibility
    };

    // Start the application
    App.init();

})();