<?php
/**
 * الصفحة الرئيسية - شركة الدمام للعوازل والترميم
 * Homepage - Al-Dammam Insulation & Renovation
 */

// تعيين معلومات الصفحة
$page_title = 'الصفحة الرئيسية';
$page_description = 'شركة الدمام للعوازل والترميم - الرائدة في مجال العزل الحراري والمائي وأعمال الترميم بأعلى معايير الجودة في المنطقة الشرقية';
$page_scripts = [
    '/assets/js/beforeAfter.js',
    '/assets/js/animations.js'
];

// تضمين الهيدر
include 'includes/header.php';
?>

<!-- Hero Section - قسم البطل -->
<section class="hero-section" id="hero">
    <div class="hero-background">
        <div class="hero-overlay"></div>
        <video class="hero-video" autoplay muted loop poster="/assets/images/hero-poster.jpg">
            <source src="/assets/images/hero-video.mp4" type="video/mp4">
        </video>
    </div>
    
    <div class="container">
        <div class="hero-content">
            <div class="hero-text" data-animate="fade-in">
                <h1 class="hero-title">
                    <span class="highlight">الدمام</span> للعوازل والترميم
                </h1>
                <p class="hero-subtitle">
                    خبرة تزيد عن <strong>15 عاماً</strong> في مجال العزل الحراري والمائي وأعمال الترميم
                </p>
                <p class="hero-description">
                    نقدم حلولاً متكاملة وعالية الجودة لجميع احتياجات العزل والترميم بأحدث التقنيات وأفضل المواد
                </p>
                
                <div class="hero-actions">
                    <a href="#contact-form" class="btn btn-primary btn-lg">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        احصل على عرض سعر مجاني
                    </a>
                    <a href="tel:<?php echo COMPANY_PHONE; ?>" class="btn btn-outline btn-lg">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        اتصل بنا الآن
                    </a>
                </div>
                
                <!-- إحصائيات سريعة -->
                <div class="hero-stats" data-animate="slide-right" data-delay="300">
                    <div class="stat-item">
                        <span class="stat-number" data-count="500">0</span>
                        <span class="stat-label">مشروع منجز</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" data-count="15">0</span>
                        <span class="stat-label">سنة خبرة</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" data-count="100">0</span>
                        <span class="stat-label">% رضا العملاء</span>
                    </div>
                </div>
            </div>
            
            <!-- صورة البطل -->
            <div class="hero-image" data-animate="slide-left" data-delay="200">
                <div class="hero-image-container">
                    <img src="/assets/images/hero-main.jpg" alt="خدمات العزل والترميم" class="hero-img">
                    
                    <!-- شارات الجودة -->
                    <div class="quality-badges">
                        <div class="badge" data-animate="bounce" data-delay="1000">
                            <svg class="badge-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>ضمان شامل</span>
                        </div>
                        <div class="badge" data-animate="bounce" data-delay="1200">
                            <svg class="badge-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span>سرعة في التنفيذ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- مؤشر التمرير -->
    <div class="scroll-indicator animate-bounce">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

