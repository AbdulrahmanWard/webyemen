<?php
/**
 * ملف الإعدادات الأساسية - شركة الدمام للعوازل والترميم
 * Configuration File - Al-Dammam Insulation & Renovation
 */

// إعدادات قاعدة البيانات - Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'webyemen_db');

// إعدادات الموقع - Site Configuration
define('SITE_NAME', 'الدمام للعوازل والترميم');
define('SITE_NAME_EN', 'Al-Dammam Insulation & Renovation');
define('SITE_URL', 'https://www.aldammam-insulation.com');
define('SITE_DESCRIPTION', 'شركة متخصصة في أعمال العزل والترميم والصيانة بأعلى معايير الجودة');
define('SITE_KEYWORDS', 'عزل, ترميم, صيانة, مباني, الدمام, السعودية, insulation, renovation');

// معلومات الاتصال - Contact Information
define('COMPANY_PHONE', '+966 13 456 7890');
define('COMPANY_EMAIL', 'info@aldammam-insulation.com');
define('COMPANY_ADDRESS', 'الدمام، المملكة العربية السعودية');
define('COMPANY_WHATSAPP', '+966 50 123 4567');

// إعدادات الأمان - Security Settings
define('SECURITY_SALT', 'your_security_salt_here_' . date('Y'));
define('SESSION_TIMEOUT', 3600); // ساعة واحدة

// إعدادات السيو - SEO Settings
define('DEFAULT_META_TITLE', SITE_NAME . ' - ' . SITE_DESCRIPTION);
define('DEFAULT_META_DESCRIPTION', SITE_DESCRIPTION);
define('DEFAULT_OG_IMAGE', SITE_URL . '/assets/images/og-image.jpg');

// إعدادات الموضوع - Theme Settings
define('THEME_PRIMARY_COLOR', '#1e40af');
define('THEME_SECONDARY_COLOR', '#06b6d4');
define('THEME_ACCENT_COLOR', '#f59e0b');
define('THEME_SUCCESS_COLOR', '#10b981');

// إعدادات التحميل - Upload Settings
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf']);

// إعدادات التخزين المؤقت - Cache Settings
define('CACHE_ENABLED', true);
define('CACHE_LIFETIME', 3600); // ساعة واحدة

// إعدادات PWA - Progressive Web App
define('PWA_ENABLED', true);
define('PWA_NAME', SITE_NAME);
define('PWA_SHORT_NAME', 'الدمام العوازل');
define('PWA_THEME_COLOR', THEME_PRIMARY_COLOR);

// منطقة زمنية - Timezone
date_default_timezone_set('Asia/Riyadh');

// بدء الجلسة - Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// إعدادات الأخطاء - Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 0); // إخفاء الأخطاء في الإنتاج

// توصيل قاعدة البيانات - Database Connection
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    // في حالة عدم وجود قاعدة البيانات، سنستخدم ملفات JSON
    $pdo = null;
    error_log("Database connection failed: " . $e->getMessage());
}

// دالة للحصول على الإعدادات من قاعدة البيانات أو ملف JSON
function get_site_settings() {
    global $pdo;
    
    if ($pdo !== null) {
        try {
            $stmt = $pdo->query("SELECT * FROM site_settings");
            $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
            return $settings;
        } catch (PDOException $e) {
            // في حالة فشل الاستعلام، استخدم الإعدادات الافتراضية
        }
    }
    
    // الإعدادات الافتراضية
    return [
        'site_name' => SITE_NAME,
        'site_description' => SITE_DESCRIPTION,
        'contact_phone' => COMPANY_PHONE,
        'contact_email' => COMPANY_EMAIL,
        'contact_address' => COMPANY_ADDRESS,
        'whatsapp_number' => COMPANY_WHATSAPP,
        'primary_color' => THEME_PRIMARY_COLOR,
        'secondary_color' => THEME_SECONDARY_COLOR,
    ];
}

// تحميل الإعدادات
$site_settings = get_site_settings();
?>