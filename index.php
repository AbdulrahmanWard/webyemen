<?php
// Page configuration
$page_title = 'الدمام للعوازل والترميم - شركة رائدة في العزل والترميم';
$page_description = 'شركة الدمام للعوازل والترميم تقدم خدمات متميزة في العزل الحراري والمائي وأعمال الترميم بأعلى معايير الجودة والمهنية في المملكة العربية السعودية منذ أكثر من 15 عاماً';
$body_class = 'homepage';

// Include header
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section" data-animate="fade-up">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title" data-animate="fade-up" data-animate-delay="200">
                الدمام للعوازل والترميم
            </h1>
            <p class="hero-subtitle" data-animate="fade-up" data-animate-delay="400">
                نحن الخيار الأمثل لخدمات العزل الحراري والمائي وأعمال الترميم في المملكة العربية السعودية
            </p>
            <div class="hero-buttons" data-animate="fade-up" data-animate-delay="600">
                <a href="quote.php" class="btn btn-primary">
                    <span>احصل على عرض سعر مجاني</span>
                    <span>💰</span>
                </a>
                <a href="#services" class="btn btn-secondary">
                    <span>تصفح خدماتنا</span>
                    <span>🔍</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section" id="features">
    <div class="container">
        <div class="section-header" data-animate="fade-up">
            <h2 class="section-title">لماذا تختار الدمام للعوازل؟</h2>
            <p class="section-subtitle">نقدم خدمات متميزة بأعلى معايير الجودة والاحترافية</p>
        </div>
        
        <div class="grid grid-cols-4">
            <div class="card" data-animate="fade-up" data-animate-delay="100">
                <div class="card-icon">🏆</div>
                <h3 class="card-title">خبرة +15 عاماً</h3>
                <p class="card-description">خبرة واسعة في مجال العزل والترميم مع سجل حافل من المشاريع الناجحة</p>
            </div>
            
            <div class="card" data-animate="fade-up" data-animate-delay="200">
                <div class="card-icon">✅</div>
                <h3 class="card-title">ضمان الجودة</h3>
                <p class="card-description">نستخدم أفضل المواد وأحدث التقنيات مع ضمان شامل على جميع أعمالنا</p>
            </div>
            
            <div class="card" data-animate="fade-up" data-animate-delay="300">
                <div class="card-icon">👷‍♂️</div>
                <h3 class="card-title">فريق محترف</h3>
                <p class="card-description">فريق من المهندسين والفنيين المتخصصين والمدربين على أعلى مستوى</p>
            </div>
            
            <div class="card" data-animate="fade-up" data-animate-delay="400">
                <div class="card-icon">💯</div>
                <h3 class="card-title">أسعار تنافسية</h3>
                <p class="card-description">نقدم أفضل الأسعار في السوق مع جودة عالية وخدمة متميزة</p>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="section" id="services" style="background: var(--bg-secondary);">
    <div class="container">
        <div class="section-header" data-animate="fade-up">
            <h2 class="section-title">خدماتنا المتخصصة</h2>
            <p class="section-subtitle">نوفر حلول شاملة لجميع احتياجات العزل والترميم</p>
        </div>
        
        <div class="grid grid-cols-3">
            <div class="card service-card" data-animate="fade-up" data-animate-delay="100">
                <div class="card-icon">🏠</div>
                <h3 class="card-title">العزل الحراري</h3>
                <p class="card-description">عزل حراري متطور للمباني السكنية والتجارية لتوفير الطاقة وتحسين الراحة</p>
                <ul class="service-features">
                    <li>عزل الأسطح والجدران</li>
                    <li>مواد عزل عالية الجودة</li>
                    <li>توفير في فواتير الكهرباء</li>
                    <li>حماية من العوامل الجوية</li>
                </ul>
                <a href="services/thermal-insulation.php" class="service-link">تفاصيل أكثر ←</a>
            </div>
            
            <div class="card service-card" data-animate="fade-up" data-animate-delay="200">
                <div class="card-icon">💧</div>
                <h3 class="card-title">العزل المائي</h3>
                <p class="card-description">حماية شاملة من تسربات المياه والرطوبة باستخدام أحدث تقنيات العزل المائي</p>
                <ul class="service-features">
                    <li>عزل الخزانات والحمامات</li>
                    <li>معالجة التسربات</li>
                    <li>عزل الأساسات</li>
                    <li>حماية من الرطوبة</li>
                </ul>
                <a href="services/water-insulation.php" class="service-link">تفاصيل أكثر ←</a>
            </div>
            
            <div class="card service-card" data-animate="fade-up" data-animate-delay="300">
                <div class="card-icon">🔨</div>
                <h3 class="card-title">أعمال الترميم</h3>
                <p class="card-description">خدمات ترميم شاملة لإعادة تأهيل المباني القديمة وتحديثها وفق أحدث المعايير</p>
                <ul class="service-features">
                    <li>ترميم المباني السكنية</li>
                    <li>تحديث المرافق</li>
                    <li>إصلاح التشققات</li>
                    <li>صيانة دورية</li>
                </ul>
                <a href="services/renovation.php" class="service-link">تفاصيل أكثر ←</a>
            </div>
        </div>
    </div>