<!-- Services Section - قسم الخدمات -->
<section class="services-section section" id="services">
    <div class="container">
        <div class="section-header text-center" data-animate="fade-in">
            <span class="section-tag">خدماتنا المتميزة</span>
            <h2 class="section-title">حلول شاملة لجميع احتياجات العزل والترميم</h2>
            <p class="section-description">
                نقدم مجموعة واسعة من الخدمات المتخصصة في العزل والترميم بأحدث التقنيات وأفضل المواد
            </p>
        </div>
        
        <div class="services-grid">
            <!-- خدمة العزل الحراري -->
            <div class="service-card" data-animate="fade-in" data-delay="100">
                <div class="service-icon">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="service-title">العزل الحراري</h3>
                <p class="service-description">
                    نظم عزل حراري متطورة لتوفير الطاقة وضمان الراحة الحرارية المثلى في جميع الأوقات
                </p>
                <ul class="service-features">
                    <li>عزل الجدران الخارجية</li>
                    <li>عزل الأسقف والأسطح</li>
                    <li>عزل الأرضيات</li>
                    <li>استخدام مواد صديقة للبيئة</li>
                </ul>
                <a href="/services/thermal-insulation" class="service-link">
                    اطلب الخدمة
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            </div>
            
            <!-- خدمة العزل المائي -->
            <div class="service-card" data-animate="fade-in" data-delay="200">
                <div class="service-icon">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
                <h3 class="service-title">العزل المائي</h3>
                <p class="service-description">
                    حماية مثالية ضد تسربات المياه والرطوبة باستخدام أحدث تقنيات العزل المائي
                </p>
                <ul class="service-features">
                    <li>عزل الخزانات الأرضية</li>
                    <li>عزل دورات المياه</li>
                    <li>عزل البدرومات</li>
                    <li>معالجة التسربات</li>
                </ul>
                <a href="/services/waterproofing" class="service-link">
                    اطلب الخدمة
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            </div>
            
            <!-- خدمة الترميم -->
            <div class="service-card" data-animate="fade-in" data-delay="300">
                <div class="service-icon">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="service-title">الترميم والصيانة</h3>
                <p class="service-description">
                    خدمات ترميم شاملة لإعادة تأهيل المباني والمنشآت وضمان استمراريتها
                </p>
                <ul class="service-features">
                    <li>ترميم المباني القديمة</li>
                    <li>إصلاح التشققات</li>
                    <li>تقوية الهياكل</li>
                    <li>الصيانة الدورية</li>
                </ul>
                <a href="/services/renovation" class="service-link">
                    اطلب الخدمة
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            </div>
            
            <!-- خدمة عزل الأسطح -->
            <div class="service-card" data-animate="fade-in" data-delay="400">
                <div class="service-icon">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 12-4.4-4.4a1.7 1.7 0 00-2.4 0l-4.6 4.6a1.7 1.7 0 01-2.4 0L3 8"/>
                    </svg>
                </div>
                <h3 class="service-title">عزل الأسطح</h3>
                <p class="service-description">
                    حلول متخصصة لعزل الأسطح ضد الحرارة والمياه لضمان الحماية الكاملة
                </p>
                <ul class="service-features">
                    <li>عزل الأسطح المسطحة</li>
                    <li>عزل الأسطح المائلة</li>
                    <li>تركيب أنظمة التصريف</li>
                    <li>العزل بالرش</li>
                </ul>
                <a href="/services/roof-insulation" class="service-link">
                    اطلب الخدمة
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- زر عرض جميع الخدمات -->
        <div class="text-center mt-8" data-animate="fade-in" data-delay="500">
            <a href="/services" class="btn btn-secondary btn-lg">
                عرض جميع خدماتنا
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Before/After Gallery - معرض قبل وبعد -->
<section class="before-after-section section" id="gallery">
    <div class="container">
        <div class="section-header text-center" data-animate="fade-in">
            <span class="section-tag">أعمالنا المميزة</span>
            <h2 class="section-title">شاهد التحول الذي نحققه</h2>
            <p class="section-description">
                مجموعة من مشاريعنا المنجزة التي تظهر جودة عملنا وتميز خدماتنا
            </p>
        </div>
        
        <div class="before-after-slider" id="beforeAfterSlider">
            <!-- مشروع 1 -->
            <div class="before-after-item" data-animate="fade-in" data-delay="100">
                <div class="before-after-container">
                    <div class="before-image">
                        <img src="/assets/images/before-1.jpg" alt="قبل العزل">
                        <div class="image-label before">قبل</div>
                    </div>
                    <div class="after-image">
                        <img src="/assets/images/after-1.jpg" alt="بعد العزل">
                        <div class="image-label after">بعد</div>
                    </div>
                    <div class="slider-handle">
                        <div class="slider-button">⟷</div>
                    </div>
                </div>
                <div class="project-info">
                    <h3 class="project-title">عزل مائي لخزان أرضي</h3>
                    <p class="project-description">مشروع عزل مائي متكامل لخزان مياه أرضي بمساحة 50 متر مربع</p>
                    <div class="project-details">
                        <span class="project-location">الدمام - حي الفيصلية</span>
                        <span class="project-duration">مدة التنفيذ: 3 أيام</span>
                    </div>
                </div>
            </div>
            
            <!-- مشروع 2 -->
            <div class="before-after-item" data-animate="fade-in" data-delay="200">
                <div class="before-after-container">
                    <div class="before-image">
                        <img src="/assets/images/before-2.jpg" alt="قبل العزل الحراري">
                        <div class="image-label before">قبل</div>
                    </div>
                    <div class="after-image">
                        <img src="/assets/images/after-2.jpg" alt="بعد العزل الحراري">
                        <div class="image-label after">بعد</div>
                    </div>
                    <div class="slider-handle">
                        <div class="slider-button">⟷</div>
                    </div>
                </div>
                <div class="project-info">
                    <h3 class="project-title">عزل حراري للسطح</h3>
                    <p class="project-description">تركيب نظام عزل حراري متطور لسطح فيلا سكنية</p>
                    <div class="project-details">
                        <span class="project-location">الخبر - حي العليا</span>
                        <span class="project-duration">مدة التنفيذ: 5 أيام</span>
                    </div>
                </div>
            </div>
            
            <!-- مشروع 3 -->
            <div class="before-after-item" data-animate="fade-in" data-delay="300">
                <div class="before-after-container">
                    <div class="before-image">
                        <img src="/assets/images/before-3.jpg" alt="قبل الترميم">
                        <div class="image-label before">قبل</div>
                    </div>
                    <div class="after-image">
                        <img src="/assets/images/after-3.jpg" alt="بعد الترميم">
                        <div class="image-label after">بعد</div>
                    </div>
                    <div class="slider-handle">
                        <div class="slider-button">⟷</div>
                    </div>
                </div>
                <div class="project-info">
                    <h3 class="project-title">ترميم واجهة مبنى</h3>
                    <p class="project-description">إعادة تأهيل كاملة لواجهة مبنى تجاري وحمايتها من العوامل الجوية</p>
                    <div class="project-details">
                        <span class="project-location">الدمام - الكورنيش</span>
                        <span class="project-duration">مدة التنفيذ: 10 أيام</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- أزرار التنقل -->
        <div class="slider-controls">
            <button class="slider-btn prev-btn" id="prevBtn">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button class="slider-btn next-btn" id="nextBtn">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
        
        <!-- مؤشرات الصور -->
        <div class="slider-indicators">
            <button class="indicator active" data-slide="0"></button>
            <button class="indicator" data-slide="1"></button>
            <button class="indicator" data-slide="2"></button>
        </div>
        
        <!-- زر عرض جميع الأعمال -->
        <div class="text-center mt-8" data-animate="fade-in" data-delay="400">
            <a href="/gallery" class="btn btn-primary btn-lg">
                شاهد جميع أعمالنا
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Statistics Section - قسم الإحصائيات -->
<section class="statistics-section">
    <div class="container">
        <div class="statistics-grid">
            <div class="stat-card" data-animate="fade-in" data-delay="100">
                <div class="stat-icon">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div class="stat-number" data-count="500">0</div>
                <div class="stat-label">مشروع مكتمل</div>
                <div class="stat-description">تم إنجازها بأعلى معايير الجودة</div>
            </div>
            
            <div class="stat-card" data-animate="fade-in" data-delay="200">
                <div class="stat-icon">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="stat-number" data-count="300">0</div>
                <div class="stat-label">عميل راضٍ</div>
                <div class="stat-description">يثقون في خدماتنا المتميزة</div>
            </div>
            
            <div class="stat-card" data-animate="fade-in" data-delay="300">
                <div class="stat-icon">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-number" data-count="15">0</div>
                <div class="stat-label">سنة خبرة</div>
                <div class="stat-description">في مجال العزل والترميم</div>
            </div>
            
            <div class="stat-card" data-animate="fade-in" data-delay="400">
                <div class="stat-icon">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-number" data-count="100">0</div>
                <div class="stat-label">% ضمان الجودة</div>
                <div class="stat-description">على جميع أعمالنا</div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section - آراء العملاء -->
