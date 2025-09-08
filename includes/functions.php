<?php
/**
 * ملف الدوال المساعدة - شركة الدمام للعوازل والترميم
 * Helper Functions - Al-Dammam Insulation & Renovation
 */

// منع الوصول المباشر
if (!defined('SITE_NAME')) {
    die('Direct access not permitted');
}

/**
 * دالة تنظيف وتعقيم البيانات المدخلة
 * Sanitize input data
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * دالة التحقق من البريد الإلكتروني
 * Validate email address
 */
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * دالة التحقق من رقم الهاتف السعودي
 * Validate Saudi phone number
 */
function validate_saudi_phone($phone) {
    // إزالة المسافات والرموز
    $phone = preg_replace('/[^0-9+]/', '', $phone);
    
    // أنماط الأرقام السعودية المقبولة
    $patterns = [
        '/^(\+966|00966|966)?[0-9]{9}$/',  // رقم مع كود الدولة
        '/^05[0-9]{8}$/',                  // رقم محمول محلي
    ];
    
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $phone)) {
            return true;
        }
    }
    
    return false;
}

/**
 * دالة إنشاء رمز أمان CSRF
 * Generate CSRF token
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * دالة التحقق من رمز الأمان CSRF
 * Verify CSRF token
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * دالة تحسين الصور
 * Image optimization function
 */
function optimize_image($source, $destination, $quality = 85) {
    $info = getimagesize($source);
    
    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($source);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
    } else {
        return false;
    }
    
    // حفظ الصورة محسنة
    imagejpeg($image, $destination, $quality);
    imagedestroy($image);
    
    return true;
}

/**
 * دالة إنشاء slug من النص العربي
 * Generate URL slug from Arabic text
 */
function create_slug($text) {
    // تحويل الأحرف العربية إلى إنجليزية
    $arabic_to_english = [
        'ا' => 'a', 'ب' => 'b', 'ت' => 't', 'ث' => 'th', 'ج' => 'j',
        'ح' => 'h', 'خ' => 'kh', 'د' => 'd', 'ذ' => 'th', 'ر' => 'r',
        'ز' => 'z', 'س' => 's', 'ش' => 'sh', 'ص' => 's', 'ض' => 'd',
        'ط' => 't', 'ظ' => 'z', 'ع' => 'a', 'غ' => 'gh', 'ف' => 'f',
        'ق' => 'q', 'ك' => 'k', 'ل' => 'l', 'م' => 'm', 'ن' => 'n',
        'ه' => 'h', 'و' => 'w', 'ي' => 'y', 'ة' => 'h', 'ى' => 'a'
    ];
    
    $text = str_replace(array_keys($arabic_to_english), array_values($arabic_to_english), $text);
    $text = preg_replace('/[^a-zA-Z0-9\s]/', '', $text);
    $text = preg_replace('/\s+/', '-', trim($text));
    $text = strtolower($text);
    
    return $text;
}

/**
 * دالة إنشاء breadcrumb
 * Generate breadcrumb navigation
 */
function generate_breadcrumb($items = []) {
    $breadcrumb = '<nav aria-label="breadcrumb" class="breadcrumb-nav">';
    $breadcrumb .= '<ol class="breadcrumb">';
    
    // إضافة الصفحة الرئيسية دائماً
    $breadcrumb .= '<li class="breadcrumb-item"><a href="/">الرئيسية</a></li>';
    
    foreach ($items as $item) {
        if (isset($item['url'])) {
            $breadcrumb .= '<li class="breadcrumb-item"><a href="' . $item['url'] . '">' . $item['title'] . '</a></li>';
        } else {
            $breadcrumb .= '<li class="breadcrumb-item active">' . $item['title'] . '</li>';
        }
    }
    
    $breadcrumb .= '</ol>';
    $breadcrumb .= '</nav>';
    
    return $breadcrumb;
}

/**
 * دالة إرسال البريد الإلكتروني
 * Send email function
 */