</section>

<!-- Before/After Section -->
<section class="section" id="projects">
    <div class="container">
        <div class="section-header" data-animate="fade-up">
            <h2 class="section-title">مشاريعنا المميزة</h2>
            <p class="section-subtitle">شاهد التحول الذي نحققه في مشاريعنا - قبل وبعد</p>
        </div>
        
        <div class="before-after-gallery-container" data-animate="fade-up" data-animate-delay="200">
            <!-- Project 1 -->
            <div class="before-after-item">
                <div class="before-after">
                    <img class="before-image" src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800" alt="مبنى قبل العزل الحراري" loading="lazy">
                    <img class="after-image" src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800" alt="مبنى بعد العزل الحراري" loading="lazy">
                </div>
            </div>
            
            <!-- Project 2 -->
            <div class="before-after-item">
                <div class="before-after">
                    <img class="before-image" src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800" alt="سطح قبل العزل المائي" loading="lazy">
                    <img class="after-image" src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=800" alt="سطح بعد العزل المائي" loading="lazy">
                </div>
            </div>
            
            <!-- Project 3 -->
            <div class="before-after-item">
                <div class="before-after">
                    <img class="before-image" src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800" alt="مطبخ قبل الترميم" loading="lazy">
                    <img class="after-image" src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800" alt="مطبخ بعد الترميم" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="section" style="background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-dark)); color: white;">
    <div class="container">
        <div class="grid grid-cols-4">
            <div class="text-center" data-animate="fade-up" data-animate-delay="100">
                <div class="stat-number" style="font-size: 3rem; font-weight: bold; margin-bottom: 0.5rem;">500+</div>
                <div class="stat-label">مشروع مكتمل</div>
            </div>
            
            <div class="text-center" data-animate="fade-up" data-animate-delay="200">
                <div class="stat-number" style="font-size: 3rem; font-weight: bold; margin-bottom: 0.5rem;">15+</div>
                <div class="stat-label">سنة خبرة</div>
            </div>
            
            <div class="text-center" data-animate="fade-up" data-animate-delay="300">
                <div class="stat-number" style="font-size: 3rem; font-weight: bold; margin-bottom: 0.5rem;">98%</div>
                <div class="stat-label">رضا العملاء</div>
            </div>
            
            <div class="text-center" data-animate="fade-up" data-animate-delay="400">
                <div class="stat-number" style="font-size: 3rem; font-weight: bold; margin-bottom: 0.5rem;">24/7</div>
                <div class="stat-label">خدمة عملاء</div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="section" id="testimonials">
    <div class="container">
        <div class="section-header" data-animate="fade-up">
            <h2 class="section-title">آراء عملائنا</h2>
            <p class="section-subtitle">نفخر بثقة عملائنا وتقييماتهم المتميزة لخدماتنا</p>
        </div>
        
        <div class="grid grid-cols-3">
            <div class="card testimonial-card" data-animate="fade-up" data-animate-delay="100">
                <div class="testimonial-content">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p>"خدمة ممتازة وجودة عالية في العزل المائي. تم حل مشكلة التسربات نهائياً والفريق محترف جداً."</p>
                </div>
                <div class="testimonial-author">
                    <strong>أحمد المالكي</strong>
                    <span>مالك منزل - الدمام</span>
                </div>
            </div>
            
            <div class="card testimonial-card" data-animate="fade-up" data-animate-delay="200">
                <div class="testimonial-content">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p>"العزل الحراري الذي قاموا به وفر لنا الكثير في فاتورة الكهرباء. أنصح بهم بشدة."</p>
                </div>
                <div class="testimonial-author">
                    <strong>فاطمة السعيد</strong>
                    <span>صاحبة فيلا - الخبر</span>
                </div>
            </div>
            
            <div class="card testimonial-card" data-animate="fade-up" data-animate-delay="300">
                <div class="testimonial-content">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p>"ترميم رائع للمنزل القديم. أصبح المنزل كالجديد تماماً. شكراً للفريق المتميز."</p>
                </div>
                <div class="testimonial-author">
                    <strong>محمد العتيبي</strong>
                    <span>مهندس - القطيف</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="section" id="contact" style="background: var(--bg-secondary);">
    <div class="container">
        <div class="section-header" data-animate="fade-up">
            <h2 class="section-title">تواصل معنا الآن</h2>
            <p class="section-subtitle">احصل على استشارة مجانية وعرض سعر مخصص لمشروعك</p>
        </div>
        
        <div class="grid grid-cols-2" style="gap: var(--space-12);">
            <!-- Contact Form -->
            <div data-animate="fade-right">
                <form class="contact-form" data-enhance="true" data-track-analytics="true" data-name="contact-form">
                    <div class="form-group">
                        <label for="name">الاسم الكامل *</label>
                        <input type="text" id="name" name="name" required data-validate="name" placeholder="أدخل اسمك الكامل">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">رقم الهاتف *</label>
                        <input type="tel" id="phone" name="phone" required data-validate="saudiPhone" placeholder="05xxxxxxxx">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">البريد الإلكتروني</label>
                        <input type="email" id="email" name="email" data-validate="email" placeholder="example@domain.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="service">نوع الخدمة المطلوبة *</label>
                        <select id="service" name="service" required>
                            <option value="">اختر نوع الخدمة</option>
                            <option value="thermal">العزل الحراري</option>
                            <option value="water">العزل المائي</option>
                            <option value="renovation">أعمال الترميم</option>
                            <option value="consultation">استشارة هندسية</option>
                            <option value="maintenance">صيانة دورية</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">تفاصيل المشروع *</label>
                        <textarea id="message" name="message" required rows="5" maxlength="500" data-auto-resize placeholder="اشرح لنا تفاصيل مشروعك واحتياجاتك"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <span>إرسال الطلب</span>
                        <span>📧</span>
                    </button>
                </form>
            </div>
            
            <!-- Contact Info -->
            <div data-animate="fade-left">
                <div class="contact-info-card">
                    <h3 style="margin-bottom: var(--space-6);">معلومات التواصل</h3>
                    
                    <div class="contact-item" style="margin-bottom: var(--space-4);">
                        <div class="contact-icon">📍</div>
                        <div>
                            <strong>العنوان:</strong>
                            <p>شارع الملك عبدالعزيز، الدمام<br>المنطقة الشرقية، المملكة العربية السعودية</p>
                        </div>
                    </div>
                    
                    <div class="contact-item" style="margin-bottom: var(--space-4);">
                        <div class="contact-icon">📞</div>
                        <div>
                            <strong>الهاتف:</strong>
                            <p><a href="tel:+966130000000">+966-13-000-0000</a></p>
                            <p><a href="tel:+966501234567">+966-50-123-4567</a></p>
                        </div>
                    </div>
                    
                    <div class="contact-item" style="margin-bottom: var(--space-4);">
                        <div class="contact-icon">⏰</div>
                        <div>
                            <strong>ساعات العمل:</strong>
                            <p>السبت - الخميس: 8:00 ص - 6:00 م<br>الجمعة: مغلق</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">✉️</div>
                        <div>
                            <strong>البريد الإلكتروني:</strong>
                            <p><a href="mailto:info@dammam-insulation.com">info@dammam-insulation.com</a></p>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Features -->
                <div class="quick-features" style="margin-top: var(--space-8);">
                    <div class="feature-item">
                        <span class="feature-icon">🚀</span>
                        <span>استجابة سريعة خلال ساعات</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">💯</span>
                        <span>استشارة مجانية</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">🎯</span>
                        <span>عرض سعر مخصص</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Additional Page Scripts -->
