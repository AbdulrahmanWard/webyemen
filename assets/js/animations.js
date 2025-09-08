/**
 * Advanced Animations for Dammam Insulation & Renovation
 * Handles complex animations, transitions, and visual effects
 */

(function() {
    'use strict';

    // ===== ANIMATION UTILITIES =====
    const AnimationUtils = {
        // CSS Animation detection
        supportsCSS3D: (() => {
            const el = document.createElement('div');
            return 'perspective' in el.style ||
                   'WebkitPerspective' in el.style ||
                   'MozPerspective' in el.style;
        })(),

        // Request Animation Frame polyfill
        requestFrame: window.requestAnimationFrame ||
                     window.webkitRequestAnimationFrame ||
                     window.mozRequestAnimationFrame ||
                     ((callback) => setTimeout(callback, 1000 / 60)),

        // Get element's position relative to viewport
        getElementPosition(element) {
            const rect = element.getBoundingClientRect();
            return {
                top: rect.top + window.pageYOffset,
                left: rect.left + window.pageXOffset,
                width: rect.width,
                height: rect.height
            };
        },

        // Check if element is in viewport
        isInViewport(element, threshold = 0.1) {
            const rect = element.getBoundingClientRect();
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;
            const windowWidth = window.innerWidth || document.documentElement.clientWidth;
            
            return (
                rect.top < windowHeight * (1 + threshold) &&
                rect.bottom > windowHeight * threshold * -1 &&
                rect.left < windowWidth * (1 + threshold) &&
                rect.right > windowWidth * threshold * -1
            );
        },

        // Easing functions
        easing: {
            easeInQuart: t => t * t * t * t,
            easeOutQuart: t => 1 - (--t) * t * t * t,
            easeInOutQuart: t => t < 0.5 ? 8 * t * t * t * t : 1 - 8 * (--t) * t * t * t,
            easeInCubic: t => t * t * t,
            easeOutCubic: t => (--t) * t * t + 1,
            easeInOutCubic: t => t < 0.5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1,
            easeInBack: t => t * t * (2.7 * t - 1.7),
            easeOutBack: t => 1 + (--t) * t * (2.7 * t + 1.7),
            easeInElastic: t => t === 0 ? 0 : t === 1 ? 1 : -Math.pow(2, 10 * (t - 1)) * Math.sin((t - 1.1) * 5 * Math.PI),
            easeOutElastic: t => t === 0 ? 0 : t === 1 ? 1 : Math.pow(2, -10 * t) * Math.sin((t - 0.1) * 5 * Math.PI) + 1
        },

        // Animate property
        animate(element, properties, duration = 600, easing = 'easeOutQuart', callback = null) {
            const start = performance.now();
            const startValues = {};
            const endValues = {};

            // Parse starting and ending values
            Object.keys(properties).forEach(prop => {
                const currentValue = this.getComputedValue(element, prop);
                startValues[prop] = currentValue;
                endValues[prop] = properties[prop];
            });

            const easingFunc = this.easing[easing] || this.easing.easeOutQuart;

            const tick = (now) => {
                const elapsed = now - start;
                const progress = Math.min(elapsed / duration, 1);
                const easedProgress = easingFunc(progress);

                // Apply animated values
                Object.keys(properties).forEach(prop => {
                    const startVal = startValues[prop];
                    const endVal = endValues[prop];
                    const currentVal = startVal + (endVal - startVal) * easedProgress;
                    this.setProperty(element, prop, currentVal);
                });

                if (progress < 1) {
                    this.requestFrame(tick);
                } else if (callback) {
                    callback();
                }
            };

            this.requestFrame(tick);
        },

        // Get computed value for animation
        getComputedValue(element, property) {
            const computed = window.getComputedStyle(element);
            let value = computed.getPropertyValue(property);
            
            // Parse numeric values
            if (property === 'opacity') {
                return parseFloat(value) || 0;
            }
            
            return parseFloat(value.replace('px', '')) || 0;
        },

        // Set property for animation
        setProperty(element, property, value) {
            if (property === 'opacity') {
                element.style.opacity = value;
            } else if (property === 'scale') {
                element.style.transform = `scale(${value})`;
            } else if (property === 'translateY') {
                element.style.transform = `translateY(${value}px)`;
            } else if (property === 'translateX') {
                element.style.transform = `translateX(${value}px)`;
            } else {
                element.style[property] = `${value}px`;
            }
        }
    };

    // ===== SCROLL ANIMATIONS =====
    const ScrollAnimations = {
        elements: [],
        observer: null,

        init() {
            this.setupElements();
            this.createObserver();
            this.bindEvents();
        },

        setupElements() {
            // Find all elements with animation attributes
            document.querySelectorAll('[data-animate]').forEach((el, index) => {
                const animation = el.getAttribute('data-animate');
                const delay = parseInt(el.getAttribute('data-animate-delay')) || 0;
                const duration = parseInt(el.getAttribute('data-animate-duration')) || 600;
                const offset = parseInt(el.getAttribute('data-animate-offset')) || 0.1;
                
                this.elements.push({
                    element: el,
                    animation: animation,
                    delay: delay,
                    duration: duration,
                    offset: offset,
                    animated: false,
                    index: index
                });

                // Add initial state
                this.setInitialState(el, animation);
            });
        },

        setInitialState(element, animation) {
            element.style.opacity = '0';
            
            switch (animation) {
                case 'fade-up':
                    element.style.transform = 'translateY(50px)';
                    break;
                case 'fade-down':
                    element.style.transform = 'translateY(-50px)';
                    break;
                case 'fade-left':
                    element.style.transform = 'translateX(50px)';
                    break;
                case 'fade-right':
                    element.style.transform = 'translateX(-50px)';
                    break;
                case 'scale-up':
                    element.style.transform = 'scale(0.8)';
                    break;
                case 'scale-down':
                    element.style.transform = 'scale(1.2)';
                    break;
                case 'rotate-in':
                    element.style.transform = 'rotate(-180deg) scale(0.8)';
                    break;
                default:
                    element.style.transform = 'translateY(30px)';
            }
        },

        createObserver() {
            if (!('IntersectionObserver' in window)) {
                this.fallbackAnimation();
                return;
            }

            this.observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const elementData = this.elements.find(el => el.element === entry.target);
                    
                    if (entry.isIntersecting && elementData && !elementData.animated) {
                        this.animateElement(elementData);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '50px'
            });

            // Observe all elements
            this.elements.forEach(data => {
                this.observer.observe(data.element);
            });
        },

        animateElement(data) {
            data.animated = true;
            
            setTimeout(() => {
                this.playAnimation(data.element, data.animation, data.duration);
            }, data.delay);
        },

        playAnimation(element, animation, duration) {
            element.style.transition = `all ${duration}ms cubic-bezier(0.4, 0, 0.2, 1)`;
            element.style.opacity = '1';
            
            switch (animation) {
                case 'fade-up':
                case 'fade-down':
                case 'fade-left':
                case 'fade-right':
                    element.style.transform = 'translateY(0) translateX(0)';
                    break;
                case 'scale-up':
                case 'scale-down':
                    element.style.transform = 'scale(1)';
                    break;
                case 'rotate-in':
                    element.style.transform = 'rotate(0deg) scale(1)';
                    break;
                default:
                    element.style.transform = 'translateY(0)';
            }
        },

        fallbackAnimation() {
            // For browsers without IntersectionObserver
            const animateOnScroll = () => {
                this.elements.forEach(data => {
                    if (!data.animated && AnimationUtils.isInViewport(data.element, data.offset)) {
                        this.animateElement(data);
                    }
                });
            };

            window.addEventListener('scroll', this.throttle(animateOnScroll, 100));
            animateOnScroll(); // Initial check
        },

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

        bindEvents() {
            // Re-animate on window resize
            window.addEventListener('resize', () => {
                this.elements.forEach(data => {
                    if (!data.animated && AnimationUtils.isInViewport(data.element)) {
                        this.animateElement(data);
                    }
                });
            });
        }
    };

    // ===== PARALLAX SCROLLING =====
    const ParallaxScroll = {
        elements: [],
        isScrolling: false,

        init() {
            this.findElements();
            this.bindEvents();
        },

        findElements() {
            document.querySelectorAll('[data-parallax]').forEach(el => {
                const speed = parseFloat(el.getAttribute('data-parallax')) || 0.5;
                const direction = el.getAttribute('data-parallax-direction') || 'vertical';
                
                this.elements.push({
                    element: el,
                    speed: speed,
                    direction: direction,
                    originalPosition: AnimationUtils.getElementPosition(el)
                });
            });
        },

        bindEvents() {
            if (this.elements.length === 0) return;

            window.addEventListener('scroll', () => {
                if (!this.isScrolling) {
                    this.isScrolling = true;
                    AnimationUtils.requestFrame(() => this.updateParallax());
                }
            });
        },

        updateParallax() {
            const scrollTop = window.pageYOffset;
            
            this.elements.forEach(data => {
                const elementTop = data.originalPosition.top;
                const elementHeight = data.originalPosition.height;
                const windowHeight = window.innerHeight;
                
                // Check if element is in viewport
                if (scrollTop + windowHeight > elementTop && scrollTop < elementTop + elementHeight) {
                    const progress = (scrollTop + windowHeight - elementTop) / (windowHeight + elementHeight);
                    const offset = (progress - 0.5) * data.speed * 100;
                    
                    if (data.direction === 'vertical') {
                        data.element.style.transform = `translateY(${offset}px)`;
                    } else {
                        data.element.style.transform = `translateX(${offset}px)`;
                    }
                }
            });
            
            this.isScrolling = false;
        }
    };

    // ===== HOVER ANIMATIONS =====
    const HoverAnimations = {
        init() {
            this.setupCardHovers();
            this.setupButtonHovers();
            this.setupImageHovers();
            this.setupLinkHovers();
        },

        setupCardHovers() {
            document.querySelectorAll('.card, .service-card, .project-card').forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-8px) scale(1.02)';
                    card.style.boxShadow = '0 25px 50px rgba(0,0,0,0.15)';
                });

                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0) scale(1)';
                    card.style.boxShadow = '';
                });
            });
        },

        setupButtonHovers() {
            document.querySelectorAll('.btn, .cta-button').forEach(button => {
                let ripple;

                button.addEventListener('mousedown', (e) => {
                    ripple = this.createRipple(e, button);
                });

                button.addEventListener('mouseup', () => {
                    if (ripple) {
                        setTimeout(() => ripple.remove(), 600);
                    }
                });

                button.addEventListener('mouseleave', () => {
                    if (ripple) {
                        ripple.remove();
                    }
                });
            });
        },

        createRipple(e, button) {
            const rect = button.getBoundingClientRect();
            const ripple = document.createElement('span');
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                transform: scale(0);
                animation: ripple 0.6s linear;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                pointer-events: none;
            `;

            // Add ripple keyframes if not exists
            if (!document.querySelector('#ripple-styles')) {
                const style = document.createElement('style');
                style.id = 'ripple-styles';
                style.textContent = `
                    @keyframes ripple {
                        to {
                            transform: scale(2);
                            opacity: 0;
                        }
                    }
                `;
                document.head.appendChild(style);
            }

            if (getComputedStyle(button).position === 'static') {
                button.style.position = 'relative';
            }

            button.appendChild(ripple);
            return ripple;
        },

        setupImageHovers() {
            document.querySelectorAll('.hover-zoom img, .project-image img').forEach(img => {
                const container = img.parentElement;
                
                container.addEventListener('mouseenter', () => {
                    img.style.transform = 'scale(1.1)';
                    img.style.transition = 'transform 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                });

                container.addEventListener('mouseleave', () => {
                    img.style.transform = 'scale(1)';
                });
            });
        },

        setupLinkHovers() {
            document.querySelectorAll('a:not(.btn):not(.card)').forEach(link => {
                if (link.textContent.trim()) {
                    link.addEventListener('mouseenter', () => {
                        link.style.color = 'var(--primary-blue)';
                        link.style.textDecoration = 'underline';
                        link.style.textDecorationColor = 'var(--secondary-orange)';
                        link.style.textUnderlineOffset = '4px';
                        link.style.textDecorationThickness = '2px';
                        link.style.transition = 'all 0.3s ease';
                    });

                    link.addEventListener('mouseleave', () => {
                        link.style.color = '';
                        link.style.textDecoration = '';
                    });
                }
            });
        }
    };

    // ===== LOADING ANIMATIONS =====
    const LoadingAnimations = {
        init() {
            this.createLoadingSpinner();
            this.setupProgressBars();
        },

        createLoadingSpinner() {
            const style = document.createElement('style');
            style.textContent = `
                .loading-dots {
                    display: inline-block;
                }
                .loading-dots span {
                    display: inline-block;
                    width: 8px;
                    height: 8px;
                    border-radius: 50%;
                    background: currentColor;
                    margin: 0 2px;
                    animation: loading-bounce 1.4s ease-in-out infinite both;
                }
                .loading-dots span:nth-child(1) { animation-delay: -0.32s; }
                .loading-dots span:nth-child(2) { animation-delay: -0.16s; }

                @keyframes loading-bounce {
                    0%, 80%, 100% {
                        transform: scale(0);
                        opacity: 0.5;
                    }
                    40% {
                        transform: scale(1);
                        opacity: 1;
                    }
                }

                .loading-pulse {
                    animation: loading-pulse 2s ease-in-out infinite;
                }

                @keyframes loading-pulse {
                    0%, 100% {
                        opacity: 0.4;
                        transform: scale(0.95);
                    }
                    50% {
                        opacity: 1;
                        transform: scale(1);
                    }
                }
            `;
            document.head.appendChild(style);
        },

        setupProgressBars() {
            document.querySelectorAll('.progress-bar').forEach(bar => {
                const progress = bar.getAttribute('data-progress') || 0;
                const fill = bar.querySelector('.progress-fill');
                
                if (fill) {
                    // Animate progress bar when in view
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                this.animateProgressBar(fill, progress);
                                observer.unobserve(entry.target);
                            }
                        });
                    });
                    
                    observer.observe(bar);
                }
            });
        },

        animateProgressBar(fill, targetProgress) {
            let currentProgress = 0;
            const increment = targetProgress / 50;
            const duration = 2000; // 2 seconds
            const stepTime = duration / 50;

            const animate = () => {
                if (currentProgress < targetProgress) {
                    currentProgress += increment;
                    fill.style.width = `${Math.min(currentProgress, targetProgress)}%`;
                    setTimeout(animate, stepTime);
                } else {
                    fill.style.width = `${targetProgress}%`;
                }
            };

            animate();
        }
    };

    // ===== MORPHING ANIMATIONS =====
    const MorphingAnimations = {
        init() {
            this.setupMorphingButtons();
            this.setupShapeAnimations();
        },

        setupMorphingButtons() {
            document.querySelectorAll('.morph-button').forEach(button => {
                const originalText = button.textContent;
                const hoverText = button.getAttribute('data-hover-text') || originalText;

                button.addEventListener('mouseenter', () => {
                    this.morphText(button, originalText, hoverText);
                });

                button.addEventListener('mouseleave', () => {
                    this.morphText(button, hoverText, originalText);
                });
            });
        },

        morphText(element, fromText, toText) {
            const chars = Math.max(fromText.length, toText.length);
            let currentIndex = 0;

            const morph = () => {
                if (currentIndex <= chars) {
                    const newText = toText.substring(0, currentIndex) + 
                                   fromText.substring(currentIndex);
                    element.textContent = newText;
                    currentIndex++;
                    setTimeout(morph, 50);
                } else {
                    element.textContent = toText;
                }
            };

            morph();
        },

        setupShapeAnimations() {
            // Animate SVG shapes
            document.querySelectorAll('.animated-shape').forEach(shape => {
                const paths = shape.querySelectorAll('path');
                
                shape.addEventListener('mouseenter', () => {
                    paths.forEach(path => {
                        path.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                        path.style.transform = 'scale(1.1)';
                        path.style.filter = 'drop-shadow(0 10px 20px rgba(0,0,0,0.1))';
                    });
                });

                shape.addEventListener('mouseleave', () => {
                    paths.forEach(path => {
                        path.style.transform = 'scale(1)';
                        path.style.filter = 'none';
                    });
                });
            });
        }
    };

    // ===== ANIMATION CONTROLLER =====
    const AnimationController = {
        init() {
            // Check for reduced motion preference
            this.respectMotionPreference();
            
            // Initialize all animation modules
            ScrollAnimations.init();
            ParallaxScroll.init();
            HoverAnimations.init();
            LoadingAnimations.init();
            MorphingAnimations.init();
            
            // Setup performance monitoring
            this.monitorPerformance();
            
            console.log('🎨 Advanced animations initialized');
        },

        respectMotionPreference() {
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
            
            if (prefersReducedMotion.matches) {
                document.documentElement.classList.add('reduce-motion');
                this.disableAnimations();
            }

            prefersReducedMotion.addEventListener('change', (e) => {
                if (e.matches) {
                    document.documentElement.classList.add('reduce-motion');
                    this.disableAnimations();
                } else {
                    document.documentElement.classList.remove('reduce-motion');
                    this.enableAnimations();
                }
            });
        },

        disableAnimations() {
            // Disable all non-essential animations
            const style = document.createElement('style');
            style.id = 'reduce-motion-styles';
            style.textContent = `
                .reduce-motion *,
                .reduce-motion *::before,
                .reduce-motion *::after {
                    animation-duration: 0.01ms !important;
                    animation-iteration-count: 1 !important;
                    transition-duration: 0.01ms !important;
                    scroll-behavior: auto !important;
                }
            `;
            document.head.appendChild(style);
        },

        enableAnimations() {
            const style = document.querySelector('#reduce-motion-styles');
            if (style) {
                style.remove();
            }
        },

        monitorPerformance() {
            // Monitor frame rate and disable heavy animations if needed
            let frames = 0;
            let lastTime = performance.now();
            
            const checkFrameRate = () => {
                frames++;
                const currentTime = performance.now();
                
                if (currentTime - lastTime >= 1000) {
                    const fps = Math.round((frames * 1000) / (currentTime - lastTime));
                    
                    if (fps < 30) {
                        console.warn('⚠️ Low frame rate detected. Reducing animations...');
                        this.reduceAnimations();
                    }
                    
                    frames = 0;
                    lastTime = currentTime;
                }
                
                requestAnimationFrame(checkFrameRate);
            };
            
            // Only monitor in development or when explicitly enabled
            if (localStorage.getItem('debug-performance')) {
                requestAnimationFrame(checkFrameRate);
            }
        },

        reduceAnimations() {
            document.documentElement.classList.add('reduced-animations');
            
            // Disable parallax and heavy animations
            ParallaxScroll.elements = [];
        }
    };

    // ===== EXPORT TO GLOBAL =====
    window.DamamamAnimations = {
        AnimationUtils,
        ScrollAnimations,
        ParallaxScroll,
        HoverAnimations,
        LoadingAnimations,
        MorphingAnimations,
        AnimationController
    };

    // Auto-initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => AnimationController.init());
    } else {
        AnimationController.init();
    }

})();