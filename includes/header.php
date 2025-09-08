<?php
/**
 * ملف الهيدر - شركة الدمام للعوازل والترميم
 * Header File - Al-Dammam Insulation & Renovation
 */

// تضمين ملفات الإعدادات والدوال
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

// الحصول على الصفحة الحالية
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- العنوان والوصف -->
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : DEFAULT_META_TITLE; ?></title>
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : DEFAULT_META_DESCRIPTION; ?>">
    <meta name="keywords" content="<?php echo SITE_KEYWORDS; ?>">
    <meta name="author" content="<?php echo SITE_NAME; ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo SITE_URL . $_SERVER['REQUEST_URI']; ?>">
    
    <!-- Open Graph Tags للشبكات الاجتماعية -->
    <meta property="og:title" content="<?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : DEFAULT_META_TITLE; ?>">
    <meta property="og:description" content="<?php echo isset($page_description) ? $page_description : DEFAULT_META_DESCRIPTION; ?>">
    <meta property="og:image" content="<?php echo isset($page_image) ? $page_image : DEFAULT_OG_IMAGE; ?>">
    <meta property="og:url" content="<?php echo SITE_URL . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ar_SA">
    <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
    
    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : DEFAULT_META_TITLE; ?>">
    <meta name="twitter:description" content="<?php echo isset($page_description) ? $page_description : DEFAULT_META_DESCRIPTION; ?>">
    <meta name="twitter:image" content="<?php echo isset($page_image) ? $page_image : DEFAULT_OG_IMAGE; ?>">
    
    <!-- Favicon وأيقونات الهاتف المحمول -->
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon-16x16.png">
    
    <!-- PWA Manifest -->
    <?php if (PWA_ENABLED): ?>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="<?php echo PWA_THEME_COLOR; ?>">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="<?php echo PWA_SHORT_NAME; ?>">
    <?php endif; ?>
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="/assets/css/main.rtl.css?v=<?php echo date('YmdHi'); ?>">
    
    <!-- خطوط جوجل -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Structured Data - Schema.org -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "<?php echo SITE_NAME; ?>",
        "alternateName": "<?php echo SITE_NAME_EN; ?>",
        "description": "<?php echo SITE_DESCRIPTION; ?>",
        "url": "<?php echo SITE_URL; ?>",
        "telephone": "<?php echo COMPANY_PHONE; ?>",
        "email": "<?php echo COMPANY_EMAIL; ?>",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "الدمام",
            "addressRegion": "المنطقة الشرقية",
            "addressCountry": "SA"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "26.4282",
            "longitude": "50.1020"
        },
        "sameAs": [
            "https://www.facebook.com/aldammam.insulation",
            "https://www.instagram.com/aldammam.insulation",
            "https://twitter.com/aldammam_ins"
        ],
        "serviceArea": {
            "@type": "State",
            "name": "المنطقة الشرقية"
        },
        "priceRange": "$$",
        "openingHours": "Mo-Sa 08:00-17:00"
    }
    </script>
</head>
<body class="<?php echo $current_page; ?>-page">
    
    <!-- أيقونة التحميل -->
    <div id="loading-spinner" class="loading-spinner">
        <div class="spinner"></div>
        <p>جاري التحميل...</p>
    </div>
    
    <!-- Skip to main content للوصولية -->
    <a href="#main-content" class="skip-to-content">الانتقال إلى المحتوى الرئيسي</a>
    
    <!-- الشريط العلوي -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="contact-info">
                    <a href="tel:<?php echo COMPANY_PHONE; ?>" class="contact-item" aria-label="اتصل بنا">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span><?php echo COMPANY_PHONE; ?></span>
                    </a>
                    <a href="mailto:<?php echo COMPANY_EMAIL; ?>" class="contact-item" aria-label="راسلنا">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span><?php echo COMPANY_EMAIL; ?></span>
                    </a>
                </div>
                
                <div class="top-bar-actions">
                    <!-- زر الواتساب -->
                    <a href="https://wa.me/<?php echo str_replace(['+', ' '], '', COMPANY_WHATSAPP); ?>" 
                       class="whatsapp-btn" target="_blank" rel="noopener" aria-label="تواصل معنا عبر الواتساب">
                        <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.520-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.56-.01-.188 0-.494.074-.753.372-.259.297-.988.967-.988 2.357 0 1.39 1.012 2.734 1.151 2.931.14.198 1.97 3.007 4.77 4.215.667.287 1.188.459 1.594.587.67.213 1.281.183 1.763.111.538-.081 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                        واتساب
                    </a>
                    
                    <!-- زر الوضع المظلم -->
                    <button id="darkModeToggle" class="dark-mode-toggle" aria-label="تبديل الوضع المظلم">
                        <svg class="icon sun" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="5"/>
                            <path d="m12 1v6m0 6v6m11-7h-6m-6 0H1m15.5-10.5l-4.24 4.24M9.17 14.83L4.93 19.07M19.07 4.93l-4.24 4.24M14.83 9.17l4.24-4.24"/>
                        </svg>
                        <svg class="icon moon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- الهيدر الرئيسي -->
    <header class="main-header" id="mainHeader">
        <div class="container">
            <div class="header-content">
                <!-- الشعار -->
                <div class="logo">
                    <a href="/" aria-label="<?php echo SITE_NAME; ?> - العودة للرئيسية">
                        <img src="/assets/images/logo.svg" alt="<?php echo SITE_NAME; ?>" class="logo-image">
                        <div class="logo-text">
                            <h1 class="logo-title"><?php echo SITE_NAME; ?></h1>
                            <p class="logo-subtitle">الجودة والتميز في العزل والترميم</p>
                        </div>
                    </a>
                </div>
                
                <!-- القائمة الرئيسية -->
                <nav class="main-navigation" role="navigation" aria-label="القائمة الرئيسية">
                    <ul class="nav-menu" id="navMenu">
                        <li class="nav-item">
                            <a href="/" class="nav-link <?php echo $current_page == 'index' ? 'active' : ''; ?>">الرئيسية</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" aria-expanded="false">خدماتنا</a>
                            <ul class="dropdown-menu">
                                <li><a href="/services/insulation" class="dropdown-link">العزل الحراري والمائي</a></li>
                                <li><a href="/services/renovation" class="dropdown-link">الترميم والصيانة</a></li>
                                <li><a href="/services/waterproofing" class="dropdown-link">عزل الخزانات</a></li>
                                <li><a href="/services/roofing" class="dropdown-link">عزل الأسطح</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/gallery" class="nav-link <?php echo $current_page == 'gallery' ? 'active' : ''; ?>">معرض الأعمال</a>
                        </li>
                        <li class="nav-item">
                            <a href="/about" class="nav-link <?php echo $current_page == 'about' ? 'active' : ''; ?>">من نحن</a>
                        </li>
                        <li class="nav-item">
                            <a href="/contact" class="nav-link <?php echo $current_page == 'contact' ? 'active' : ''; ?>">اتصل بنا</a>
                        </li>
                    </ul>
                </nav>
                
                <!-- زر الطلب السريع -->
                <div class="header-actions">
                    <a href="#contact-form" class="cta-button" id="quickRequestBtn">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        طلب عرض سعر
                    </a>
                </div>
                
                <!-- زر القائمة للهواتف المحمولة -->
                <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="فتح القائمة" aria-expanded="false">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>
        </div>
        
        <!-- خلفية القائمة المحمولة -->
        <div class="mobile-overlay" id="mobileOverlay"></div>
    </header>
    
    <!-- بداية المحتوى الرئيسي -->
    <main id="main-content" class="main-content">