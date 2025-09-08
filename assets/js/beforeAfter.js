/**
 * Before/After Image Comparison for Dammam Insulation & Renovation
 * Interactive image sliders to showcase project transformations
 */

(function() {
    'use strict';

    // ===== BEFORE/AFTER SLIDER =====
    class BeforeAfterSlider {
        constructor(container, options = {}) {
            this.container = container;
            this.options = {
                initialPosition: 50,
                showLabels: true,
                labelBefore: 'قبل',
                labelAfter: 'بعد',
                orientation: 'horizontal', // horizontal or vertical
                handleSize: 40,
                handleColor: '#3b82f6',
                showCredits: false,
                animateOnHover: true,
                touchEnabled: true,
                keyboardEnabled: true,
                smoothTransition: true,
                autoSlide: false,
                autoSlideInterval: 3000,
                ...options
            };

            this.isDragging = false;
            this.currentPosition = this.options.initialPosition;
            this.autoSlideTimer = null;
            this.isInitialized = false;

            this.init();
        }

        init() {
            if (this.isInitialized) return;

            this.createStructure();
            this.bindEvents();
            this.updatePosition(this.options.initialPosition);
            
            if (this.options.autoSlide) {
                this.startAutoSlide();
            }

            this.isInitialized = true;
        }

        createStructure() {
            // Get images
            this.beforeImg = this.container.querySelector('.before-image, [data-before]');
            this.afterImg = this.container.querySelector('.after-image, [data-after]');

            if (!this.beforeImg || !this.afterImg) {
                console.error('Before/After images not found');
                return;
            }

            // Add container class
            this.container.classList.add('before-after-container');
            
            // Set container styles
            this.container.style.position = 'relative';
            this.container.style.overflow = 'hidden';
            this.container.style.cursor = 'ew-resize';
            this.container.style.userSelect = 'none';

            // Create wrapper for images
            this.wrapper = document.createElement('div');
            this.wrapper.className = 'before-after-wrapper';
            this.wrapper.style.position = 'relative';
            this.wrapper.style.width = '100%';
            this.wrapper.style.height = '100%';

            // Style before image (base layer)
            this.beforeImg.style.position = 'absolute';
            this.beforeImg.style.top = '0';
            this.beforeImg.style.left = '0';
            this.beforeImg.style.width = '100%';
            this.beforeImg.style.height = '100%';
            this.beforeImg.style.objectFit = 'cover';
            this.beforeImg.style.zIndex = '1';

            // Style after image (overlay layer)
            this.afterImg.style.position = 'absolute';
            this.afterImg.style.top = '0';
            this.afterImg.style.left = '0';
            this.afterImg.style.width = '100%';
            this.afterImg.style.height = '100%';
            this.afterImg.style.objectFit = 'cover';
            this.afterImg.style.zIndex = '2';

            // Create clipping overlay for after image
            this.overlay = document.createElement('div');
            this.overlay.className = 'before-after-overlay';
            this.overlay.style.position = 'absolute';
            this.overlay.style.top = '0';
            this.overlay.style.left = '0';
            this.overlay.style.width = '100%';
            this.overlay.style.height = '100%';
            this.overlay.style.zIndex = '3';
            this.overlay.style.pointerEvents = 'none';

            // Create slider handle
            this.handle = document.createElement('div');
            this.handle.className = 'before-after-handle';
            this.handle.style.position = 'absolute';
            this.handle.style.zIndex = '4';
            this.handle.style.backgroundColor = this.options.handleColor;
            this.handle.style.cursor = 'ew-resize';
            this.handle.style.borderRadius = '50%';
            this.handle.style.boxShadow = '0 4px 15px rgba(0,0,0,0.3)';
            this.handle.style.transition = this.options.smoothTransition ? 'all 0.3s ease' : 'none';

            if (this.options.orientation === 'horizontal') {
                this.handle.style.width = this.options.handleSize + 'px';
                this.handle.style.height = this.options.handleSize + 'px';
                this.handle.style.top = '50%';
                this.handle.style.transform = 'translateY(-50%)';
            } else {
                this.handle.style.width = this.options.handleSize + 'px';
                this.handle.style.height = this.options.handleSize + 'px';
                this.handle.style.left = '50%';
                this.handle.style.transform = 'translateX(-50%)';
            }

            // Add handle icon
            this.handleIcon = document.createElement('div');
            this.handleIcon.innerHTML = this.options.orientation === 'horizontal' 
                ? '⟷' 
                : '⇅';
            this.handleIcon.style.position = 'absolute';
            this.handleIcon.style.top = '50%';
            this.handleIcon.style.left = '50%';
            this.handleIcon.style.transform = 'translate(-50%, -50%)';
            this.handleIcon.style.color = 'white';
            this.handleIcon.style.fontSize = '18px';
            this.handleIcon.style.pointerEvents = 'none';
            this.handle.appendChild(this.handleIcon);

            // Create slider line
            this.line = document.createElement('div');
            this.line.className = 'before-after-line';
            this.line.style.position = 'absolute';
            this.line.style.backgroundColor = this.options.handleColor;
            this.line.style.zIndex = '3';
            this.line.style.pointerEvents = 'none';

            if (this.options.orientation === 'horizontal') {
                this.line.style.width = '2px';
                this.line.style.height = '100%';
                this.line.style.top = '0';
            } else {
                this.line.style.width = '100%';
                this.line.style.height = '2px';
                this.line.style.left = '0';
            }

            // Add labels if enabled
            if (this.options.showLabels) {
                this.createLabels();
            }

            // Assemble structure
            this.wrapper.appendChild(this.beforeImg);
            this.wrapper.appendChild(this.afterImg);
            this.wrapper.appendChild(this.overlay);
            this.wrapper.appendChild(this.line);
            this.wrapper.appendChild(this.handle);

            // Clear container and add wrapper
            this.container.innerHTML = '';
            this.container.appendChild(this.wrapper);

            // Add credits if enabled
            if (this.options.showCredits) {
                this.addCredits();
            }
        }

        createLabels() {
            this.beforeLabel = document.createElement('div');
            this.beforeLabel.className = 'before-after-label before-label';
            this.beforeLabel.textContent = this.options.labelBefore;
            this.beforeLabel.style.position = 'absolute';
            this.beforeLabel.style.top = '20px';
            this.beforeLabel.style.right = '20px';
            this.beforeLabel.style.background = 'rgba(0,0,0,0.7)';
            this.beforeLabel.style.color = 'white';
            this.beforeLabel.style.padding = '8px 16px';
            this.beforeLabel.style.borderRadius = '20px';
            this.beforeLabel.style.fontSize = '14px';
            this.beforeLabel.style.fontWeight = 'bold';
            this.beforeLabel.style.zIndex = '5';
            this.beforeLabel.style.pointerEvents = 'none';

            this.afterLabel = document.createElement('div');
            this.afterLabel.className = 'before-after-label after-label';
            this.afterLabel.textContent = this.options.labelAfter;
            this.afterLabel.style.position = 'absolute';
            this.afterLabel.style.top = '20px';
            this.afterLabel.style.left = '20px';
            this.afterLabel.style.background = 'rgba(0,0,0,0.7)';
            this.afterLabel.style.color = 'white';
            this.afterLabel.style.padding = '8px 16px';
            this.afterLabel.style.borderRadius = '20px';
            this.afterLabel.style.fontSize = '14px';
            this.afterLabel.style.fontWeight = 'bold';
            this.afterLabel.style.zIndex = '5';
            this.afterLabel.style.pointerEvents = 'none';

            this.wrapper.appendChild(this.beforeLabel);
            this.wrapper.appendChild(this.afterLabel);
        }

        addCredits() {
            const credits = document.createElement('div');
            credits.className = 'before-after-credits';
            credits.innerHTML = '<small>شركة الدمام للعوازل والترميم</small>';
            credits.style.position = 'absolute';
            credits.style.bottom = '10px';
            credits.style.right = '10px';
            credits.style.background = 'rgba(0,0,0,0.7)';
            credits.style.color = 'white';
            credits.style.padding = '4px 8px';
            credits.style.borderRadius = '4px';
            credits.style.fontSize = '12px';
            credits.style.zIndex = '5';
            credits.style.pointerEvents = 'none';

            this.wrapper.appendChild(credits);
        }

        bindEvents() {
            // Mouse events
            this.handle.addEventListener('mousedown', (e) => this.startDrag(e));
            document.addEventListener('mousemove', (e) => this.drag(e));
            document.addEventListener('mouseup', () => this.endDrag());

            // Touch events
            if (this.options.touchEnabled) {
                this.handle.addEventListener('touchstart', (e) => this.startDrag(e.touches[0]));
                document.addEventListener('touchmove', (e) => this.drag(e.touches[0]));
                document.addEventListener('touchend', () => this.endDrag());
            }

            // Container click
            this.container.addEventListener('click', (e) => this.handleContainerClick(e));

            // Keyboard navigation
            if (this.options.keyboardEnabled) {
                this.container.setAttribute('tabindex', '0');
                this.container.addEventListener('keydown', (e) => this.handleKeyboard(e));
            }

            // Hover animation
            if (this.options.animateOnHover) {
                this.container.addEventListener('mouseenter', () => this.startHoverAnimation());
                this.container.addEventListener('mouseleave', () => this.stopHoverAnimation());
            }

            // Resize handling
            window.addEventListener('resize', () => this.handleResize());

            // Auto-slide controls
            if (this.options.autoSlide) {
                this.container.addEventListener('mouseenter', () => this.stopAutoSlide());
                this.container.addEventListener('mouseleave', () => this.startAutoSlide());
            }
        }

        startDrag(e) {
            this.isDragging = true;
            this.container.style.cursor = 'ew-resize';
            this.stopAutoSlide();
            
            // Prevent default to avoid image dragging
            e.preventDefault();
        }

        drag(e) {
            if (!this.isDragging) return;

            const rect = this.container.getBoundingClientRect();
            let position;

            if (this.options.orientation === 'horizontal') {
                position = ((e.clientX - rect.left) / rect.width) * 100;
            } else {
                position = ((e.clientY - rect.top) / rect.height) * 100;
            }

            // Clamp position between 0 and 100
            position = Math.max(0, Math.min(100, position));
            
            this.updatePosition(position);
        }

        endDrag() {
            if (this.isDragging) {
                this.isDragging = false;
                this.container.style.cursor = '';
                
                if (this.options.autoSlide) {
                    setTimeout(() => this.startAutoSlide(), 2000);
                }
            }
        }

        handleContainerClick(e) {
            if (this.isDragging || e.target === this.handle) return;

            const rect = this.container.getBoundingClientRect();
            let position;

            if (this.options.orientation === 'horizontal') {
                position = ((e.clientX - rect.left) / rect.width) * 100;
            } else {
                position = ((e.clientY - rect.top) / rect.height) * 100;
            }

            this.animateToPosition(position);
        }

        handleKeyboard(e) {
            let position = this.currentPosition;
            const step = 5; // 5% per key press

            switch (e.key) {
                case 'ArrowLeft':
                case 'ArrowUp':
                    position -= step;
                    break;
                case 'ArrowRight':
                case 'ArrowDown':
                    position += step;
                    break;
                case 'Home':
                    position = 0;
                    break;
                case 'End':
                    position = 100;
                    break;
                case ' ':
                case 'Enter':
                    position = 50;
                    break;
                default:
                    return;
            }

            e.preventDefault();
            position = Math.max(0, Math.min(100, position));
            this.animateToPosition(position);
        }

        updatePosition(position) {
            this.currentPosition = position;

            if (this.options.orientation === 'horizontal') {
                // Update clipping
                this.afterImg.style.clipPath = `inset(0 ${100 - position}% 0 0)`;
                
                // Update handle position
                this.handle.style.left = position + '%';
                
                // Update line position
                this.line.style.left = position + '%';
            } else {
                // Update clipping for vertical
                this.afterImg.style.clipPath = `inset(0 0 ${100 - position}% 0)`;
                
                // Update handle position
                this.handle.style.top = position + '%';
                
                // Update line position
                this.line.style.top = position + '%';
            }

            // Update labels opacity
            if (this.options.showLabels) {
                this.beforeLabel.style.opacity = position < 20 ? '0.3' : '1';
                this.afterLabel.style.opacity = position > 80 ? '0.3' : '1';
            }

            // Emit custom event
            this.container.dispatchEvent(new CustomEvent('positionchange', {
                detail: { position: position }
            }));
        }

        animateToPosition(targetPosition) {
            const startPosition = this.currentPosition;
            const diff = targetPosition - startPosition;
            const duration = 500; // 500ms animation
            const startTime = performance.now();

            const animate = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Easing function (ease-out)
                const easeOut = 1 - Math.pow(1 - progress, 3);
                const currentPosition = startPosition + (diff * easeOut);
                
                this.updatePosition(currentPosition);

                if (progress < 1) {
                    requestAnimationFrame(animate);
                }
            };

            requestAnimationFrame(animate);
        }

        startHoverAnimation() {
            if (this.hoverAnimation) return;
            
            let direction = 1;
            let position = this.currentPosition;
            
            const animate = () => {
                position += direction * 0.5;
                
                if (position >= 70) direction = -1;
                if (position <= 30) direction = 1;
                
                this.updatePosition(position);
                this.hoverAnimation = requestAnimationFrame(animate);
            };
            
            this.hoverAnimation = requestAnimationFrame(animate);
        }

        stopHoverAnimation() {
            if (this.hoverAnimation) {
                cancelAnimationFrame(this.hoverAnimation);
                this.hoverAnimation = null;
                this.animateToPosition(this.options.initialPosition);
            }
        }

        startAutoSlide() {
            if (!this.options.autoSlide || this.autoSlideTimer) return;
            
            let direction = 1;
            let position = this.currentPosition;
            
            const slide = () => {
                position += direction * 0.3;
                
                if (position >= 90) direction = -1;
                if (position <= 10) direction = 1;
                
                this.updatePosition(position);
            };
            
            this.autoSlideTimer = setInterval(slide, 50);
        }

        stopAutoSlide() {
            if (this.autoSlideTimer) {
                clearInterval(this.autoSlideTimer);
                this.autoSlideTimer = null;
            }
        }

        handleResize() {
            // Recalculate position on resize
            this.updatePosition(this.currentPosition);
        }

        // Public methods
        setPosition(position) {
            position = Math.max(0, Math.min(100, position));
            this.animateToPosition(position);
        }

        getPosition() {
            return this.currentPosition;
        }

        destroy() {
            this.stopAutoSlide();
            this.stopHoverAnimation();
            
            // Remove event listeners
            document.removeEventListener('mousemove', this.drag);
            document.removeEventListener('mouseup', this.endDrag);
            document.removeEventListener('touchmove', this.drag);
            document.removeEventListener('touchend', this.endDrag);
            
            this.isInitialized = false;
        }
    }

    // ===== BEFORE/AFTER GALLERY =====
    class BeforeAfterGallery {
        constructor(container, options = {}) {
            this.container = container;
            this.options = {
                autoPlay: false,
                autoPlayInterval: 5000,
                showThumbnails: true,
                showNavigation: true,
                showCounter: true,
                ...options
            };

            this.sliders = [];
            this.currentIndex = 0;
            this.autoPlayTimer = null;

            this.init();
        }

        init() {
            this.createGalleryStructure();
            this.bindEvents();
            
            if (this.options.autoPlay) {
                this.startAutoPlay();
            }
        }

        createGalleryStructure() {
            this.container.classList.add('before-after-gallery');
            
            // Find all slider containers
            const sliderContainers = this.container.querySelectorAll('.before-after-item, [data-before-after]');
            
            sliderContainers.forEach((container, index) => {
                const slider = new BeforeAfterSlider(container, {
                    showCredits: true,
                    autoSlide: false
                });
                
                this.sliders.push(slider);
                container.style.display = index === 0 ? 'block' : 'none';
            });

            // Create navigation
            if (this.options.showNavigation && this.sliders.length > 1) {
                this.createNavigation();
            }

            // Create thumbnails
            if (this.options.showThumbnails && this.sliders.length > 1) {
                this.createThumbnails();
            }

            // Create counter
            if (this.options.showCounter && this.sliders.length > 1) {
                this.createCounter();
            }
        }

        createNavigation() {
            const nav = document.createElement('div');
            nav.className = 'gallery-navigation';
            nav.innerHTML = `
                <button class="nav-btn prev-btn" aria-label="السابق">‹</button>
                <button class="nav-btn next-btn" aria-label="التالي">›</button>
            `;
            
            this.container.appendChild(nav);
            
            nav.querySelector('.prev-btn').addEventListener('click', () => this.previousSlide());
            nav.querySelector('.next-btn').addEventListener('click', () => this.nextSlide());
        }

        createThumbnails() {
            const thumbs = document.createElement('div');
            thumbs.className = 'gallery-thumbnails';
            
            this.sliders.forEach((slider, index) => {
                const thumb = document.createElement('div');
                thumb.className = `thumbnail ${index === 0 ? 'active' : ''}`;
                thumb.innerHTML = `<span>${index + 1}</span>`;
                thumb.addEventListener('click', () => this.goToSlide(index));
                thumbs.appendChild(thumb);
            });
            
            this.container.appendChild(thumbs);
        }

        createCounter() {
            const counter = document.createElement('div');
            counter.className = 'gallery-counter';
            counter.textContent = `1 / ${this.sliders.length}`;
            this.container.appendChild(counter);
        }

        bindEvents() {
            // Keyboard navigation
            this.container.addEventListener('keydown', (e) => {
                switch (e.key) {
                    case 'ArrowLeft':
                        this.previousSlide();
                        break;
                    case 'ArrowRight':
                        this.nextSlide();
                        break;
                }
            });

            // Auto-play controls
            this.container.addEventListener('mouseenter', () => this.stopAutoPlay());
            this.container.addEventListener('mouseleave', () => {
                if (this.options.autoPlay) {
                    this.startAutoPlay();
                }
            });
        }

        goToSlide(index) {
            if (index === this.currentIndex || index < 0 || index >= this.sliders.length) return;

            // Hide current slide
            const currentSlider = this.sliders[this.currentIndex].container;
            currentSlider.style.display = 'none';

            // Show new slide
            const newSlider = this.sliders[index].container;
            newSlider.style.display = 'block';

            // Update thumbnails
            const thumbs = this.container.querySelectorAll('.thumbnail');
            thumbs[this.currentIndex]?.classList.remove('active');
            thumbs[index]?.classList.add('active');

            // Update counter
            const counter = this.container.querySelector('.gallery-counter');
            if (counter) {
                counter.textContent = `${index + 1} / ${this.sliders.length}`;
            }

            this.currentIndex = index;
        }

        nextSlide() {
            const nextIndex = (this.currentIndex + 1) % this.sliders.length;
            this.goToSlide(nextIndex);
        }

        previousSlide() {
            const prevIndex = this.currentIndex === 0 ? this.sliders.length - 1 : this.currentIndex - 1;
            this.goToSlide(prevIndex);
        }

        startAutoPlay() {
            this.stopAutoPlay();
            this.autoPlayTimer = setInterval(() => {
                this.nextSlide();
            }, this.options.autoPlayInterval);
        }

        stopAutoPlay() {
            if (this.autoPlayTimer) {
                clearInterval(this.autoPlayTimer);
                this.autoPlayTimer = null;
            }
        }
    }

    // ===== AUTO INITIALIZATION =====
    const BeforeAfterController = {
        init() {
            this.addStyles();
            this.initializeSliders();
            this.initializeGalleries();
            
            console.log('🖼️ Before/After sliders initialized');
        },

        initializeSliders() {
            // Initialize individual sliders
            document.querySelectorAll('.before-after:not(.gallery .before-after)').forEach(container => {
                new BeforeAfterSlider(container);
            });
        },

        initializeGalleries() {
            // Initialize galleries
            document.querySelectorAll('.before-after-gallery-container').forEach(container => {
                new BeforeAfterGallery(container);
            });
        },

        addStyles() {
            if (document.querySelector('#before-after-styles')) return;

            const style = document.createElement('style');
            style.id = 'before-after-styles';
            style.textContent = `
                .before-after-container {
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
                    background: #f3f4f6;
                }

                .before-after-handle:hover {
                    transform: translateY(-50%) scale(1.1);
                    box-shadow: 0 6px 20px rgba(0,0,0,0.4);
                }

                .gallery-navigation {
                    position: absolute;
                    top: 50%;
                    left: 0;
                    right: 0;
                    display: flex;
                    justify-content: space-between;
                    padding: 0 20px;
                    pointer-events: none;
                    z-index: 10;
                }

                .nav-btn {
                    width: 50px;
                    height: 50px;
                    border-radius: 50%;
                    background: rgba(255,255,255,0.9);
                    border: none;
                    font-size: 24px;
                    cursor: pointer;
                    pointer-events: auto;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                }

                .nav-btn:hover {
                    background: white;
                    transform: scale(1.1);
                }

                .gallery-thumbnails {
                    display: flex;
                    justify-content: center;
                    gap: 10px;
                    padding: 20px;
                }

                .thumbnail {
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    background: #e5e7eb;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    font-weight: bold;
                }

                .thumbnail:hover,
                .thumbnail.active {
                    background: #3b82f6;
                    color: white;
                    transform: scale(1.1);
                }

                .gallery-counter {
                    position: absolute;
                    bottom: 20px;
                    left: 50%;
                    transform: translateX(-50%);
                    background: rgba(0,0,0,0.7);
                    color: white;
                    padding: 8px 16px;
                    border-radius: 20px;
                    font-size: 14px;
                    font-weight: bold;
                    z-index: 10;
                }

                @media (max-width: 768px) {
                    .nav-btn {
                        width: 40px;
                        height: 40px;
                        font-size: 20px;
                    }
                    
                    .gallery-navigation {
                        padding: 0 10px;
                    }
                    
                    .thumbnail {
                        width: 30px;
                        height: 30px;
                        font-size: 12px;
                    }
                }
            `;
            
            document.head.appendChild(style);
        }
    };

    // ===== EXPORT TO GLOBAL =====
    window.DamamBeforeAfter = {
        BeforeAfterSlider,
        BeforeAfterGallery,
        BeforeAfterController
    };

    // Auto-initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => BeforeAfterController.init());
    } else {
        BeforeAfterController.init();
    }

})();