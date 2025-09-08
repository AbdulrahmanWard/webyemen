/**
 * ملف JavaScript الرئيسي - شركة الدمام للعوازل والترميم
 * Main JavaScript File - Al-Dammam Insulation & Renovation
 * Version: 2.0
 */

(function() {
    'use strict';

    // ===============================
    // متغيرات عامة - Global Variables
    // ===============================
    
    const state = {
        isLoading: false,
        isDarkMode: localStorage.getItem('darkMode') === 'true',
        isMobileMenuOpen: false,
        scrollPosition: 0,
        animations: new Map()
    };

    const elements = {
        body: document.body,
        header: document.getElementById('mainHeader'),
        mobileMenuToggle: document.getElementById('mobileMenuToggle'),
        mobileOverlay: document.getElementById('mobileOverlay'),
        navMenu: document.getElementById('navMenu'),
        darkModeToggle: document.getElementById('darkModeToggle'),
        backToTop: document.getElementById('backToTop'),
        loadingSpinner: document.getElementById('loading-spinner'),
        quickRequestBtn: document.getElementById('quickRequestBtn')
    };

    // ===============================
    // دوال المساعدة - Helper Functions
    // ===============================
    
    /**
     * تأخير التنفيذ - Debounce function
     */
    function debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                timeout = null;
                if (!immediate) func(...args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func(...args);
        };
    }

    /**
     * تشغيل دالة عند التمرير - Throttle function
     */
    function throttle(func, limit) {
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
    }

    /**
     * فحص إذا كان العنصر مرئياً - Check if element is in viewport
     */
    function isInViewport(element, offset = 0) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 - offset &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) + offset &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    /**
     * تأثير التمرير السلس - Smooth scroll
     */
    function smoothScrollTo(target, duration = 800) {
        const targetElement = typeof target === 'string' ? document.querySelector(target) : target;
        if (!targetElement) return;

        const targetPosition = targetElement.offsetTop - (elements.header?.offsetHeight || 0) - 20;
        const startPosition = window.pageYOffset;
        const distance = targetPosition - startPosition;
        let startTime = null;

        function animation(currentTime) {
            if (startTime === null) startTime = currentTime;
            const timeElapsed = currentTime - startTime;
            const run = ease(timeElapsed, startPosition, distance, duration);
            window.scrollTo(0, run);
            if (timeElapsed < duration) requestAnimationFrame(animation);
        }

        function ease(t, b, c, d) {
            t /= d / 2;
            if (t < 1) return c / 2 * t * t + b;
            t--;
            return -c / 2 * (t * (t - 2) - 1) + b;
        }

        requestAnimationFrame(animation);
    }

    // ===============================
    // إدارة التحميل - Loading Management
    // ===============================
    
    function showLoading() {
        state.isLoading = true;
        if (elements.loadingSpinner) {
            elements.loadingSpinner.classList.remove('hidden');
        }
    }

    function hideLoading() {
        state.isLoading = false;
        if (elements.loadingSpinner) {
            elements.loadingSpinner.classList.add('hidden');
        }
    }

    // ===============================
    // إدارة الوضع المظلم - Dark Mode
    // ===============================
    
    function toggleDarkMode() {
        state.isDarkMode = !state.isDarkMode;
        elements.body.classList.toggle('dark-mode', state.isDarkMode);
        localStorage.setItem('darkMode', state.isDarkMode.toString());
        
        // تطبيق التأثير على العناصر الأخرى
        document.documentElement.style.setProperty('--transition-duration', '0.3s');
        
        // إرسال إحصائية
        trackEvent('dark_mode_toggle', { mode: state.isDarkMode ? 'dark' : 'light' });
    }

    function initDarkMode() {
        if (state.isDarkMode) {
            elements.body.classList.add('dark-mode');
        }

        // فحص تفضيل النظام
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches && !localStorage.getItem('darkMode')) {
            toggleDarkMode();
        }

        // مراقبة تغيير تفضيل النظام
        if (window.matchMedia) {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (!localStorage.getItem('darkMode')) {
                    state.isDarkMode = e.matches;
                    elements.body.classList.toggle('dark-mode', state.isDarkMode);
                }
            });
        }
    }

    // ===============================
    // إدارة القائمة المحمولة - Mobile Menu
    // ===============================
    
    function toggleMobileMenu() {
        state.isMobileMenuOpen = !state.isMobileMenuOpen;
        
        elements.mobileMenuToggle?.classList.toggle('active', state.isMobileMenuOpen);
        elements.navMenu?.classList.toggle('active', state.isMobileMenuOpen);
        elements.mobileOverlay?.classList.toggle('active', state.isMobileMenuOpen);
        elements.body.classList.toggle('menu-open', state.isMobileMenuOpen);

        // منع التمرير عند فتح القائمة
        if (state.isMobileMenuOpen) {
            state.scrollPosition = window.pageYOffset;
            elements.body.style.top = `-${state.scrollPosition}px`;
            elements.body.classList.add('no-scroll');
        } else {
            elements.body.classList.remove('no-scroll');
            elements.body.style.top = '';
            window.scrollTo(0, state.scrollPosition);
        }
    }

    function closeMobileMenu() {
        if (state.isMobileMenuOpen) {
            toggleMobileMenu();
        }
    }

    // ===============================
    // إدارة التمرير - Scroll Management
    // ===============================
    
    const handleScroll = throttle(() => {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // تأثير الهيدر عند التمرير
        if (elements.header) {
            if (scrollTop > 100) {
                elements.header.classList.add('scrolled');
            } else {
                elements.header.classList.remove('scrolled');
            }
        }

        // إظهار/إخفاء زر العودة لأعلى
        if (elements.backToTop) {
            if (scrollTop > 300) {
                elements.backToTop.classList.add('show');
            } else {
                elements.backToTop.classList.remove('show');
            }
        }

        // تحديث الروابط النشطة في القائمة
        updateActiveNavLinks();

        // تشغيل الحركات عند الظهور
        triggerAnimationsOnScroll();

    }, 100);

    /**
     * تحديث الروابط النشطة في القائمة
     */
    function updateActiveNavLinks() {
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link[href^="#"]');

        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (window.pageYOffset >= sectionTop - 200) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === '#' + current) {
                link.classList.add('active');
            }
        });
    }

    // ===============================
    // الحركات والتأثيرات - Animations
    // ===============================
    
    function triggerAnimationsOnScroll() {
        const animatedElements = document.querySelectorAll('[data-animate]:not(.animated)');
        
        animatedElements.forEach(element => {
            if (isInViewport(element, 100)) {
                const animationType = element.getAttribute('data-animate');
                const delay = element.getAttribute('data-delay') || 0;
                
                setTimeout(() => {
                    element.classList.add('animate-' + animationType, 'animated');
                }, delay);
            }
        });
    }

    /**
     * إضافة تأثير الطباعة التدريجية
     */
    function typeWriter(element, text, speed = 50) {
        element.innerHTML = '';
        let i = 0;
        
        function type() {
            if (i < text.length) {
                element.innerHTML += text.charAt(i);
                i++;
                setTimeout(type, speed);
            }
        }
        
        type();
    }

    /**
     * تأثير العد التصاعدي
     */
    function countUp(element, target, duration = 2000) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current).toLocaleString('ar-SA');
        }, 16);
    }

    // ===============================
    // النماذج والتحقق - Forms & Validation
    // ===============================
    
    function initForms() {
        const forms = document.querySelectorAll('form[data-validate]');
        
        forms.forEach(form => {
            form.addEventListener('submit', handleFormSubmit);
            
            // إضافة التحقق في الوقت الفعلي
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('blur', () => validateField(input));
                input.addEventListener('input', debounce(() => validateField(input), 300));
            });
        });
    }

    function handleFormSubmit(e) {
        e.preventDefault();
        const form = e.target;
        
        if (validateForm(form)) {
            submitForm(form);
        }
    }

    function validateForm(form) {
        const inputs = form.querySelectorAll('[required], [data-validate]');
        let isValid = true;
        
        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });
        
        return isValid;
    }

    function validateField(field) {
        const value = field.value.trim();
        const type = field.type || field.getAttribute('data-validate');
        let isValid = true;
        let errorMessage = '';

        // فحص الحقول المطلوبة
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'هذا الحقل مطلوب';
        }
        // فحص البريد الإلكتروني
        else if (type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'يرجى إدخال بريد إلكتروني صحيح';
            }
        }
        // فحص رقم الهاتف السعودي
        else if (type === 'phone' && value) {
            const phoneRegex = /^(\+966|966|0)?[5][0-9]{8}$/;
            if (!phoneRegex.test(value.replace(/\s+/g, ''))) {
                isValid = false;
                errorMessage = 'يرجى إدخال رقم هاتف سعودي صحيح';
            }
        }

        // عرض رسالة الخطأ
        showFieldError(field, isValid, errorMessage);
        
        return isValid;
    }

    function showFieldError(field, isValid, message) {
        const errorElement = field.parentNode.querySelector('.field-error');
        
        field.classList.toggle('error', !isValid);
        
        if (!isValid && message) {
            if (errorElement) {
                errorElement.textContent = message;
            } else {
                const error = document.createElement('span');
                error.className = 'field-error';
                error.textContent = message;
                field.parentNode.appendChild(error);
            }
        } else if (errorElement) {
            errorElement.remove();
        }
    }

    async function submitForm(form) {
        showLoading();
        
        try {
            const formData = new FormData(form);
            const response = await fetch(form.action || '/api/submit-form', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();
            
            if (result.success) {
                showNotification('تم إرسال طلبك بنجاح! سنتواصل معك قريباً.', 'success');
                form.reset();
                trackEvent('form_submit', { form_type: form.id || 'unknown' });
            } else {
                showNotification(result.message || 'حدث خطأ أثناء الإرسال', 'error');
            }
        } catch (error) {
            console.error('خطأ في إرسال النموذج:', error);
            showNotification('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.', 'error');
        } finally {
            hideLoading();
        }
    }

    // ===============================
    // الإشعارات - Notifications
    // ===============================
    
    function showNotification(message, type = 'info', duration = 5000) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <span class="notification-message">${message}</span>
                <button class="notification-close" onclick="this.parentElement.parentElement.remove()">×</button>
            </div>
        `;

        // إضافة الإشعار للصفحة
        const container = document.querySelector('.notifications-container') || createNotificationsContainer();
        container.appendChild(notification);

        // حركة الظهور
        setTimeout(() => notification.classList.add('show'), 100);

        // إزالة تلقائية
        if (duration > 0) {
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }, duration);
        }
    }

    function createNotificationsContainer() {
        const container = document.createElement('div');
        container.className = 'notifications-container';
        document.body.appendChild(container);
        return container;
    }

    // ===============================
    // تتبع الأحداث - Event Tracking
    // ===============================
    
    function trackEvent(eventName, properties = {}) {
        // Google Analytics
        if (typeof gtag !== 'undefined') {
            gtag('event', eventName, properties);
        }

        // تسجيل محلي للتطوير
        console.log('Event tracked:', eventName, properties);
    }

    // ===============================
    // تحسين الأداء - Performance
    // ===============================
    
    function lazyLoadImages() {
        const images = document.querySelectorAll('img[data-src]');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px 0px'
            });

            images.forEach(img => {
                img.classList.add('lazy');
                imageObserver.observe(img);
            });
        } else {
            // Fallback للمتصفحات القديمة
            images.forEach(img => {
                img.src = img.dataset.src;
            });
        }
    }

    function preloadCriticalResources() {
        const criticalImages = [
            '/assets/images/logo.svg',
            '/assets/images/hero-bg.jpg'
        ];

        criticalImages.forEach(src => {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.as = 'image';
            link.href = src;
            document.head.appendChild(link);
        });
    }

    // ===============================
    // إعداد مستمعي الأحداث - Event Listeners
    // ===============================
    
    function initEventListeners() {
        // الوضع المظلم
        elements.darkModeToggle?.addEventListener('click', toggleDarkMode);

        // القائمة المحمولة
        elements.mobileMenuToggle?.addEventListener('click', toggleMobileMenu);
        elements.mobileOverlay?.addEventListener('click', closeMobileMenu);

        // العودة لأعلى
        elements.backToTop?.addEventListener('click', () => {
            smoothScrollTo(document.body);
            trackEvent('back_to_top_click');
        });

        // الروابط السلسة
        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', (e) => {
                const target = link.getAttribute('href');
                if (target !== '#' && document.querySelector(target)) {
                    e.preventDefault();
                    smoothScrollTo(target);
                    closeMobileMenu();
                }
            });
        });

        // طلب عرض سعر سريع
        elements.quickRequestBtn?.addEventListener('click', () => {
            const contactForm = document.querySelector('#contact-form');
            if (contactForm) {
                smoothScrollTo(contactForm);
            }
            trackEvent('quick_request_click');
        });

        // مراقبة التمرير
        window.addEventListener('scroll', handleScroll);

        // مراقبة تغيير حجم النافذة
        window.addEventListener('resize', debounce(() => {
            // إغلاق القائمة المحمولة عند تكبير الشاشة
            if (window.innerWidth > 768 && state.isMobileMenuOpen) {
                closeMobileMenu();
            }
        }, 250));

        // إغلاق القائمة عند الضغط على ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && state.isMobileMenuOpen) {
                closeMobileMenu();
            }
        });

        // فحص الاتصال
        window.addEventListener('online', () => {
            showNotification('تم استعادة الاتصال بالإنترنت', 'success');
        });

        window.addEventListener('offline', () => {
            showNotification('لا يوجد اتصال بالإنترنت', 'warning');
        });
    }

    // ===============================
    // التهيئة الرئيسية - Main Initialization
    // ===============================
    
    function init() {
        // إخفاء شاشة التحميل
        setTimeout(hideLoading, 1000);

        // تهيئة المكونات
        initDarkMode();
        initEventListeners();
        initForms();
        
        // تحسينات الأداء
        lazyLoadImages();
        preloadCriticalResources();
        
        // تشغيل الحركات الأولية
        setTimeout(() => {
            triggerAnimationsOnScroll();
        }, 500);

        // تتبع تحميل الصفحة
        trackEvent('page_load', {
            page: window.location.pathname,
            user_agent: navigator.userAgent,
            screen_resolution: `${screen.width}x${screen.height}`
        });

        console.log('🚀 تم تحميل موقع الدمام للعوازل والترميم بنجاح');
    }

    // ===============================
    // بدء التطبيق - App Startup
    // ===============================
    
    // التحميل عند اكتمال DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // تصدير الوظائف للاستخدام الخارجي
    window.AlDammamApp = {
        showNotification,
        smoothScrollTo,
        trackEvent,
        toggleDarkMode,
        validateField
    };

})();