<?php
$additional_scripts = [
    'assets/js/homepage.js'
];
?>

<style>
/* Additional Homepage Styles */
.service-features {
    list-style: none;
    padding: 0;
    margin: var(--space-4) 0;
}

.service-features li {
    padding: var(--space-2) 0;
    border-bottom: 1px solid var(--border-light);
    font-size: var(--font-size-sm);
    color: var(--text-secondary);
}

.service-features li:before {
    content: "✓";
    color: var(--accent-green);
    font-weight: bold;
    margin-left: var(--space-2);
}

.service-link {
    display: inline-block;
    margin-top: var(--space-4);
    color: var(--primary-blue);
    font-weight: var(--font-weight-semibold);
    text-decoration: none;
}

.service-link:hover {
    color: var(--primary-blue-dark);
}

.testimonial-card {
    text-align: center;
}

.stars {
    font-size: 1.2rem;
    margin-bottom: var(--space-3);
}

.testimonial-content {
    margin-bottom: var(--space-4);
}

.testimonial-author strong {
    display: block;
    margin-bottom: var(--space-1);
}

.testimonial-author span {
    font-size: var(--font-size-sm);
    color: var(--text-muted);
}

.contact-form {
    background: var(--white);
    padding: var(--space-8);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
}

.form-group {
    margin-bottom: var(--space-6);
}

.form-group label {
    display: block;
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--space-2);
    color: var(--text-primary);
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: var(--space-3);
    border: 2px solid var(--border-light);
    border-radius: var(--radius-lg);
    font-size: var(--font-size-base);
    transition: border-color var(--transition-fast);
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.contact-info-card {
    background: var(--white);
    padding: var(--space-8);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
}

.contact-item {
    display: flex;
    gap: var(--space-4);
    align-items: flex-start;
}

.contact-icon {
    font-size: var(--font-size-xl);
    flex-shrink: 0;
}

.quick-features {
    display: flex;
    flex-direction: column;
    gap: var(--space-3);
}

.feature-item {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-3);
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
}

.feature-icon {
    font-size: var(--font-size-lg);
}

.text-center {
    text-align: center;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .contact-form,
    .contact-info-card {
        padding: var(--space-6);
    }
    
    .quick-features {
        margin-top: var(--space-6);
    }
}
</style>

<?php
// Include footer
include 'includes/footer.php';
?>