<section class="testimonials-section section" id="testimonials">
    <div class="container">
        <div class="section-header text-center" data-animate="fade-in">
            <span class="section-tag">آراء عملائنا</span>
            <h2 class="section-title">ماذا يقول عملاؤنا عن خدماتنا</h2>
            <p class="section-description">
                نفخر بثقة عملائنا ورضاهم التام عن جودة خدماتنا المقدمة
            </p>
        </div>
        
        <div class="testimonials-slider" id="testimonialsSlider">
            <!-- شهادة 1 -->
            <div class="testimonial-card" data-animate="fade-in" data-delay="100">
                <div class="testimonial-content">
                    <div class="testimonial-rating">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <blockquote class="testimonial-text">
                        "خدمة ممتازة وتنفيذ احترافي. تم عزل خزان المياه في المنزل بطريقة مثالية وانتهت مشكلة التسربات نهائياً. أنصح بالتعامل معهم."
                    </blockquote>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="/assets/images/client-1.jpg" alt="أحمد المطيري">
                        </div>
                        <div class="author-info">
                            <h4 class="author-name">أحمد المطيري</h4>
                            <p class="author-location">الدمام - حي الشاطئ</p>
                            <span class="testimonial-date">منذ شهرين</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- شهادة 2 -->
            <div class="testimonial-card" data-animate="fade-in" data-delay="200">
                <div class="testimonial-content">
                    <div class="testimonial-rating">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <blockquote class="testimonial-text">
                        "فريق محترف جداً ومواعيد دقيقة. العزل الحراري للسطح خفض فاتورة الكهرباء بشكل ملحوظ. شكراً لكم على الخدمة المميزة."
                    </blockquote>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="/assets/images/client-2.jpg" alt="سارة العتيبي">
                        </div>
                        <div class="author-info">
                            <h4 class="author-name">سارة العتيبي</h4>
                            <p class="author-location">الخبر - حي العليا</p>
                            <span class="testimonial-date">منذ 3 أسابيع</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- شهادة 3 -->
            <div class="testimonial-card" data-animate="fade-in" data-delay="300">
                <div class="testimonial-content">
                    <div class="testimonial-rating">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <blockquote class="testimonial-text">
                        "تعاملت معهم في مشروع ترميم المبنى التجاري. النتيجة فاقت التوقعات والأسعار معقولة جداً. أكيد سأتعامل معهم مرة أخرى."
                    </blockquote>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="/assets/images/client-3.jpg" alt="محمد الزهراني">
                        </div>
                        <div class="author-info">
                            <h4 class="author-name">محمد الزهراني</h4>
                            <p class="author-location">الدمام - حي الفردوس</p>
                            <span class="testimonial-date">منذ أسبوعين</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section - قسم الاتصال -->
