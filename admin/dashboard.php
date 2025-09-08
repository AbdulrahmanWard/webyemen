<?php
/**
 * لوحة التحكم الرئيسية - شركة الدمام للعوازل والترميم
 * Main Dashboard - Al-Dammam Insulation & Renovation
 */

// فحص صلاحية الوصول
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// تضمين ملفات الإعدادات
require_once '../includes/config.php';
require_once '../includes/functions.php';

// تعيين معلومات الصفحة
$page_title = 'لوحة التحكم الرئيسية';
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title . ' - ' . SITE_NAME; ?></title>
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/main.rtl.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    
    <!-- Admin specific styles -->
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Cairo', sans-serif;
        }
        
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        .admin-sidebar {
            width: 280px;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            padding: 2rem 0;
        }
        
        .admin-main {
            flex: 1;
            padding: 2rem;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .dashboard-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card {
            text-align: center;
            padding: 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .recent-activity {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .activity-time {
            font-size: 0.875rem;
            color: #64748b;
        }
        
        @media (max-width: 768px) {
            .admin-wrapper {
                flex-direction: column;
            }
            
            .admin-sidebar {
                width: 100%;
            }
            
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    
    <div class="admin-wrapper">
        
        <!-- الشريط الجانبي -->
        <aside class="admin-sidebar">
            <div class="sidebar-header" style="padding: 0 2rem; margin-bottom: 2rem;">
                <h2 style="color: #1e40af; font-size: 1.5rem; margin: 0;">لوحة التحكم</h2>
                <p style="color: #64748b; margin: 0.5rem 0 0 0;">مرحباً، <?php echo $_SESSION['admin_name'] ?? 'المدير'; ?></p>
            </div>
            
            <nav class="sidebar-nav" style="padding: 0 1rem;">
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 0.5rem;">
                        <a href="dashboard.php" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 8px; background: #3b82f6; color: white; text-decoration: none;">
                            <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="3" y="3" width="7" height="7"/>
                                <rect x="14" y="3" width="7" height="7"/>
                                <rect x="14" y="14" width="7" height="7"/>
                                <rect x="3" y="14" width="7" height="7"/>
                            </svg>
                            الرئيسية
                        </a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="maps.php" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 8px; color: #374151; text-decoration: none; transition: all 0.2s;">
                            <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            إدارة الخرائط
                        </a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="seo.php" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 8px; color: #374151; text-decoration: none;">
                            <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="11" cy="11" r="8"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35"/>
                            </svg>
                            تحسين SEO
                        </a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="theme-settings.php" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 8px; color: #374151; text-decoration: none;">
                            <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="12" cy="12" r="3"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 1v6m0 6v6m11-7h-6m-6 0H1m15.364-6.364l-4.243 4.243M6.343 6.343l-4.243-4.243m12.727 0l-4.243 4.243M6.343 17.657l-4.243 4.243"/>
                            </svg>
                            إعدادات التصميم
                        </a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="cache-management.php" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 8px; color: #374151; text-decoration: none;">
                            <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                            </svg>
                            إدارة التخزين
                        </a>
                    </li>
                    <li style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
                        <a href="../index.php" target="_blank" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 8px; color: #374151; text-decoration: none;">
                            <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            عرض الموقع
                        </a>
                    </li>
                    <li>
                        <a href="logout.php" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 8px; color: #dc2626; text-decoration: none;">
                            <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            تسجيل الخروج
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <!-- المحتوى الرئيسي -->
        <main class="admin-main">
            
            <!-- العنوان -->
            <header style="margin-bottom: 2rem;">
                <h1 style="color: #1e293b; font-size: 2rem; margin-bottom: 0.5rem;">لوحة التحكم الرئيسية</h1>
                <p style="color: #64748b;">نظرة عامة على إحصائيات الموقع والأنشطة الحديثة</p>
            </header>
            
            <!-- إحصائيات سريعة -->
            <div class="dashboard-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo rand(450, 550); ?></div>
                    <div class="stat-label">إجمالي المشاريع</div>
                </div>
                
                <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="stat-number"><?php echo rand(280, 320); ?></div>
                    <div class="stat-label">العملاء الراضون</div>
                </div>
                
                <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="stat-number"><?php echo rand(1200, 1500); ?></div>
                    <div class="stat-label">زوار هذا الشهر</div>
                </div>
                
                <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <div class="stat-number"><?php echo rand(25, 40); ?></div>
                    <div class="stat-label">طلبات العروض</div>
                </div>
            </div>
            
            <!-- محتوى التفاصيل -->
            <div class="dashboard-grid">
                
                <!-- النشاطات الحديثة -->
                <div class="dashboard-card">
                    <h3 style="color: #1e293b; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <svg style="width: 24px; height: 24px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <polyline points="22,12 18,12 15,21 9,3 6,12 2,12"/>
                        </svg>
                        النشاطات الحديثة
                    </h3>
                    
                    <div class="recent-activity">
                        <div class="activity-item">
                            <div class="activity-icon" style="background: #dbeafe; color: #3b82f6;">
                                <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">طلب عرض سعر جديد</div>
                                <div class="activity-time">منذ 15 دقيقة - عزل حراري للسطح</div>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon" style="background: #d1fae5; color: #10b981;">
                                <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">تم إكمال مشروع</div>
                                <div class="activity-time">منذ ساعة - عزل مائي - الدمام</div>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon" style="background: #fef3c7; color: #f59e0b;">
                                <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">تحديث خريطة الموقع</div>
                                <div class="activity-time">منذ 3 ساعات - تم إضافة صفحات جديدة</div>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon" style="background: #e0e7ff; color: #6366f1;">
                                <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">تحسين SEO</div>
                                <div class="activity-time">أمس - تحديث meta tags</div>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon" style="background: #fce7f3; color: #ec4899;">
                                <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">تقييم جديد</div>
                                <div class="activity-time">أمس - 5 نجوم لخدمة العزل الحراري</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- أدوات سريعة -->
                <div class="dashboard-card">
                    <h3 style="color: #1e293b; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <svg style="width: 24px; height: 24px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="9" cy="9" r="2"/>
                            <path d="m21 15-3.086-3.086a2 2 0 00-2.828 0L6 21"/>
                        </svg>
                        أدوات سريعة
                    </h3>
                    
                    <div style="display: grid; gap: 1rem;">
                        <a href="../api/sitemap.xml" target="_blank" 
                           style="display: flex; align-items: center; gap: 0.75rem; padding: 1rem; background: #f8fafc; border-radius: 8px; text-decoration: none; color: #374151; transition: all 0.2s;">
                            <svg style="width: 20px; height: 20px; color: #3b82f6;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            <div>
                                <div style="font-weight: 600;">عرض خريطة الموقع</div>
                                <div style="font-size: 0.875rem; color: #64748b;">XML Sitemap</div>
                            </div>
                        </a>
                        
                        <button onclick="clearCache()" 
                                style="display: flex; align-items: center; gap: 0.75rem; padding: 1rem; background: #f8fafc; border: none; border-radius: 8px; color: #374151; cursor: pointer; transition: all 0.2s; width: 100%;">
                            <svg style="width: 20px; height: 20px; color: #ef4444;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <div style="text-align: right;">
                                <div style="font-weight: 600;">مسح التخزين المؤقت</div>
                                <div style="font-size: 0.875rem; color: #64748b;">تنظيف الذاكرة</div>
                            </div>
                        </button>
                        
                        <button onclick="generateSitemap()" 
                                style="display: flex; align-items: center; gap: 0.75rem; padding: 1rem; background: #f8fafc; border: none; border-radius: 8px; color: #374151; cursor: pointer; transition: all 0.2s; width: 100%;">
                            <svg style="width: 20px; height: 20px; color: #10b981;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            <div style="text-align: right;">
                                <div style="font-weight: 600;">تحديث خريطة الموقع</div>
                                <div style="font-size: 0.875rem; color: #64748b;">إنشاء sitemap جديد</div>
                            </div>
                        </button>
                    </div>
                </div>
                
            </div>
            
        </main>
        
    </div>
    
    <script>
        // وظائف لوحة التحكم
        function clearCache() {
            if (confirm('هل أنت متأكد من مسح التخزين المؤقت؟')) {
                fetch('cache-management.php?action=clear', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('تم مسح التخزين المؤقت بنجاح');
                    } else {
                        alert('حدث خطأ: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('حدث خطأ في الاتصال');
                    console.error('Error:', error);
                });
            }
        }
        
        function generateSitemap() {
            fetch('maps.php?action=generate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('تم تحديث خريطة الموقع بنجاح');
                } else {
                    alert('حدث خطأ: ' + data.message);
                }
            })
            .catch(error => {
                alert('حدث خطأ في الاتصال');
                console.error('Error:', error);
            });
        }
        
        // تحديث الإحصائيات كل دقيقة
        setInterval(() => {
            // يمكن إضافة كود تحديث الإحصائيات هنا
        }, 60000);
        
        // تأثيرات تفاعلية
        document.querySelectorAll('.dashboard-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-2px)';
                card.style.transition = 'all 0.2s ease';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
            });
        });
    </script>

</body>
</html>