function send_email($to, $subject, $message, $from = null) {
    $from = $from ?: COMPANY_EMAIL;
    
    $headers = [
        'From' => $from,
        'Reply-To' => $from,
        'Content-Type' => 'text/html; charset=UTF-8',
        'Content-Transfer-Encoding' => '8bit',
        'X-Mailer' => 'PHP/' . phpversion()
    ];
    
    $header_string = '';
    foreach ($headers as $key => $value) {
        $header_string .= $key . ': ' . $value . "\r\n";
    }
    
    return mail($to, $subject, $message, $header_string);
}

/**
 * دالة ضغط ودمج ملفات CSS
 * Compress and combine CSS files
 */
function minify_css($css) {
    // إزالة التعليقات
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    
    // إزالة المسافات الزائدة
    $css = str_replace(["\r\n", "\r", "\n", "\t"], '', $css);
    $css = preg_replace('/\s+/', ' ', $css);
    
    // إزالة المسافات حول الرموز
    $css = str_replace(['; ', ' {', '{ ', ' }', '} ', ': ', ' :'], [';', '{', '{', '}', '}', ':', ':'], $css);
    
    return trim($css);
}

/**
 * دالة ضغط JavaScript
 * Compress JavaScript
 */
function minify_js($js) {
    // إزالة التعليقات
    $js = preg_replace('/\/\*[\s\S]*?\*\//', '', $js);
    $js = preg_replace('/\/\/.*/', '', $js);
    
    // إزالة المسافات الزائدة
    $js = preg_replace('/\s+/', ' ', $js);
    
    return trim($js);
}

/**
 * دالة إنشاء sitemap XML
 * Generate XML sitemap
 */
function generate_sitemap() {
    $urls = [
        [
            'url' => SITE_URL . '/',
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '1.0'
        ],
        [
            'url' => SITE_URL . '/services',
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.8'
        ],
        [
            'url' => SITE_URL . '/gallery',
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.7'
        ],
        [
            'url' => SITE_URL . '/contact',
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.6'
        ]
    ];
    
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
    
    foreach ($urls as $url) {
        $xml .= '<url>' . PHP_EOL;
        $xml .= '<loc>' . htmlspecialchars($url['url']) . '</loc>' . PHP_EOL;
        $xml .= '<lastmod>' . $url['lastmod'] . '</lastmod>' . PHP_EOL;
        $xml .= '<changefreq>' . $url['changefreq'] . '</changefreq>' . PHP_EOL;
        $xml .= '<priority>' . $url['priority'] . '</priority>' . PHP_EOL;
        $xml .= '</url>' . PHP_EOL;
    }
    
    $xml .= '</urlset>';
    
    return $xml;
}

/**
 * دالة تسجيل النشاطات
 * Log activities
 */
function log_activity($message, $level = 'info') {
    $log_file = __DIR__ . '/../logs/activity.log';
    $log_dir = dirname($log_file);
    
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    
    $log_entry = "[{$timestamp}] [{$level}] IP: {$ip} - {$message} - UA: {$user_agent}" . PHP_EOL;
    
    file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
}

/**
 * دالة تنظيف وحماية من XSS
 * XSS protection function
 */
function clean_xss($data) {
    // تنظيف البيانات من الأكواد الضارة
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    $data = strip_tags($data);
    return $data;
}

/**
 * دالة التحقق من معدل الطلبات
 * Rate limiting function
 */
function check_rate_limit($key, $limit = 10, $window = 60) {
    $cache_file = __DIR__ . '/../cache/rate_limit_' . md5($key) . '.json';
    
    $now = time();
    $data = [];
    
    if (file_exists($cache_file)) {
        $data = json_decode(file_get_contents($cache_file), true);
    }
    
    // تنظيف الطلبات القديمة
    $data = array_filter($data, function($timestamp) use ($now, $window) {
        return ($now - $timestamp) < $window;
    });
    
    if (count($data) >= $limit) {
        return false;
    }
    
    // إضافة الطلب الحالي
    $data[] = $now;
    
    // حفظ البيانات
    $cache_dir = dirname($cache_file);
    if (!is_dir($cache_dir)) {
        mkdir($cache_dir, 0755, true);
    }
    
    file_put_contents($cache_file, json_encode($data));
    
    return true;
}
?>