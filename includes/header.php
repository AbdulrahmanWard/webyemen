<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- SEO Meta Tags -->
    <title><?php echo isset($page_title) ? $page_title : 'الدمام للعوازل والترميم - خدمات العزل والترميم المتخصصة'; ?></title>
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'شركة الدمام للعوازل والترميم تقدم خدمات العزل الحراري والمائي وأعمال الترميم بأعلى معايير الجودة في المملكة العربية السعودية'; ?>">
    <meta name="keywords" content="العزل الحراري, العزل المائي, ترميم المباني, شركة عزل, الدمام, السعودية">
    <meta name="author" content="شركة الدمام للعوازل والترميم">
    
    <!-- Open Graph / Social Media -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo isset($page_title) ? $page_title : 'الدمام للعوازل والترميم'; ?>">
    <meta property="og:description" content="<?php echo isset($page_description) ? $page_description : 'خدمات العزل والترميم المتخصصة'; ?>">
    <meta property="og:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:site_name" content="الدمام للعوازل والترميم">
    
    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo isset($page_title) ? $page_title : 'الدمام للعوازل والترميم'; ?>">
    <meta name="twitter:description" content="<?php echo isset($page_description) ? $page_description : 'خدمات العزل والترميم المتخصصة'; ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/main.rtl.css">
    
    <!-- Google Fonts - Cairo for Arabic -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "شركة الدمام للعوازل والترميم",
        "image": "<?php echo 'https://' . $_SERVER['HTTP_HOST']; ?>/assets/images/logo.png",
        "description": "شركة متخصصة في خدمات العزل الحراري والمائي وأعمال الترميم",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "شارع الملك عبدالعزيز",
            "addressLocality": "الدمام",
            "addressRegion": "المنطقة الشرقية",
            "addressCountry": "SA"
        },
        "telephone": "+966-13-000-0000",
        "url": "<?php echo 'https://' . $_SERVER['HTTP_HOST']; ?>",
        "sameAs": [
            "https://www.facebook.com/dammam.insulation",
            "https://www.instagram.com/dammam.insulation",
            "https://twitter.com/dammam_insulation"
        ],
        "openingHours": "Mo-Sa 08:00-18:00",
        "priceRange": "$$"
    }
    </script>
</head>
<body class="<?php echo isset($body_class) ? $body_class : ''; ?>">
    
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="skip-link" aria-label="تخطي إلى المحتوى الرئيسي">تخطي إلى المحتوى الرئيسي</a>
    
    <!-- Header -->
    <header class="main-header" role="banner">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="container">
                <div class="top-bar-content">
                    <div class="contact-info">
                        <a href="tel:+966130000000" class="contact-item">
                            <span class="icon">📞</span>
                            <span>+966-13-000-0000</span>
                        </a>
                        <a href="mailto:info@dammam-insulation.com" class="contact-item">
                            <span class="icon">✉️</span>
                            <span>info@dammam-insulation.com</span>
                        </a>
                    </div>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="فيسبوك">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="إنستغرام">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="تويتر">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Navigation -->
        <nav class="main-nav" role="navigation">
            <div class="container">
                <div class="nav-content">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="index.php" class="logo-link" aria-label="الصفحة الرئيسية - الدمام للعوازل والترميم">
                            <img src="assets/images/logo.png" alt="شركة الدمام للعوازل والترميم" class="logo-img">
                            <div class="logo-text">
                                <h1 class="company-name">الدمام للعوازل والترميم</h1>
                                <p class="company-tagline">جودة وثقة منذ عقود</p>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Navigation Menu -->
                    <div class="nav-menu-wrapper">
                        <ul class="nav-menu" role="menubar">
                            <li class="nav-item" role="none">
                                <a href="index.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>" role="menuitem">الرئيسية</a>
                            </li>
                            <li class="nav-item has-dropdown" role="none">
                                <a href="#" class="nav-link" role="menuitem" aria-haspopup="true" aria-expanded="false">
                                    خدماتنا
                                    <span class="dropdown-icon">▼</span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li role="none"><a href="services/thermal-insulation.php" class="dropdown-link" role="menuitem">العزل الحراري</a></li>
                                    <li role="none"><a href="services/water-insulation.php" class="dropdown-link" role="menuitem">العزل المائي</a></li>
                                    <li role="none"><a href="services/renovation.php" class="dropdown-link" role="menuitem">أعمال الترميم</a></li>
                                    <li role="none"><a href="services/maintenance.php" class="dropdown-link" role="menuitem">الصيانة الدورية</a></li>
                                </ul>
                            </li>
                            <li class="nav-item" role="none">
                                <a href="projects.php" class="nav-link" role="menuitem">مشاريعنا</a>
                            </li>
                            <li class="nav-item" role="none">
                                <a href="about.php" class="nav-link" role="menuitem">من نحن</a>
                            </li>
                            <li class="nav-item" role="none">
                                <a href="contact.php" class="nav-link" role="menuitem">تواصل معنا</a>
                            </li>
                        </ul>
                        
                        <!-- CTA Button -->
                        <div class="nav-cta">
                            <a href="quote.php" class="cta-button" aria-label="احصل على عرض سعر مجاني">
                                <span>عرض سعر مجاني</span>
                                <span class="cta-icon">💰</span>
                            </a>
                        </div>
                        
                        <!-- Mobile Menu Toggle -->
                        <button class="mobile-menu-toggle" aria-label="فتح القائمة الرئيسية" aria-expanded="false">
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Dark Mode Toggle -->
        <button class="dark-mode-toggle" aria-label="تبديل الوضع المظلم" title="تبديل الوضع المظلم">
            <span class="toggle-icon light-icon">☀️</span>
            <span class="toggle-icon dark-icon">🌙</span>
        </button>
    </header>
    
    <!-- Main Content Area -->
    <main id="main-content" class="main-content" role="main">