<?php
/**
 * تسجيل خروج لوحة التحكم - شركة الدمام للعوازل والترميم
 * Admin Logout - Al-Dammam Insulation & Renovation
 */

session_start();

// مسح جميع بيانات الجلسة
$_SESSION = array();

// حذف ملف الجلسة
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// إنهاء الجلسة
session_destroy();

// توجيه للصفحة الرئيسية
header('Location: ../index.php');
exit();
?>