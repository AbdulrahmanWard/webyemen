/**
 * ملف JavaScript لسلايدر قبل/بعد - شركة الدمام للعوازل والترميم
 * Before/After Slider JavaScript - Al-Dammam Insulation & Renovation
 * Version: 1.0
 */

(function() {
    'use strict';

    // ===============================
    // إعدادات السلايدر - Slider Settings
    // ===============================
    
    const sliderSettings = {
        autoPlay: true,
        autoPlayInterval: 5000,
        enableTouch: true,
        enableKeyboard: true,
        showIndicators: true,
        showControls: true,
        pauseOnHover: true,
        dragSensitivity: 0.5,
        animationDuration: 300,
        easing: 'ease-in-out'
    };

    // ===============================
    // فئة سلايدر قبل/بعد - BeforeAfterSlider Class
    // ===============================
    
    class BeforeAfterSlider {
        constructor(container) {
            this.container = container;
            this.slides = [];
            this.currentIndex = 0;
            this.isPlaying = sliderSettings.autoPlay;
            this.autoPlayTimer = null;
            this.isDragging = false;
            this.startX = 0;
            this.currentX = 0;
            this.dragThreshold = 50;
            
            this.init();
        }

        init() {
            this.setupSlides();
            this.setupControls();
            this.setupIndicators();
            this.setupEventListeners();
            this.initializeSlider();
            this.startAutoPlay();
        }

        setupSlides() {
            const slideElements = this.container.querySelectorAll('.before-after-item');
            
            slideElements.forEach((slide, index) => {
                const slideData = {
                    element: slide,
                    index: index,
                    beforeAfterContainer: slide.querySelector('.before-after-container'),
                    beforeImage: slide.querySelector('.before-image img'),
                    afterImage: slide.querySelector('.after-image img'),
                    sliderHandle: slide.querySelector('.slider-handle'),
                    isActive: index === 0
                };

                // تهيئة البيانات الإضافية
                if (slideData.beforeAfterContainer) {
                    this.setupBeforeAfterComparison(slideData);
                }

                this.slides.push(slideData);
            });
        }

        setupBeforeAfterComparison(slideData) {
            const container = slideData.beforeAfterContainer;
            const handle = slideData.sliderHandle;
            
            if (!container || !handle) return;

            let isComparing = false;
            let containerRect = container.getBoundingClientRect();

            // تحديث موقع المقبض
            const updateSlider = (percentage) => {
                percentage = Math.max(0, Math.min(100, percentage));
                
                const afterImage = container.querySelector('.after-image');
                if (afterImage) {
                    afterImage.style.clipPath = `inset(0 ${100 - percentage}% 0 0)`;
                }
                
                handle.style.left = `${percentage}%`;
            };

            // أحداث الفأرة
            const handleMouseDown = (e) => {
                isComparing = true;
                containerRect = container.getBoundingClientRect();
                container.classList.add('comparing');
                document.addEventListener('mousemove', handleMouseMove);
                document.addEventListener('mouseup', handleMouseUp);
                e.preventDefault();
            };

            const handleMouseMove = (e) => {
                if (!isComparing) return;
                
                const x = e.clientX - containerRect.left;
                const percentage = (x / containerRect.width) * 100;
                updateSlider(percentage);
            };

            const handleMouseUp = () => {
                isComparing = false;
                container.classList.remove('comparing');
                document.removeEventListener('mousemove', handleMouseMove);
                document.removeEventListener('mouseup', handleMouseUp);
            };

            // أحداث اللمس
            const handleTouchStart = (e) => {
                isComparing = true;
                containerRect = container.getBoundingClientRect();
                container.classList.add('comparing');
                e.preventDefault();
            };

            const handleTouchMove = (e) => {
                if (!isComparing) return;
                
                const touch = e.touches[0];
                const x = touch.clientX - containerRect.left;
                const percentage = (x / containerRect.width) * 100;
                updateSlider(percentage);
                e.preventDefault();
            };

            const handleTouchEnd = () => {
                isComparing = false;
                container.classList.remove('comparing');
            };

            // ربط الأحداث
            handle.addEventListener('mousedown', handleMouseDown);
            
            if (sliderSettings.enableTouch) {
                handle.addEventListener('touchstart', handleTouchStart, { passive: false });
                container.addEventListener('touchmove', handleTouchMove, { passive: false });
                container.addEventListener('touchend', handleTouchEnd);
            }

            // تحديث الحجم عند تغيير حجم النافذة
            window.addEventListener('resize', () => {
                containerRect = container.getBoundingClientRect();
            });

            // تهيئة الموقع الابتدائي
            updateSlider(50);
        }

        setupControls() {
            if (!sliderSettings.showControls) return;

            const prevBtn = this.container.parentNode.querySelector('.prev-btn');
            const nextBtn = this.container.parentNode.querySelector('.next-btn');

            if (prevBtn) {
                prevBtn.addEventListener('click', () => this.previousSlide());
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => this.nextSlide());
            }
        }

        setupIndicators() {
            if (!sliderSettings.showIndicators) return;

            const indicatorsContainer = this.container.parentNode.querySelector('.slider-indicators');
            if (!indicatorsContainer) return;

            // إنشاء مؤشرات جديدة إذا لم تكن موجودة
            if (indicatorsContainer.children.length === 0) {
                this.slides.forEach((_, index) => {
                    const indicator = document.createElement('button');
                    indicator.className = 'indicator';
                    indicator.setAttribute('data-slide', index);
                    indicator.addEventListener('click', () => this.goToSlide(index));
                    indicatorsContainer.appendChild(indicator);
                });
            } else {
                // ربط المؤشرات الموجودة
                const indicators = indicatorsContainer.querySelectorAll('.indicator');
                indicators.forEach((indicator, index) => {
                    indicator.addEventListener('click', () => this.goToSlide(index));
                });
            }

            this.updateIndicators();
        }

        setupEventListeners() {
            // أحداث لوحة المفاتيح
            if (sliderSettings.enableKeyboard) {
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft') {
                        this.nextSlide();
                    } else if (e.key === 'ArrowRight') {
                        this.previousSlide();
                    }
                });
            }

            // إيقاف التشغيل التلقائي عند التمرير
            if (sliderSettings.pauseOnHover) {
                this.container.addEventListener('mouseenter', () => this.pauseAutoPlay());
                this.container.addEventListener('mouseleave', () => this.resumeAutoPlay());
            }

            // أحداث السحب
            if (sliderSettings.enableTouch) {
                this.setupDragEvents();
            }

            // تحديث الحجم عند تغيير النافذة
            window.addEventListener('resize', () => this.handleResize());
        }

        setupDragEvents() {
            let startTime = 0;

            // أحداث الفأرة
            this.container.addEventListener('mousedown', (e) => {
                this.startDrag(e.clientX);
                startTime = Date.now();
            });

            document.addEventListener('mousemove', (e) => {
                if (this.isDragging) {
                    this.updateDrag(e.clientX);
                }
            });

            document.addEventListener('mouseup', (e) => {
                if (this.isDragging) {
                    const endTime = Date.now();
                    const deltaTime = endTime - startTime;
                    this.endDrag(e.clientX, deltaTime);
                }
            });

            // أحداث اللمس
            this.container.addEventListener('touchstart', (e) => {
                const touch = e.touches[0];
                this.startDrag(touch.clientX);
                startTime = Date.now();
                e.preventDefault();
            }, { passive: false });

            this.container.addEventListener('touchmove', (e) => {
                if (this.isDragging) {
                    const touch = e.touches[0];
                    this.updateDrag(touch.clientX);
                    e.preventDefault();
                }
            }, { passive: false });

            this.container.addEventListener('touchend', (e) => {
                if (this.isDragging && e.changedTouches.length > 0) {
                    const touch = e.changedTouches[0];
                    const endTime = Date.now();
                    const deltaTime = endTime - startTime;
                    this.endDrag(touch.clientX, deltaTime);
                    e.preventDefault();
                }
            }, { passive: false });
        }

        startDrag(x) {
            this.isDragging = true;
            this.startX = x;
            this.currentX = x;
            this.container.classList.add('dragging');
            this.pauseAutoPlay();
        }

        updateDrag(x) {
            if (!this.isDragging) return;

            this.currentX = x;
            const deltaX = this.currentX - this.startX;
            const containerWidth = this.container.offsetWidth;
            const percentage = (deltaX / containerWidth) * 100;

            // تحديث موقع السلايدر بصرياً
            this.container.style.transform = `translateX(${deltaX}px)`;
        }

        endDrag(x, deltaTime) {
            if (!this.isDragging) return;

            this.isDragging = false;
            this.container.classList.remove('dragging');
            this.container.style.transform = '';

            const deltaX = x - this.startX;
            const containerWidth = this.container.offsetWidth;
            const percentage = Math.abs(deltaX) / containerWidth;
            
            // تحديد ما إذا كان يجب تغيير الشريحة
            const isSwipe = percentage > sliderSettings.dragSensitivity || 
                           (Math.abs(deltaX) > this.dragThreshold && deltaTime < 300);

            if (isSwipe) {
                if (deltaX > 0) {
                    this.previousSlide();
                } else {
                    this.nextSlide();
                }
            }

            this.resumeAutoPlay();
        }

        initializeSlider() {
            this.slides.forEach((slide, index) => {
                slide.element.classList.toggle('active', index === this.currentIndex);
                slide.element.style.display = index === this.currentIndex ? 'block' : 'none';
            });
        }

        goToSlide(index) {
            if (index === this.currentIndex || index < 0 || index >= this.slides.length) {
                return;
            }

            const previousIndex = this.currentIndex;
            this.currentIndex = index;

            this.animateSlideTransition(previousIndex, index);
            this.updateIndicators();
            this.triggerSlideChangeEvent();
        }

        nextSlide() {
            const nextIndex = (this.currentIndex + 1) % this.slides.length;
            this.goToSlide(nextIndex);
        }

        previousSlide() {
            const prevIndex = (this.currentIndex - 1 + this.slides.length) % this.slides.length;
            this.goToSlide(prevIndex);
        }

        animateSlideTransition(fromIndex, toIndex) {
            const fromSlide = this.slides[fromIndex];
            const toSlide = this.slides[toIndex];

            // إضافة كلاسات الحركة
            fromSlide.element.classList.add('slide-out');
            toSlide.element.classList.add('slide-in');

            // إظهار الشريحة الجديدة
            toSlide.element.style.display = 'block';
            toSlide.element.classList.add('active');

            setTimeout(() => {
                // إخفاء الشريحة السابقة
                fromSlide.element.style.display = 'none';
                fromSlide.element.classList.remove('active', 'slide-out');
                
                // تنظيف كلاسات الحركة
                toSlide.element.classList.remove('slide-in');
                
                // تحديث حالة الصور
                this.updateImagesLoading();
                
            }, sliderSettings.animationDuration);
        }

        updateIndicators() {
            const indicators = this.container.parentNode.querySelectorAll('.indicator');
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === this.currentIndex);
            });
        }

        updateImagesLoading() {
            const currentSlide = this.slides[this.currentIndex];
            const images = currentSlide.element.querySelectorAll('img[data-src]');
            
            images.forEach(img => {
                if (!img.src && img.dataset.src) {
                    img.src = img.dataset.src;
                    img.classList.add('loading');
                    
                    img.addEventListener('load', () => {
                        img.classList.remove('loading');
                        img.classList.add('loaded');
                    });
                }
            });
        }

        startAutoPlay() {
            if (!sliderSettings.autoPlay) return;

            this.autoPlayTimer = setInterval(() => {
                if (this.isPlaying) {
                    this.nextSlide();
                }
            }, sliderSettings.autoPlayInterval);
        }

        pauseAutoPlay() {
            this.isPlaying = false;
        }

        resumeAutoPlay() {
            if (sliderSettings.autoPlay) {
                this.isPlaying = true;
            }
        }

        stopAutoPlay() {
            if (this.autoPlayTimer) {
                clearInterval(this.autoPlayTimer);
                this.autoPlayTimer = null;
            }
            this.isPlaying = false;
        }

        handleResize() {
            // إعادة حساب أبعاد الصور والمقابض
            this.slides.forEach(slide => {
                if (slide.beforeAfterContainer) {
                    const container = slide.beforeAfterContainer;
                    const handle = slide.sliderHandle;
                    
                    if (handle) {
                        // إعادة تعيين موقع المقبض
                        const currentLeft = parseFloat(handle.style.left) || 50;
                        handle.style.left = `${currentLeft}%`;
                    }
                }
            });
        }

        triggerSlideChangeEvent() {
            const event = new CustomEvent('slideChange', {
                detail: {
                    currentIndex: this.currentIndex,
                    currentSlide: this.slides[this.currentIndex],
                    totalSlides: this.slides.length
                }
            });
            
            this.container.dispatchEvent(event);
        }

        // Public API methods
        play() {
            this.isPlaying = true;
        }

        pause() {
            this.isPlaying = false;
        }

        stop() {
            this.stopAutoPlay();
        }

        getCurrentSlide() {
            return this.slides[this.currentIndex];
        }

        getTotalSlides() {
            return this.slides.length;
        }

        destroy() {
            this.stopAutoPlay();
            // إزالة مستمعي الأحداث
            // ... (تنظيف الذاكرة)
        }
    }

    // ===============================
    // مدير المعرض - Gallery Manager
    // ===============================
    
    class GalleryManager {
        constructor() {
            this.sliders = new Map();
            this.init();
        }

        init() {
            this.initializeSliders();
            this.setupLightbox();
        }

        initializeSliders() {
            const sliderContainers = document.querySelectorAll('.before-after-slider');
            
            sliderContainers.forEach((container, index) => {
                const slider = new BeforeAfterSlider(container);
                this.sliders.set(`slider-${index}`, slider);
                
                // مستمع تغيير الشريحة
                container.addEventListener('slideChange', (e) => {
                    this.handleSlideChange(e.detail);
                });
            });
        }

        setupLightbox() {
            // إعداد معرض الصور المكبرة
            const images = document.querySelectorAll('.before-after-item img');
            
            images.forEach(img => {
                img.addEventListener('click', (e) => {
                    this.openLightbox(e.target);
                });
            });
        }

        openLightbox(image) {
            // إنشاء نافذة معرض الصور
            const lightbox = document.createElement('div');
            lightbox.className = 'lightbox-overlay';
            lightbox.innerHTML = `
                <div class="lightbox-container">
                    <button class="lightbox-close">&times;</button>
                    <img src="${image.src}" alt="${image.alt}" class="lightbox-image">
                    <div class="lightbox-caption">
                        <h4>${image.alt}</h4>
                    </div>
                </div>
            `;

            document.body.appendChild(lightbox);
            document.body.classList.add('lightbox-open');

            // أحداث الإغلاق
            const closeBtn = lightbox.querySelector('.lightbox-close');
            closeBtn.addEventListener('click', () => this.closeLightbox(lightbox));
            
            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) {
                    this.closeLightbox(lightbox);
                }
            });

            // إغلاق بالضغط على ESC
            const handleKeyDown = (e) => {
                if (e.key === 'Escape') {
                    this.closeLightbox(lightbox);
                    document.removeEventListener('keydown', handleKeyDown);
                }
            };
            
            document.addEventListener('keydown', handleKeyDown);

            // تأثير الظهور
            setTimeout(() => lightbox.classList.add('show'), 10);
        }

        closeLightbox(lightbox) {
            lightbox.classList.remove('show');
            document.body.classList.remove('lightbox-open');
            
            setTimeout(() => {
                if (lightbox.parentNode) {
                    lightbox.remove();
                }
            }, 300);
        }

        handleSlideChange(detail) {
            // تتبع تغيير الشريحة
            if (window.AlDammamApp && window.AlDammamApp.trackEvent) {
                window.AlDammamApp.trackEvent('gallery_slide_change', {
                    slide_index: detail.currentIndex,
                    total_slides: detail.totalSlides
                });
            }
        }

        getSlider(id) {
            return this.sliders.get(id);
        }

        getAllSliders() {
            return Array.from(this.sliders.values());
        }
    }

    // ===============================
    // إضافة أنماط CSS للسلايدر
    // ===============================
    
    function injectSliderStyles() {
        const styles = `
            .before-after-slider {
                position: relative;
                overflow: hidden;
            }

            .before-after-item {
                display: none;
                opacity: 0;
                transition: opacity ${sliderSettings.animationDuration}ms ${sliderSettings.easing};
            }

            .before-after-item.active {
                display: block;
                opacity: 1;
            }

            .before-after-item.slide-in {
                animation: slideIn ${sliderSettings.animationDuration}ms ${sliderSettings.easing};
            }

            .before-after-item.slide-out {
                animation: slideOut ${sliderSettings.animationDuration}ms ${sliderSettings.easing};
            }

            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateX(50px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes slideOut {
                from {
                    opacity: 1;
                    transform: translateX(0);
                }
                to {
                    opacity: 0;
                    transform: translateX(-50px);
                }
            }

            .before-after-container {
                position: relative;
                overflow: hidden;
                border-radius: 12px;
                cursor: grab;
            }

            .before-after-container.comparing {
                cursor: grabbing;
            }

            .before-after-container.dragging {
                user-select: none;
            }

            .before-image,
            .after-image {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }

            .after-image {
                clip-path: inset(0 50% 0 0);
                transition: clip-path 0.1s ease;
            }

            .slider-handle {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 40px;
                height: 40px;
                background: white;
                border: 3px solid #3b82f6;
                border-radius: 50%;
                cursor: grab;
                z-index: 10;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                transition: transform 0.2s ease;
            }

            .slider-handle:hover {
                transform: translate(-50%, -50%) scale(1.1);
            }

            .slider-handle:active {
                cursor: grabbing;
                transform: translate(-50%, -50%) scale(0.95);
            }

            .slider-button {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 100%;
                font-size: 18px;
                color: #3b82f6;
                font-weight: bold;
            }

            .image-label {
                position: absolute;
                top: 16px;
                padding: 6px 12px;
                background: rgba(0,0,0,0.7);
                color: white;
                border-radius: 20px;
                font-size: 14px;
                font-weight: 600;
                z-index: 5;
            }

            .image-label.before {
                right: 16px;
            }

            .image-label.after {
                left: 16px;
            }

            .lightbox-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.9);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10000;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .lightbox-overlay.show {
                opacity: 1;
                visibility: visible;
            }

            .lightbox-container {
                position: relative;
                max-width: 90vw;
                max-height: 90vh;
                background: white;
                border-radius: 12px;
                padding: 20px;
                transform: scale(0.9);
                transition: transform 0.3s ease;
            }

            .lightbox-overlay.show .lightbox-container {
                transform: scale(1);
            }

            .lightbox-close {
                position: absolute;
                top: 10px;
                left: 10px;
                background: none;
                border: none;
                font-size: 30px;
                cursor: pointer;
                color: #666;
                z-index: 10001;
            }

            .lightbox-image {
                max-width: 100%;
                max-height: 70vh;
                object-fit: contain;
                border-radius: 8px;
            }

            .lightbox-caption {
                margin-top: 15px;
                text-align: center;
            }

            .lightbox-caption h4 {
                margin: 0;
                color: #333;
                font-size: 18px;
            }

            body.lightbox-open {
                overflow: hidden;
            }

            /* تحسينات للهواتف المحمولة */
            @media (max-width: 768px) {
                .slider-handle {
                    width: 35px;
                    height: 35px;
                }

                .image-label {
                    font-size: 12px;
                    padding: 4px 8px;
                }

                .lightbox-container {
                    max-width: 95vw;
                    padding: 15px;
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
    
    function initBeforeAfterSliders() {
        // إدراج الأنماط المطلوبة
        injectSliderStyles();

        // إنشاء مدير المعرض
        const galleryManager = new GalleryManager();

        // تصدير للاستخدام الخارجي
        window.BeforeAfterSlider = BeforeAfterSlider;
        window.GalleryManager = galleryManager;

        console.log('📸 Before/After slider system initialized successfully');
    }

    // ===============================
    // تشغيل عند تحميل الصفحة - Initialize on DOM ready
    // ===============================
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBeforeAfterSliders);
    } else {
        initBeforeAfterSliders();
    }

})();