<section class="contact-section section" id="contact-form">
    <div class="container">
        <div class="contact-content">
            <!-- معلومات الاتصال -->
            <div class="contact-info" data-animate="slide-right">
                <div class="contact-header">
                    <h2 class="contact-title">تواصل معنا</h2>
                    <p class="contact-description">
                        احصل على استشارة مجانية وعرض سعر مخصص لمشروعك
                    </p>
                </div>
                
                <div class="contact-methods">
                    <div class="contact-method">
                        <div class="method-icon">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div class="method-content">
                            <h4 class="method-title">اتصل بنا</h4>
                            <p class="method-value"><?php echo COMPANY_PHONE; ?></p>
                            <span class="method-note">متاح 24/7</span>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <div class="method-icon">
                            <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.56-.01-.188 0-.494.074-.753.372-.259.297-.988.967-.988 2.357 0 1.39 1.012 2.734 1.151 2.931.14.198 1.97 3.007 4.77 4.215.667.287 1.188.459 1.594.587.67.213 1.281.183 1.763.111.538-.081 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                        </div>
                        <div class="method-content">
                            <h4 class="method-title">واتساب</h4>
                            <p class="method-value"><?php echo COMPANY_WHATSAPP; ?></p>
                            <span class="method-note">استجابة سريعة</span>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <div class="method-icon">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="method-content">
                            <h4 class="method-title">البريد الإلكتروني</h4>
                            <p class="method-value"><?php echo COMPANY_EMAIL; ?></p>
                            <span class="method-note">للاستفسارات التفصيلية</span>
                        </div>
                    </div>
                </div>
                
                <!-- خريطة الموقع -->
                <div class="location-map">
                    <h4 class="map-title">موقعنا</h4>
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3578.8201999359427!2d50.10204537600258!3d26.428171989089387!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e49e4a2c6c6de31%3A0x7b8e1dd6b6b6b6b6!2sDammam%2C%20Saudi%20Arabia!5e0!3m2!1sen!2sus!4v1647875256789!5m2!1sen!2sus" 
                            width="100%" 
                            height="250" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
            
            <!-- نموذج الاتصال -->
            <div class="contact-form-container" data-animate="slide-left">
                <div class="form-header">
                    <h3 class="form-title">احصل على عرض سعر مجاني</h3>
                    <p class="form-description">أرسل لنا تفاصيل مشروعك وسنقوم بالرد عليك في أقل من 24 ساعة</p>
                </div>
                
                <form class="contact-form" id="mainContactForm" data-validate action="/api/contact" method="POST">
                    <!-- حماية CSRF -->
                    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="client-name" class="form-label">الاسم الكامل *</label>
                            <input type="text" id="client-name" name="name" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="client-phone" class="form-label">رقم الهاتف *</label>
                            <input type="tel" id="client-phone" name="phone" class="form-input" data-validate="phone" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="client-email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" id="client-email" name="email" class="form-input" data-validate="email">
                        </div>
                        
                        <div class="form-group">
                            <label for="service-type" class="form-label">نوع الخدمة *</label>
                            <select id="service-type" name="service" class="form-select" required>
                                <option value="">اختر نوع الخدمة</option>
                                <option value="thermal-insulation">العزل الحراري</option>
                                <option value="waterproofing">العزل المائي</option>
                                <option value="renovation">الترميم والصيانة</option>
                                <option value="roof-insulation">عزل الأسطح</option>
                                <option value="other">خدمة أخرى</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="project-area" class="form-label">المساحة (متر مربع)</label>
                        <input type="number" id="project-area" name="area" class="form-input" placeholder="مثال: 100">
                    </div>
                    
                    <div class="form-group">
                        <label for="project-location" class="form-label">موقع المشروع</label>
                        <input type="text" id="project-location" name="location" class="form-input" placeholder="مثال: الدمام - حي الشاطئ">
                    </div>
                    
                    <div class="form-group">
                        <label for="project-details" class="form-label">تفاصيل المشروع *</label>
                        <textarea id="project-details" name="details" class="form-textarea" rows="4" 
                                  placeholder="اكتب تفاصيل مشروعك ومتطلباتك..." required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="agree_terms" required>
                            <span class="checkmark"></span>
                            أوافق على <a href="/privacy-policy" target="_blank">شروط الخدمة وسياسة الخصوصية</a>
                        </label>
                    </div>
                    
                    <button type="submit" class="form-submit-btn">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        إرسال الطلب
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
// تضمين الفوتر
include 'includes/footer.php';
?>