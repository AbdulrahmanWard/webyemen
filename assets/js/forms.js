/**
 * ملف JavaScript للنماذج - شركة الدمام للعوازل والترميم
 * Forms JavaScript - Al-Dammam Insulation & Renovation
 * Version: 1.0
 */

(function() {
    'use strict';

    // ===============================
    // إعدادات النماذج - Form Settings
    // ===============================
    
    const formSettings = {
        validateOnBlur: true,
        validateOnInput: true,
        showSuccessMessage: true,
        autoFocus: true,
        submitTimeout: 30000, // 30 seconds
        retryAttempts: 3
    };

    // ===============================
    // قواعد التحقق - Validation Rules
    // ===============================
    
    const validationRules = {
        required: {
            test: (value) => value.trim().length > 0,
            message: 'هذا الحقل مطلوب'
        },
        
        email: {
            test: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
            message: 'يرجى إدخال بريد إلكتروني صحيح'
        },
        
        phone: {
            test: (value) => {
                // تنظيف رقم الهاتف
                const cleanPhone = value.replace(/[\s\-\(\)]/g, '');
                // أرقام الهاتف السعودية
                return /^(\+966|966|0)?[5][0-9]{8}$/.test(cleanPhone);
            },
            message: 'يرجى إدخال رقم هاتف سعودي صحيح (مثال: 0501234567)'
        },
        
        minLength: {
            test: (value, minLength) => value.trim().length >= minLength,
            message: (minLength) => `يجب أن يحتوي على ${minLength} أحرف على الأقل`
        },
        
        maxLength: {
            test: (value, maxLength) => value.trim().length <= maxLength,
            message: (maxLength) => `يجب ألا يتجاوز ${maxLength} حرف`
        },
        
        number: {
            test: (value) => !isNaN(value) && !isNaN(parseFloat(value)),
            message: 'يجب أن يكون رقماً صحيحاً'
        },
        
        min: {
            test: (value, min) => parseFloat(value) >= min,
            message: (min) => `يجب أن يكون ${min} أو أكثر`
        },
        
        max: {
            test: (value, max) => parseFloat(value) <= max,
            message: (max) => `يجب أن يكون ${max} أو أقل`
        },
        
        url: {
            test: (value) => {
                try {
                    new URL(value);
                    return true;
                } catch {
                    return /^https?:\/\/.+/.test(value);
                }
            },
            message: 'يرجى إدخال رابط صحيح'
        },
        
        match: {
            test: (value, matchFieldId) => {
                const matchField = document.getElementById(matchFieldId);
                return matchField ? value === matchField.value : false;
            },
            message: 'القيم غير متطابقة'
        }
    };

    // ===============================
    // فئة إدارة النماذج - Form Manager Class
    // ===============================
    
    class FormManager {
        constructor(form) {
            this.form = form;
            this.fields = new Map();
            this.isSubmitting = false;
            this.submitAttempts = 0;
            
            this.init();
        }

        init() {
            this.setupFields();
            this.attachEvents();
            this.setupRealTimeValidation();
        }

        setupFields() {
            const inputs = this.form.querySelectorAll('input, textarea, select');
            
            inputs.forEach(field => {
                const fieldConfig = {
                    element: field,
                    rules: this.parseValidationRules(field),
                    errorElement: null,
                    isValid: false,
                    value: field.value
                };
                
                this.fields.set(field.name || field.id, fieldConfig);
            });
        }

        parseValidationRules(field) {
            const rules = [];
            
            // Required validation
            if (field.hasAttribute('required')) {
                rules.push({ type: 'required' });
            }
            
            // Type-based validation
            const fieldType = field.type || field.getAttribute('data-validate');
            if (validationRules[fieldType]) {
                rules.push({ type: fieldType });
            }
            
            // Custom validation attributes
            if (field.hasAttribute('minlength')) {
                rules.push({ 
                    type: 'minLength', 
                    param: parseInt(field.getAttribute('minlength')) 
                });
            }
            
            if (field.hasAttribute('maxlength')) {
                rules.push({ 
                    type: 'maxLength', 
                    param: parseInt(field.getAttribute('maxlength')) 
                });
            }
            
            if (field.hasAttribute('min')) {
                rules.push({ 
                    type: 'min', 
                    param: parseFloat(field.getAttribute('min')) 
                });
            }
            
            if (field.hasAttribute('max')) {
                rules.push({ 
                    type: 'max', 
                    param: parseFloat(field.getAttribute('max')) 
                });
            }
            
            if (field.hasAttribute('data-match')) {
                rules.push({ 
                    type: 'match', 
                    param: field.getAttribute('data-match') 
                });
            }
            
            return rules;
        }

        attachEvents() {
            this.form.addEventListener('submit', (e) => this.handleSubmit(e));
            
            if (formSettings.validateOnBlur) {
                this.fields.forEach((config, fieldName) => {
                    config.element.addEventListener('blur', () => {
                        this.validateField(fieldName);
                    });
                });
            }
        }

        setupRealTimeValidation() {
            if (!formSettings.validateOnInput) return;
            
            this.fields.forEach((config, fieldName) => {
                const debounceDelay = config.element.type === 'email' ? 500 : 300;
                
                config.element.addEventListener('input', 
                    this.debounce(() => {
                        if (config.element.value.trim().length > 0) {
                            this.validateField(fieldName);
                        } else {
                            this.clearFieldError(fieldName);
                        }
                    }, debounceDelay)
                );
            });
        }

        validateField(fieldName) {
            const config = this.fields.get(fieldName);
            if (!config) return false;

            const value = config.element.value;
            let isValid = true;
            let errorMessage = '';

            // Run through all validation rules
            for (const rule of config.rules) {
                const validator = validationRules[rule.type];
                if (!validator) continue;

                const testResult = rule.param !== undefined 
                    ? validator.test(value, rule.param)
                    : validator.test(value);

                if (!testResult) {
                    isValid = false;
                    errorMessage = typeof validator.message === 'function'
                        ? validator.message(rule.param)
                        : validator.message;
                    break;
                }
            }

            config.isValid = isValid;
            this.displayFieldValidation(fieldName, isValid, errorMessage);
            
            return isValid;
        }

        displayFieldValidation(fieldName, isValid, message) {
            const config = this.fields.get(fieldName);
            const field = config.element;
            
            // Remove existing error styling
            field.classList.remove('error', 'success');
            
            // Remove existing error message
            if (config.errorElement) {
                config.errorElement.remove();
                config.errorElement = null;
            }

            if (!isValid && message) {
                // Add error styling
                field.classList.add('error');
                
                // Create error message element
                const errorElement = document.createElement('span');
                errorElement.className = 'field-error animate-slide-down';
                errorElement.textContent = message;
                
                // Insert error message
                const insertPosition = field.parentNode;
                insertPosition.appendChild(errorElement);
                
                config.errorElement = errorElement;
                
                // Add animation
                setTimeout(() => errorElement.classList.add('show'), 10);
                
            } else if (isValid && field.value.trim().length > 0) {
                // Add success styling
                field.classList.add('success');
            }
        }

        clearFieldError(fieldName) {
            const config = this.fields.get(fieldName);
            if (!config) return;

            config.element.classList.remove('error', 'success');
            
            if (config.errorElement) {
                config.errorElement.classList.remove('show');
                setTimeout(() => {
                    if (config.errorElement) {
                        config.errorElement.remove();
                        config.errorElement = null;
                    }
                }, 300);
            }
        }

        validateForm() {
            let isFormValid = true;
            const firstErrorField = null;

            this.fields.forEach((config, fieldName) => {
                const isFieldValid = this.validateField(fieldName);
                if (!isFieldValid) {
                    isFormValid = false;
                    if (!firstErrorField) {
                        firstErrorField = config.element;
                    }
                }
            });

            // Focus first error field
            if (!isFormValid && firstErrorField && formSettings.autoFocus) {
                firstErrorField.focus();
                firstErrorField.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
            }

            return isFormValid;
        }

        async handleSubmit(e) {
            e.preventDefault();
            
            if (this.isSubmitting) return;

            // Validate form
            if (!this.validateForm()) {
                this.showFormMessage('يرجى تصحيح الأخطاء المحددة أعلاه', 'error');
                return;
            }

            this.isSubmitting = true;
            this.showLoadingState();

            try {
                const formData = new FormData(this.form);
                const response = await this.submitFormData(formData);
                
                if (response.success) {
                    this.handleSuccessResponse(response);
                } else {
                    this.handleErrorResponse(response);
                }
                
            } catch (error) {
                console.error('Form submission error:', error);
                this.handleSubmissionError(error);
                
            } finally {
                this.isSubmitting = false;
                this.hideLoadingState();
            }
        }

        async submitFormData(formData) {
            const submitUrl = this.form.action || '/api/submit-form';
            const timeout = formSettings.submitTimeout;

            // Create abort controller for timeout
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), timeout);

            try {
                const response = await fetch(submitUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    signal: controller.signal
                });

                clearTimeout(timeoutId);

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return await response.json();
                } else {
                    return { success: true, message: 'تم إرسال النموذج بنجاح' };
                }

            } catch (error) {
                clearTimeout(timeoutId);
                
                if (error.name === 'AbortError') {
                    throw new Error('انتهت مهلة الإرسال. يرجى المحاولة مرة أخرى.');
                }
                
                throw error;
            }
        }

        handleSuccessResponse(response) {
            this.showFormMessage(
                response.message || 'تم إرسال طلبك بنجاح! سنتواصل معك قريباً.',
                'success'
            );
            
            if (formSettings.showSuccessMessage) {
                this.resetForm();
            }
            
            // Track successful submission
            if (window.AlDammamApp && window.AlDammamApp.trackEvent) {
                window.AlDammamApp.trackEvent('form_submit_success', {
                    form_id: this.form.id,
                    form_action: this.form.action
                });
            }
        }

        handleErrorResponse(response) {
            const message = response.message || 'حدث خطأ أثناء الإرسال. يرجى المحاولة مرة أخرى.';
            this.showFormMessage(message, 'error');
            
            // Handle field-specific errors
            if (response.errors) {
                Object.entries(response.errors).forEach(([fieldName, errorMessage]) => {
                    this.displayFieldValidation(fieldName, false, errorMessage);
                });
            }
        }

        handleSubmissionError(error) {
            this.submitAttempts++;
            
            let message = 'حدث خطأ في الاتصال. ';
            
            if (this.submitAttempts < formSettings.retryAttempts) {
                message += `سيتم المحاولة مرة أخرى (${this.submitAttempts}/${formSettings.retryAttempts})`;
                
                // Retry after delay
                setTimeout(() => {
                    this.handleSubmit(new Event('submit'));
                }, 2000 * this.submitAttempts);
                
            } else {
                message += 'يرجى المحاولة لاحقاً أو الاتصال بنا مباشرة.';
            }
            
            this.showFormMessage(message, 'error');
        }

        showFormMessage(message, type = 'info') {
            // Remove existing messages
            const existingMessages = this.form.querySelectorAll('.form-message');
            existingMessages.forEach(msg => msg.remove());

            // Create new message
            const messageElement = document.createElement('div');
            messageElement.className = `form-message form-message-${type} animate-slide-down`;
            messageElement.innerHTML = `
                <div class="message-content">
                    <span class="message-icon">
                        ${this.getMessageIcon(type)}
                    </span>
                    <span class="message-text">${message}</span>
                    <button class="message-close" onclick="this.parentElement.parentElement.remove()">×</button>
                </div>
            `;

            // Insert message at the top of the form
            this.form.insertBefore(messageElement, this.form.firstChild);

            // Show animation
            setTimeout(() => messageElement.classList.add('show'), 10);

            // Auto remove after delay (except for errors)
            if (type !== 'error') {
                setTimeout(() => {
                    if (messageElement.parentNode) {
                        messageElement.classList.remove('show');
                        setTimeout(() => messageElement.remove(), 300);
                    }
                }, 5000);
            }
        }

        getMessageIcon(type) {
            const icons = {
                success: '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                error: '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>',
                info: '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                warning: '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>'
            };
            return icons[type] || icons.info;
        }

        showLoadingState() {
            const submitBtn = this.form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('loading');
                
                const originalText = submitBtn.textContent;
                submitBtn.setAttribute('data-original-text', originalText);
                submitBtn.innerHTML = `
                    <span class="loading-spinner"></span>
                    جاري الإرسال...
                `;
            }
        }

        hideLoadingState() {
            const submitBtn = this.form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('loading');
                
                const originalText = submitBtn.getAttribute('data-original-text');
                if (originalText) {
                    submitBtn.textContent = originalText;
                }
            }
        }

        resetForm() {
            this.form.reset();
            this.submitAttempts = 0;
            
            // Clear all field errors and styling
            this.fields.forEach((config, fieldName) => {
                this.clearFieldError(fieldName);
                config.isValid = false;
            });
        }

        // Utility method
        debounce(func, wait, immediate) {
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
    }

    // ===============================
    // تهيئة النماذج - Form Initialization
    // ===============================
    
    function initForms() {
        const forms = document.querySelectorAll('form[data-validate]');
        const formManagers = [];

        forms.forEach(form => {
            const manager = new FormManager(form);
            formManagers.push(manager);
        });

        return formManagers;
    }

    // ===============================
    // تشغيل عند تحميل الصفحة - Initialize on DOM ready
    // ===============================
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initForms);
    } else {
        initForms();
    }

    // Export for external use
    window.FormManager = FormManager;
    window.formSettings = formSettings;

})();