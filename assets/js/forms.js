/**
 * Enhanced Forms for Dammam Insulation & Renovation
 * Handles form validation, submission, and user interactions
 */

(function() {
    'use strict';

    // ===== FORM UTILITIES =====
    const FormUtils = {
        // Validation patterns
        patterns: {
            email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            phone: /^[\+]?[0-9\-\(\)\s]{10,}$/,
            saudiPhone: /^(\+966|966|0)?[5][0-9]{8}$/,
            name: /^[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF\uFB50-\uFDFF\uFE70-\uFEFFa-zA-Z\s]{2,50}$/,
            postalCode: /^[0-9]{5}$/
        },

        // Error messages in Arabic
        messages: {
            required: 'هذا الحقل مطلوب',
            email: 'يرجى إدخال بريد إلكتروني صحيح',
            phone: 'يرجى إدخال رقم هاتف صحيح',
            saudiPhone: 'يرجى إدخال رقم هاتف سعودي صحيح',
            name: 'يرجى إدخال اسم صحيح (حروف عربية أو إنجليزية فقط)',
            minLength: 'يجب أن يكون النص أكثر من {min} أحرف',
            maxLength: 'يجب أن يكون النص أقل من {max} حرف',
            postalCode: 'يرجى إدخال رمز بريدي صحيح (5 أرقام)',
            match: 'الحقلان غير متطابقان',
            file: 'يرجى اختيار ملف صحيح',
            fileSize: 'حجم الملف كبير جداً (الحد الأقصى {maxSize})',
            fileType: 'نوع الملف غير مدعوم'
        },

        // Get form data as object
        getFormData(form) {
            const formData = new FormData(form);
            const data = {};
            
            for (let [key, value] of formData.entries()) {
                if (data[key]) {
                    // Handle multiple values (checkboxes, etc.)
                    if (Array.isArray(data[key])) {
                        data[key].push(value);
                    } else {
                        data[key] = [data[key], value];
                    }
                } else {
                    data[key] = value;
                }
            }
            
            return data;
        },

        // Sanitize input
        sanitize(input) {
            const div = document.createElement('div');
            div.textContent = input;
            return div.innerHTML;
        },

        // Show loading state
        showLoading(button, loadingText = 'جاري الإرسال...') {
            const originalText = button.textContent;
            button.dataset.originalText = originalText;
            button.textContent = loadingText;
            button.disabled = true;
            button.classList.add('loading');
        },

        // Hide loading state
        hideLoading(button) {
            const originalText = button.dataset.originalText;
            button.textContent = originalText;
            button.disabled = false;
            button.classList.remove('loading');
        },

        // Show success message
        showSuccess(form, message = 'تم الإرسال بنجاح!') {
            this.showMessage(form, message, 'success');
        },

        // Show error message
        showError(form, message = 'حدث خطأ. يرجى المحاولة مرة أخرى.') {
            this.showMessage(form, message, 'error');
        },

        // Show message
        showMessage(form, message, type) {
            // Remove existing messages
            const existingMessage = form.querySelector('.form-message');
            if (existingMessage) {
                existingMessage.remove();
            }

            // Create new message
            const messageEl = document.createElement('div');
            messageEl.className = `form-message form-message-${type}`;
            messageEl.textContent = message;
            messageEl.setAttribute('role', 'alert');
            messageEl.setAttribute('aria-live', 'polite');

            // Insert message
            const firstField = form.querySelector('.form-group, .form-field');
            if (firstField) {
                form.insertBefore(messageEl, firstField);
            } else {
                form.appendChild(messageEl);
            }

            // Auto-hide after 5 seconds
            setTimeout(() => {
                if (messageEl && messageEl.parentNode) {
                    messageEl.remove();
                }
            }, 5000);

            // Announce to screen readers
            if (window.announceToScreenReader) {
                window.announceToScreenReader(message);
            }
        }
    };

    // ===== FORM VALIDATOR =====
    const FormValidator = {
        validate(field) {
            const value = field.value.trim();
            const rules = this.parseRules(field);
            const errors = [];

            // Required validation
            if (rules.required && !value) {
                errors.push(FormUtils.messages.required);
            }

            // Skip other validations if field is empty and not required
            if (!value && !rules.required) {
                return { isValid: true, errors: [] };
            }

            // Pattern validations
            if (rules.pattern && !FormUtils.patterns[rules.pattern].test(value)) {
                errors.push(FormUtils.messages[rules.pattern] || 'تنسيق غير صحيح');
            }

            // Length validations
            if (rules.minLength && value.length < rules.minLength) {
                errors.push(FormUtils.messages.minLength.replace('{min}', rules.minLength));
            }

            if (rules.maxLength && value.length > rules.maxLength) {
                errors.push(FormUtils.messages.maxLength.replace('{max}', rules.maxLength));
            }

            // Match validation (for password confirmation, etc.)
            if (rules.match) {
                const matchField = document.querySelector(rules.match);
                if (matchField && value !== matchField.value) {
                    errors.push(FormUtils.messages.match);
                }
            }

            // File validations
            if (field.type === 'file' && field.files.length > 0) {
                const fileErrors = this.validateFile(field, rules);
                errors.push(...fileErrors);
            }

            return {
                isValid: errors.length === 0,
                errors: errors
            };
        },

        parseRules(field) {
            const rules = {};
            
            // HTML5 attributes
            if (field.hasAttribute('required')) rules.required = true;
            if (field.hasAttribute('minlength')) rules.minLength = parseInt(field.getAttribute('minlength'));
            if (field.hasAttribute('maxlength')) rules.maxLength = parseInt(field.getAttribute('maxlength'));
            if (field.hasAttribute('pattern')) rules.customPattern = field.getAttribute('pattern');
            
            // Data attributes
            if (field.dataset.validate) rules.pattern = field.dataset.validate;
            if (field.dataset.match) rules.match = field.dataset.match;
            if (field.dataset.minLength) rules.minLength = parseInt(field.dataset.minLength);
            if (field.dataset.maxLength) rules.maxLength = parseInt(field.dataset.maxLength);
            
            // File attributes
            if (field.dataset.maxSize) rules.maxSize = parseInt(field.dataset.maxSize);
            if (field.dataset.allowedTypes) rules.allowedTypes = field.dataset.allowedTypes.split(',');

            return rules;
        },

        validateFile(field, rules) {
            const errors = [];
            const file = field.files[0];

            // File size validation
            if (rules.maxSize && file.size > rules.maxSize) {
                const maxSizeMB = Math.round(rules.maxSize / 1024 / 1024);
                errors.push(FormUtils.messages.fileSize.replace('{maxSize}', `${maxSizeMB}MB`));
            }

            // File type validation
            if (rules.allowedTypes) {
                const fileType = file.type;
                const fileName = file.name;
                const fileExtension = fileName.split('.').pop().toLowerCase();
                
                const isValidType = rules.allowedTypes.some(type => {
                    return fileType.includes(type) || type.includes(fileExtension);
                });

                if (!isValidType) {
                    errors.push(FormUtils.messages.fileType);
                }
            }

            return errors;
        },

        showFieldError(field, errors) {
            this.clearFieldError(field);

            if (errors.length > 0) {
                field.classList.add('error', 'invalid');
                field.setAttribute('aria-invalid', 'true');

                // Create error message
                const errorEl = document.createElement('div');
                errorEl.className = 'field-error';
                errorEl.textContent = errors[0]; // Show first error
                errorEl.setAttribute('role', 'alert');
                errorEl.id = `${field.name || field.id}-error`;

                // Link error to field
                field.setAttribute('aria-describedby', errorEl.id);

                // Insert error message
                const fieldGroup = field.closest('.form-group, .form-field');
                if (fieldGroup) {
                    fieldGroup.appendChild(errorEl);
                } else {
                    field.parentNode.insertBefore(errorEl, field.nextSibling);
                }
            }
        },

        clearFieldError(field) {
            field.classList.remove('error', 'invalid');
            field.classList.add('valid');
            field.setAttribute('aria-invalid', 'false');

            // Remove error message
            const errorId = field.getAttribute('aria-describedby');
            if (errorId) {
                const errorEl = document.getElementById(errorId);
                if (errorEl) {
                    errorEl.remove();
                }
                field.removeAttribute('aria-describedby');
            }

            // Remove error from field group
            const fieldGroup = field.closest('.form-group, .form-field');
            if (fieldGroup) {
                const error = fieldGroup.querySelector('.field-error');
                if (error) {
                    error.remove();
                }
            }
        },

        validateForm(form) {
            const fields = form.querySelectorAll('input, textarea, select');
            let isFormValid = true;
            const errors = {};

            fields.forEach(field => {
                const validation = this.validate(field);
                
                if (!validation.isValid) {
                    isFormValid = false;
                    errors[field.name || field.id] = validation.errors;
                    this.showFieldError(field, validation.errors);
                } else {
                    this.clearFieldError(field);
                }
            });

            return { isValid: isFormValid, errors: errors };
        }
    };

    // ===== FORM ENHANCER =====
    const FormEnhancer = {
        init() {
            this.setupRealTimeValidation();
            this.setupFileUploads();
            this.setupFormSubmission();
            this.setupFieldEnhancements();
            this.setupFormAnalytics();
        },

        setupRealTimeValidation() {
            document.addEventListener('input', (e) => {
                if (e.target.matches('input, textarea, select')) {
                    this.handleFieldInput(e.target);
                }
            });

            document.addEventListener('blur', (e) => {
                if (e.target.matches('input, textarea, select')) {
                    this.handleFieldBlur(e.target);
                }
            }, true);
        },

        handleFieldInput(field) {
            // Clear previous errors on input
            FormValidator.clearFieldError(field);
            
            // Add typing indicator
            field.classList.add('typing');
            
            // Debounced validation
            clearTimeout(field.validationTimeout);
            field.validationTimeout = setTimeout(() => {
                field.classList.remove('typing');
                this.validateField(field);
            }, 800);
        },

        handleFieldBlur(field) {
            field.classList.remove('typing');
            clearTimeout(field.validationTimeout);
            this.validateField(field);
        },

        validateField(field) {
            const validation = FormValidator.validate(field);
            
            if (!validation.isValid) {
                FormValidator.showFieldError(field, validation.errors);
            } else {
                FormValidator.clearFieldError(field);
            }
        },

        setupFileUploads() {
            document.querySelectorAll('input[type="file"]').forEach(input => {
                this.enhanceFileInput(input);
            });
        },

        enhanceFileInput(input) {
            // Create custom file upload UI
            const wrapper = document.createElement('div');
            wrapper.className = 'file-upload-wrapper';
            
            const dropZone = document.createElement('div');
            dropZone.className = 'file-drop-zone';
            dropZone.innerHTML = `
                <div class="drop-zone-content">
                    <div class="drop-zone-icon">📄</div>
                    <div class="drop-zone-text">
                        <strong>اسحب الملفات هنا</strong> أو 
                        <button type="button" class="browse-button">تصفح الملفات</button>
                    </div>
                    <div class="drop-zone-info">
                        الحد الأقصى: ${input.dataset.maxSize ? Math.round(input.dataset.maxSize / 1024 / 1024) + 'MB' : '10MB'}
                    </div>
                </div>
                <div class="file-preview"></div>
            `;

            // Insert wrapper
            input.parentNode.insertBefore(wrapper, input);
            wrapper.appendChild(input);
            wrapper.appendChild(dropZone);

            // Hide original input
            input.style.display = 'none';

            // Setup events
            const browseButton = dropZone.querySelector('.browse-button');
            const preview = dropZone.querySelector('.file-preview');

            browseButton.addEventListener('click', () => input.click());

            // Drag and drop
            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('drag-over');
            });

            dropZone.addEventListener('dragleave', () => {
                dropZone.classList.remove('drag-over');
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('drag-over');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    input.files = files;
                    this.showFilePreview(input, preview);
                }
            });

            // File selection
            input.addEventListener('change', () => {
                this.showFilePreview(input, preview);
            });
        },

        showFilePreview(input, preview) {
            const files = Array.from(input.files);
            
            if (files.length === 0) {
                preview.innerHTML = '';
                return;
            }

            preview.innerHTML = files.map(file => {
                const size = this.formatFileSize(file.size);
                const isImage = file.type.startsWith('image/');
                
                return `
                    <div class="file-item">
                        <div class="file-icon">${isImage ? '🖼️' : '📄'}</div>
                        <div class="file-info">
                            <div class="file-name">${file.name}</div>
                            <div class="file-size">${size}</div>
                        </div>
                        <button type="button" class="remove-file" data-file="${file.name}">×</button>
                    </div>
                `;
            }).join('');

            // Setup remove buttons
            preview.querySelectorAll('.remove-file').forEach(button => {
                button.addEventListener('click', () => {
                    input.value = '';
                    preview.innerHTML = '';
                });
            });
        },

        formatFileSize(bytes) {
            if (bytes === 0) return '0 بايت';
            
            const k = 1024;
            const sizes = ['بايت', 'كيلوبايت', 'ميجابايت', 'جيجابايت'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        },

        setupFormSubmission() {
            document.addEventListener('submit', (e) => {
                if (e.target.matches('form[data-enhance]')) {
                    e.preventDefault();
                    this.handleFormSubmit(e.target);
                }
            });
        },

        async handleFormSubmit(form) {
            const submitButton = form.querySelector('[type="submit"]');
            
            // Validate form
            const validation = FormValidator.validateForm(form);
            if (!validation.isValid) {
                FormUtils.showError(form, 'يرجى تصحيح الأخطاء أدناه');
                return;
            }

            try {
                // Show loading
                FormUtils.showLoading(submitButton);

                // Get form data
                const formData = new FormData(form);
                
                // Submit form
                const response = await this.submitForm(form.action || '#', formData, form.method || 'POST');
                
                if (response.success) {
                    FormUtils.showSuccess(form, response.message || 'تم الإرسال بنجاح!');
                    form.reset();
                    
                    // Clear file previews
                    form.querySelectorAll('.file-preview').forEach(preview => {
                        preview.innerHTML = '';
                    });
                    
                    // Track success
                    this.trackFormSuccess(form);
                } else {
                    FormUtils.showError(form, response.message || 'حدث خطأ. يرجى المحاولة مرة أخرى.');
                }
            } catch (error) {
                console.error('Form submission error:', error);
                FormUtils.showError(form, 'حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.');
            } finally {
                FormUtils.hideLoading(submitButton);
            }
        },

        async submitForm(action, formData, method) {
            // Simulate form submission - replace with actual API call
            if (action === '#') {
                // Demo mode
                return new Promise((resolve) => {
                    setTimeout(() => {
                        resolve({
                            success: true,
                            message: 'تم استلام رسالتك بنجاح. سنتواصل معك قريباً!'
                        });
                    }, 2000);
                });
            }

            // Real form submission
            const response = await fetch(action, {
                method: method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            return await response.json();
        },

        setupFieldEnhancements() {
            // Auto-format phone numbers
            document.querySelectorAll('input[type="tel"], input[data-validate="phone"], input[data-validate="saudiPhone"]').forEach(input => {
                input.addEventListener('input', (e) => {
                    let value = e.target.value.replace(/\D/g, '');
                    
                    // Format Saudi phone numbers
                    if (input.dataset.validate === 'saudiPhone') {
                        if (value.startsWith('966')) {
                            value = '+966 ' + value.slice(3, 5) + ' ' + value.slice(5, 8) + ' ' + value.slice(8, 12);
                        } else if (value.startsWith('05')) {
                            value = value.slice(0, 3) + ' ' + value.slice(3, 6) + ' ' + value.slice(6, 10);
                        }
                    }
                    
                    e.target.value = value;
                });
            });

            // Character counter for textareas
            document.querySelectorAll('textarea[maxlength]').forEach(textarea => {
                this.addCharacterCounter(textarea);
            });

            // Auto-resize textareas
            document.querySelectorAll('textarea[data-auto-resize]').forEach(textarea => {
                this.setupAutoResize(textarea);
            });
        },

        addCharacterCounter(textarea) {
            const maxLength = parseInt(textarea.getAttribute('maxlength'));
            
            const counter = document.createElement('div');
            counter.className = 'character-counter';
            counter.textContent = `0 / ${maxLength}`;
            
            textarea.parentNode.appendChild(counter);
            
            textarea.addEventListener('input', () => {
                const current = textarea.value.length;
                counter.textContent = `${current} / ${maxLength}`;
                
                if (current > maxLength * 0.9) {
                    counter.classList.add('warning');
                } else {
                    counter.classList.remove('warning');
                }
            });
        },

        setupAutoResize(textarea) {
            const resize = () => {
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            };
            
            textarea.addEventListener('input', resize);
            textarea.addEventListener('change', resize);
            
            // Initial resize
            setTimeout(resize, 0);
        },

        setupFormAnalytics() {
            // Track form interactions
            document.addEventListener('focus', (e) => {
                if (e.target.matches('input, textarea, select')) {
                    this.trackFieldFocus(e.target);
                }
            }, true);

            // Track form abandonment
            window.addEventListener('beforeunload', () => {
                this.trackFormAbandonment();
            });
        },

        trackFieldFocus(field) {
            const form = field.closest('form');
            if (form && form.dataset.trackAnalytics) {
                // Send analytics event
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'form_field_focus', {
                        form_name: form.dataset.name || 'unknown',
                        field_name: field.name || field.id
                    });
                }
            }
        },

        trackFormSuccess(form) {
            if (form.dataset.trackAnalytics) {
                // Send analytics event
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'form_submit_success', {
                        form_name: form.dataset.name || 'unknown'
                    });
                }
            }
        },

        trackFormAbandonment() {
            const activeForms = document.querySelectorAll('form[data-track-analytics]');
            
            activeForms.forEach(form => {
                const fields = form.querySelectorAll('input, textarea, select');
                const filledFields = Array.from(fields).filter(field => field.value.trim() !== '');
                
                if (filledFields.length > 0) {
                    // Form has data but wasn't submitted
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'form_abandonment', {
                            form_name: form.dataset.name || 'unknown',
                            filled_fields: filledFields.length,
                            total_fields: fields.length
                        });
                    }
                }
            });
        }
    };

    // ===== NEWSLETTER FORM =====
    const NewsletterForm = {
        init() {
            const newsletterForms = document.querySelectorAll('.newsletter-form');
            newsletterForms.forEach(form => this.setupNewsletterForm(form));
        },

        setupNewsletterForm(form) {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const emailInput = form.querySelector('input[type="email"]');
                const submitButton = form.querySelector('button[type="submit"]');
                
                if (!emailInput.value.trim()) {
                    FormUtils.showError(form, 'يرجى إدخال بريدك الإلكتروني');
                    return;
                }

                if (!FormUtils.patterns.email.test(emailInput.value)) {
                    FormUtils.showError(form, 'يرجى إدخال بريد إلكتروني صحيح');
                    return;
                }

                try {
                    FormUtils.showLoading(submitButton, 'جاري الاشتراك...');
                    
                    // Simulate API call
                    await new Promise(resolve => setTimeout(resolve, 1500));
                    
                    FormUtils.showSuccess(form, 'تم اشتراكك بنجاح في نشرتنا الإخبارية!');
                    emailInput.value = '';
                    
                } catch (error) {
                    FormUtils.showError(form, 'حدث خطأ أثناء الاشتراك. يرجى المحاولة مرة أخرى.');
                } finally {
                    FormUtils.hideLoading(submitButton);
                }
            });
        }
    };

    // ===== INITIALIZATION =====
    const FormsController = {
        init() {
            try {
                FormEnhancer.init();
                NewsletterForm.init();
                
                // Add form styles
                this.addFormStyles();
                
                console.log('📝 Enhanced forms initialized');
            } catch (error) {
                console.error('❌ Error initializing forms:', error);
            }
        },

        addFormStyles() {
            if (document.querySelector('#form-enhancement-styles')) return;
            
            const style = document.createElement('style');
            style.id = 'form-enhancement-styles';
            style.textContent = `
                /* Form Enhancement Styles */
                .form-message {
                    padding: 1rem;
                    margin-bottom: 1.5rem;
                    border-radius: 0.5rem;
                    font-weight: 500;
                }
                
                .form-message-success {
                    background: #d1fae5;
                    color: #065f46;
                    border: 1px solid #a7f3d0;
                }
                
                .form-message-error {
                    background: #fee2e2;
                    color: #991b1b;
                    border: 1px solid #fca5a5;
                }
                
                .field-error {
                    color: #dc2626;
                    font-size: 0.875rem;
                    margin-top: 0.25rem;
                }
                
                input.error,
                textarea.error,
                select.error {
                    border-color: #dc2626 !important;
                    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
                }
                
                input.valid,
                textarea.valid,
                select.valid {
                    border-color: #10b981 !important;
                }
                
                input.typing,
                textarea.typing {
                    border-color: #3b82f6 !important;
                }
                
                .file-upload-wrapper {
                    position: relative;
                }
                
                .file-drop-zone {
                    border: 2px dashed #d1d5db;
                    border-radius: 0.75rem;
                    padding: 2rem;
                    text-align: center;
                    cursor: pointer;
                    transition: all 0.3s ease;
                }
                
                .file-drop-zone:hover,
                .file-drop-zone.drag-over {
                    border-color: #3b82f6;
                    background: #eff6ff;
                }
                
                .drop-zone-icon {
                    font-size: 3rem;
                    margin-bottom: 1rem;
                }
                
                .browse-button {
                    background: none;
                    border: none;
                    color: #3b82f6;
                    cursor: pointer;
                    text-decoration: underline;
                }
                
                .file-preview {
                    margin-top: 1rem;
                }
                
                .file-item {
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                    padding: 0.75rem;
                    background: #f9fafb;
                    border-radius: 0.5rem;
                    margin-bottom: 0.5rem;
                }
                
                .file-icon {
                    font-size: 1.5rem;
                }
                
                .file-info {
                    flex: 1;
                }
                
                .file-name {
                    font-weight: 500;
                    margin-bottom: 0.25rem;
                }
                
                .file-size {
                    font-size: 0.875rem;
                    color: #6b7280;
                }
                
                .remove-file {
                    background: #ef4444;
                    color: white;
                    border: none;
                    border-radius: 50%;
                    width: 24px;
                    height: 24px;
                    cursor: pointer;
                    font-size: 1rem;
                    line-height: 1;
                }
                
                .character-counter {
                    text-align: left;
                    font-size: 0.75rem;
                    color: #6b7280;
                    margin-top: 0.25rem;
                }
                
                .character-counter.warning {
                    color: #dc2626;
                }
                
                .loading {
                    opacity: 0.7;
                    cursor: not-allowed !important;
                }
                
                /* RTL Support */
                [dir="rtl"] .character-counter {
                    text-align: right;
                }
            `;
            
            document.head.appendChild(style);
        }
    };

    // ===== EXPORT TO GLOBAL =====
    window.DamamFormEnhancer = {
        FormUtils,
        FormValidator,
        FormEnhancer,
        NewsletterForm,
        FormsController
    };

    // Auto-initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => FormsController.init());
    } else {
        FormsController.init();
    }

})();