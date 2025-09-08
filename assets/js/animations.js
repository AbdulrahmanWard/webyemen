/**
 * ملف JavaScript للحركات والتأثيرات - شركة الدمام للعوازل والترميم
 * Animations JavaScript - Al-Dammam Insulation & Renovation
 * Version: 1.0
 */

(function() {
    'use strict';

    // ===============================
    // إعدادات الحركات - Animation Settings
    // ===============================
    
    const animationSettings = {
        observerOptions: {
            root: null,
            rootMargin: '0px 0px -50px 0px',
            threshold: 0.1
        },
        defaultDuration: 800,
        defaultDelay: 0,
        easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)',
        staggerDelay: 100,
        prefersReducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches
    };

    // ===============================
    // أنواع الحركات - Animation Types
    // ===============================
    
    const animationTypes = {
        'fade-in': {
            initial: { opacity: 0 },
            animate: { opacity: 1 },
            duration: 600
        },
        
        'fade-out': {
            initial: { opacity: 1 },
            animate: { opacity: 0 },
            duration: 400
        },
        
        'slide-right': {
            initial: { 
                opacity: 0, 
                transform: 'translateX(-50px)' 
            },
            animate: { 
                opacity: 1, 
                transform: 'translateX(0)' 
            },
            duration: 700
        },
        
        'slide-left': {
            initial: { 
                opacity: 0, 
                transform: 'translateX(50px)' 
            },
            animate: { 
                opacity: 1, 
                transform: 'translateX(0)' 
            },
            duration: 700
        },
        
        'slide-up': {
            initial: { 
                opacity: 0, 
                transform: 'translateY(50px)' 
            },
            animate: { 
                opacity: 1, 
                transform: 'translateY(0)' 
            },
            duration: 600
        },
        
        'slide-down': {
            initial: { 
                opacity: 0, 
                transform: 'translateY(-30px)' 
            },
            animate: { 
                opacity: 1, 
                transform: 'translateY(0)' 
            },
            duration: 500
        },
        
        'scale-in': {
            initial: { 
                opacity: 0, 
                transform: 'scale(0.8)' 
            },
            animate: { 
                opacity: 1, 
                transform: 'scale(1)' 
            },
            duration: 600
        },
        
        'scale-out': {
            initial: { 
                opacity: 1, 
                transform: 'scale(1)' 
            },
            animate: { 
                opacity: 0, 
                transform: 'scale(1.2)' 
            },
            duration: 400
        },
        
        'rotate-in': {
            initial: { 
                opacity: 0, 
                transform: 'rotate(-10deg) scale(0.9)' 
            },
            animate: { 
                opacity: 1, 
                transform: 'rotate(0deg) scale(1)' 
            },
            duration: 800
        },
        
        'bounce': {
            animate: { 
                transform: 'translateY(-10px)' 
            },
            duration: 600,
            iterationCount: 'infinite',
            direction: 'alternate'
        },
        
        'pulse': {
            animate: { 
                transform: 'scale(1.05)' 
            },
            duration: 1000,
            iterationCount: 'infinite',
            direction: 'alternate'
        },
        
        'shake': {
            keyframes: [
                { transform: 'translateX(0)' },
                { transform: 'translateX(-10px)' },
                { transform: 'translateX(10px)' },
                { transform: 'translateX(-10px)' },
                { transform: 'translateX(10px)' },
                { transform: 'translateX(0)' }
            ],
            duration: 500
        },
        
        'flip': {
            initial: { 
                opacity: 0, 
                transform: 'rotateY(-90deg)' 
            },
            animate: { 
                opacity: 1, 
                transform: 'rotateY(0deg)' 
            },
            duration: 800
        }
    };

    // ===============================
    // فئة إدارة الحركات - Animation Manager
    // ===============================
    
    class AnimationManager {
        constructor() {
            this.observer = null;
            this.animatedElements = new Set();
            this.countUpElements = new Map();
            
            this.init();
        }

        init() {
            if (animationSettings.prefersReducedMotion) {
                console.log('Reduced motion preference detected, disabling animations');
                return;
            }

            this.setupIntersectionObserver();
            this.setupScrollAnimations();
            this.setupHoverAnimations();
            this.setupCountUpAnimations();
            this.setupParallaxEffects();
        }

        setupIntersectionObserver() {
            if (!('IntersectionObserver' in window)) {
                console.warn('IntersectionObserver not supported, falling back to immediate animations');
                this.fallbackToImmediateAnimations();
                return;
            }

            this.observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.animateElement(entry.target);
                    }
                });
            }, animationSettings.observerOptions);

            // Observe elements with animation attributes
            this.observeAnimationElements();
        }

        observeAnimationElements() {
            const elements = document.querySelectorAll('[data-animate]:not(.animated)');
            
            elements.forEach(element => {
                // Set initial styles immediately
                this.setInitialStyles(element);
                this.observer.observe(element);
            });
        }

        setInitialStyles(element) {
            const animationType = element.getAttribute('data-animate');
            const animation = animationTypes[animationType];
            
            if (!animation || !animation.initial) return;

            // Apply initial styles
            Object.entries(animation.initial).forEach(([property, value]) => {
                if (property === 'transform') {
                    element.style.transform = value;
                } else {
                    element.style[property] = value;
                }
            });
        }

        animateElement(element) {
            if (this.animatedElements.has(element)) return;

            const animationType = element.getAttribute('data-animate');
            const delay = parseInt(element.getAttribute('data-delay')) || animationSettings.defaultDelay;
            const duration = parseInt(element.getAttribute('data-duration')) || animationSettings.defaultDuration;
            
            setTimeout(() => {
                this.runAnimation(element, animationType, duration);
            }, delay);

            this.animatedElements.add(element);
            this.observer.unobserve(element);
        }

        runAnimation(element, animationType, duration) {
            const animation = animationTypes[animationType];
            if (!animation) {
                console.warn(`Animation type '${animationType}' not found`);
                return;
            }

            element.classList.add('animating');

            if (animation.keyframes) {
                // Use keyframes animation
                const keyframes = animation.keyframes;
                const options = {
                    duration: duration || animation.duration,
                    easing: animationSettings.easing,
                    fill: 'both'
                };

                element.animate(keyframes, options).addEventListener('finish', () => {
                    element.classList.remove('animating');
                    element.classList.add('animated');
                });
            } else {
                // Use CSS transitions
                element.style.transition = `all ${duration || animation.duration}ms ${animationSettings.easing}`;
                
                // Apply animation styles
                if (animation.animate) {
                    Object.entries(animation.animate).forEach(([property, value]) => {
                        if (property === 'transform') {
                            element.style.transform = value;
                        } else {
                            element.style[property] = value;
                        }
                    });
                }

                // Handle infinite animations
                if (animation.iterationCount === 'infinite') {
                    element.style.animation = `${animationType}-keyframes ${duration || animation.duration}ms ${animationSettings.easing} infinite ${animation.direction || 'normal'}`;
                }

                setTimeout(() => {
                    element.classList.remove('animating');
                    element.classList.add('animated');
                }, duration || animation.duration);
            }
        }

        setupScrollAnimations() {
            let ticking = false;

            const handleScroll = () => {
                if (!ticking) {
                    requestAnimationFrame(() => {
                        this.updateScrollAnimations();
                        ticking = false;
                    });
                    ticking = true;
                }
            };

            window.addEventListener('scroll', handleScroll, { passive: true });
        }

        updateScrollAnimations() {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;

            // Parallax backgrounds
            const parallaxElements = document.querySelectorAll('[data-parallax]');
            parallaxElements.forEach(element => {
                const speed = parseFloat(element.getAttribute('data-parallax')) || 0.5;
                const yPos = -(scrolled * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });

            // Header scroll effects
            const header = document.getElementById('mainHeader');
            if (header) {
                if (scrolled > 100) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            }

            // Progress bar
            const progressBar = document.querySelector('.reading-progress');
            if (progressBar) {
                const documentHeight = document.documentElement.scrollHeight - window.innerHeight;
                const progress = (scrolled / documentHeight) * 100;
                progressBar.style.width = `${progress}%`;
            }
        }

        setupHoverAnimations() {
            // Service cards hover effects
            const serviceCards = document.querySelectorAll('.service-card');
            serviceCards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-10px) scale(1.02)';
                    card.style.transition = 'all 0.3s ease';
                });

                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Button hover effects
            const buttons = document.querySelectorAll('.btn, .cta-button');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', () => {
                    this.addRippleEffect(button);
                });
            });
        }

        addRippleEffect(element) {
            const ripple = document.createElement('span');
            ripple.className = 'ripple-effect';
            
            const rect = element.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = (event.clientX - rect.left - size / 2) + 'px';
            ripple.style.top = (event.clientY - rect.top - size / 2) + 'px';
            
            element.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        }

        setupCountUpAnimations() {
            const countElements = document.querySelectorAll('[data-count]');
            
            countElements.forEach(element => {
                const targetValue = parseInt(element.getAttribute('data-count'));
                const duration = parseInt(element.getAttribute('data-count-duration')) || 2000;
                
                this.countUpElements.set(element, {
                    target: targetValue,
                    duration: duration,
                    hasAnimated: false
                });
            });
        }

        animateCountUp(element) {
            const config = this.countUpElements.get(element);
            if (!config || config.hasAnimated) return;

            config.hasAnimated = true;
            
            const startValue = 0;
            const targetValue = config.target;
            const duration = config.duration;
            const startTime = performance.now();

            const animate = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Easing function
                const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                const currentValue = Math.floor(startValue + (targetValue - startValue) * easeOutQuart);
                
                element.textContent = currentValue.toLocaleString('ar-SA');
                
                if (progress < 1) {
                    requestAnimationFrame(animate);
                } else {
                    element.textContent = targetValue.toLocaleString('ar-SA');
                }
            };

            requestAnimationFrame(animate);
        }

        setupParallaxEffects() {
            const parallaxElements = document.querySelectorAll('.parallax-element');
            
            parallaxElements.forEach(element => {
                const speed = parseFloat(element.getAttribute('data-speed')) || 0.5;
                const direction = element.getAttribute('data-direction') || 'up';
                
                this.observer.observe(element);
            });
        }

        // Stagger animations for groups
        staggerAnimation(elements, animationType, staggerDelay = animationSettings.staggerDelay) {
            elements.forEach((element, index) => {
                const delay = index * staggerDelay;
                element.setAttribute('data-animate', animationType);
                element.setAttribute('data-delay', delay);
                
                this.setInitialStyles(element);
                this.observer.observe(element);
            });
        }

        // Manual trigger animations
        triggerAnimation(element, animationType, duration) {
            if (typeof element === 'string') {
                element = document.querySelector(element);
            }
            
            if (!element) return;

            this.runAnimation(element, animationType, duration);
        }

        // Fallback for unsupported browsers
        fallbackToImmediateAnimations() {
            const elements = document.querySelectorAll('[data-animate]');
            elements.forEach(element => {
                element.classList.add('animated');
                
                // Trigger count up animations immediately
                if (element.hasAttribute('data-count')) {
                    setTimeout(() => {
                        this.animateCountUp(element);
                    }, 1000);
                }
            });
        }

        // Public methods
        refresh() {
            this.observeAnimationElements();
        }

        destroy() {
            if (this.observer) {
                this.observer.disconnect();
            }
            this.animatedElements.clear();
            this.countUpElements.clear();
        }
    }

    // ===============================
    // حركات خاصة - Special Animations
    // ===============================
    
    class SpecialEffects {
        static createFloatingElements() {
            const hero = document.querySelector('.hero-section');
            if (!hero) return;

            for (let i = 0; i < 20; i++) {
                const dot = document.createElement('div');
                dot.className = 'floating-dot';
                dot.style.left = Math.random() * 100 + '%';
                dot.style.animationDelay = Math.random() * 10 + 's';
                dot.style.animationDuration = (Math.random() * 10 + 10) + 's';
                hero.appendChild(dot);
            }
        }

        static createTextRevealAnimation() {
            const textElements = document.querySelectorAll('.text-reveal');
            
            textElements.forEach(element => {
                const text = element.textContent;
                element.innerHTML = '';
                
                [...text].forEach((char, index) => {
                    const span = document.createElement('span');
                    span.textContent = char === ' ' ? '\u00A0' : char;
                    span.style.animationDelay = `${index * 50}ms`;
                    span.className = 'char-reveal';
                    element.appendChild(span);
                });
            });
        }

        static createMouseFollower() {
            const follower = document.createElement('div');
            follower.className = 'mouse-follower';
            document.body.appendChild(follower);

            let mouseX = 0, mouseY = 0;
            let followerX = 0, followerY = 0;

            document.addEventListener('mousemove', (e) => {
                mouseX = e.clientX;
                mouseY = e.clientY;
            });

            const updateFollower = () => {
                followerX += (mouseX - followerX) * 0.1;
                followerY += (mouseY - followerY) * 0.1;

                follower.style.left = followerX + 'px';
                follower.style.top = followerY + 'px';

                requestAnimationFrame(updateFollower);
            };

            updateFollower();
        }
    }

    // ===============================
    // CSS الديناميكي - Dynamic CSS
    // ===============================
    
    function injectAnimationStyles() {
        const styles = `
            .char-reveal {
                display: inline-block;
                opacity: 0;
                animation: charReveal 0.6s ease forwards;
            }

            @keyframes charReveal {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
            }

            .floating-dot {
                position: absolute;
                width: 4px;
                height: 4px;
                background: rgba(59, 130, 246, 0.3);
                border-radius: 50%;
                animation: float linear infinite;
                pointer-events: none;
            }

            @keyframes float {
                from {
                    transform: translateY(100vh) rotate(0deg);
                    opacity: 0;
                }
                10% {
                    opacity: 1;
                }
                90% {
                    opacity: 1;
                }
                to {
                    transform: translateY(-100px) rotate(360deg);
                    opacity: 0;
                }
            }

            .ripple-effect {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                animation: ripple 0.6s linear;
                pointer-events: none;
            }

            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }

            .mouse-follower {
                position: fixed;
                width: 20px;
                height: 20px;
                border: 2px solid rgba(59, 130, 246, 0.5);
                border-radius: 50%;
                pointer-events: none;
                z-index: 9999;
                transition: transform 0.1s ease;
            }

            .reading-progress {
                position: fixed;
                top: 0;
                left: 0;
                height: 3px;
                background: linear-gradient(90deg, #3b82f6, #06b6d4);
                z-index: 1000;
                transition: width 0.1s ease;
            }

            /* Animation states */
            .animating {
                pointer-events: none;
            }

            .animated {
                /* Animation completed */
            }

            /* Reduced motion support */
            @media (prefers-reduced-motion: reduce) {
                *,
                *::before,
                *::after {
                    animation-duration: 0.01ms !important;
                    animation-iteration-count: 1 !important;
                    transition-duration: 0.01ms !important;
                }
            }
        `;

        const styleSheet = document.createElement('style');
        styleSheet.textContent = styles;
        document.head.appendChild(styleSheet);
    }

    // ===============================
    // تهيئة النظام - System Initialization
    // ===============================
    
    function initAnimations() {
        // Inject required styles
        injectAnimationStyles();

        // Create animation manager
        const animationManager = new AnimationManager();

        // Setup special effects
        SpecialEffects.createFloatingElements();
        SpecialEffects.createTextRevealAnimation();
        
        // Add reading progress bar
        const progressBar = document.createElement('div');
        progressBar.className = 'reading-progress';
        document.body.appendChild(progressBar);

        // Handle count up animations when visible
        const countElements = document.querySelectorAll('[data-count]');
        const countObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animationManager.animateCountUp(entry.target);
                }
            });
        });

        countElements.forEach(element => {
            countObserver.observe(element);
        });

        // Export for external use
        window.AnimationManager = animationManager;
        window.SpecialEffects = SpecialEffects;

        console.log('🎬 Animation system initialized successfully');
    }

    // ===============================
    // تشغيل عند تحميل الصفحة - Initialize on DOM ready
    // ===============================
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAnimations);
    } else {
        initAnimations();
    }

})();