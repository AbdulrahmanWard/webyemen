<?php
/**
 * إدارة الخرائط وال sitemap - شركة الدمام للعوازل والترميم
 * Maps Management - Al-Dammam Insulation & Renovation
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

// معالجة طلبات AJAX
if (isset($_GET['action']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    if ($_GET['action'] === 'generate') {
        try {
            $sitemap = generate_sitemap();
            $sitemapPath = __DIR__ . '/../api/sitemap.xml';
            
            if (file_put_contents($sitemapPath, $sitemap)) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'تم إنشاء خريطة الموقع بنجاح'
                ]);
            } else {
                echo json_encode([
                    'success' => false, 
                    'message' => 'فشل في كتابة ملف خريطة الموقع'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false, 
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ]);
        }
        exit();
    }
}

// تعيين معلومات الصفحة
$page_title = 'إدارة الخرائط';

// قراءة خريطة الموقع الحالية
$sitemapPath = __DIR__ . '/../api/sitemap.xml';
$sitemapExists = file_exists($sitemapPath);
$sitemapLastModified = $sitemapExists ? filemtime($sitemapPath) : null;
$sitemapSize = $sitemapExists ? filesize($sitemapPath) : 0;

// قراءة محتوى خريطة الموقع
$sitemapContent = '';
if ($sitemapExists) {
    $sitemapContent = file_get_contents($sitemapPath);
}

// استخراج عناوين URL من خريطة الموقع
$urls = [];
if ($sitemapContent) {
    $xml = simplexml_load_string($sitemapContent);
    if ($xml) {
        foreach ($xml->url as $url) {
            $urls[] = [
                'loc' => (string)$url->loc,
                'lastmod' => (string)$url->lastmod,
                'changefreq' => (string)$url->changefreq,
                'priority' => (string)$url->priority
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title . ' - ' . SITE_NAME; ?></title>
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/main.rtl.css">
    
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
        
        .card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        
        .table th,
        .table td {
            padding: 1rem;
            text-align: right;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table th {
            background: #f8fafc;
            font-weight: 600;
            color: #374151;
        }
        
        .table tbody tr:hover {
            background: #f9fafb;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-family: 'Cairo', sans-serif;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background: #3b82f6;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }
        
        .btn-success {
            background: #10b981;
            color: white;
        }
        
        .btn-success:hover {
            background: #059669;
        }
        
        .btn-secondary {
            background: #6b7280;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #4b5563;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        
        .alert-success {
            background: #d1fae5;
            border: 1px solid #10b981;
            color: #065f46;
        }
        
        .alert-info {
            background: #dbeafe;
            border: 1px solid #3b82f6;
            color: #1e3a8a;
        }
        
        .priority-high { color: #dc2626; font-weight: 600; }
        .priority-medium { color: #f59e0b; font-weight: 600; }
        .priority-low { color: #10b981; font-weight: 600; }
        
        @media (max-width: 768px) {
            .admin-wrapper {
                flex-direction: column;
            }
            .admin-sidebar {
                width: 100%;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .table-responsive {
                overflow-x: auto;
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
                        <a href="dashboard.php" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 8px; color: #374151; text-decoration: none;">
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
                        <a href="maps.php" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 8px; background: #3b82f6; color: white; text-decoration: none;">
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
                </ul>
            </nav>
        </aside>
        
        <!-- المحتوى الرئيسي -->
        <main class="admin-main">
            
            <!-- العنوان -->
            <header style="margin-bottom: 2rem;">
                <h1 style="color: #1e293b; font-size: 2rem; margin-bottom: 0.5rem;">إدارة الخرائط</h1>
                <p style="color: #64748b;">إدارة خريطة الموقع (Sitemap) وتحسين فهرسة محركات البحث</p>
            </header>
            
            <!-- الإحصائيات -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo count($urls); ?></div>
                    <div class="stat-label">إجمالي الصفحات</div>
                </div>
                
                <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <div class="stat-number"><?php echo $sitemapExists ? 'موجود' : 'غير موجود'; ?></div>
                    <div class="stat-label">حالة Sitemap</div>
                </div>
                
                <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <div class="stat-number"><?php echo $sitemapLastModified ? date('Y/m/d', $sitemapLastModified) : '-'; ?></div>
                    <div class="stat-label">آخر تحديث</div>
                </div>
                
                <div class="stat-card" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                    <div class="stat-number"><?php echo $sitemapSize > 0 ? round($sitemapSize/1024, 1) . ' KB' : '0 KB'; ?></div>
                    <div class="stat-label">حجم الملف</div>
                </div>
            </div>
            
            <!-- أدوات الإدارة -->
            <div class="card">
                <h3 style="color: #1e293b; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <svg style="width: 24px; height: 24px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    أدوات إدارة Sitemap
                </h3>
                
                <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
                    <button onclick="generateSitemap()" class="btn btn-primary">
                        <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        إنشاء Sitemap جديد
                    </button>
                    
                    <a href="../api/sitemap.xml" target="_blank" class="btn btn-success">
                        <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        عرض Sitemap
                    </a>
                    
                    <a href="https://www.google.com/webmasters/tools/sitemap-list" target="_blank" class="btn btn-secondary">
                        <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Google Search Console
                    </a>
                </div>
                
                <!-- معلومات إضافية -->
                <div class="alert alert-info">
                    <strong>ملاحظة:</strong> يتم تحديث خريطة الموقع تلقائياً عند إضافة صفحات جديدة. يمكنك أيضاً إنشاؤها يدوياً باستخدام الزر أعلاه.
                </div>
            </div>
            
            <!-- جدول الصفحات -->
            <?php if (!empty($urls)): ?>
            <div class="card">
                <h3 style="color: #1e293b; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <svg style="width: 24px; height: 24px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z"/>
                    </svg>
                    صفحات الموقع في Sitemap
                </h3>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>رابط الصفحة</th>
                                <th>آخر تحديث</th>
                                <th>تكرار التحديث</th>
                                <th>الأولوية</th>
                                <th>حالة الصفحة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($urls as $url): ?>
                            <tr>
                                <td>
                                    <a href="<?php echo htmlspecialchars($url['loc']); ?>" target="_blank" 
                                       style="color: #3b82f6; text-decoration: none;">
                                        <?php echo htmlspecialchars(basename(parse_url($url['loc'], PHP_URL_PATH)) ?: 'الصفحة الرئيسية'); ?>
                                    </a>
                                </td>
                                <td><?php echo htmlspecialchars($url['lastmod']); ?></td>
                                <td>
                                    <span style="padding: 0.25rem 0.75rem; background: #f3f4f6; border-radius: 20px; font-size: 0.875rem;">
                                        <?php echo htmlspecialchars($url['changefreq']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    $priority = (float)$url['priority'];
                                    $class = $priority >= 0.8 ? 'priority-high' : ($priority >= 0.5 ? 'priority-medium' : 'priority-low');
                                    ?>
                                    <span class="<?php echo $class; ?>">
                                        <?php echo htmlspecialchars($url['priority']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span style="padding: 0.25rem 0.75rem; background: #d1fae5; color: #065f46; border-radius: 20px; font-size: 0.875rem;">
                                        نشط
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php else: ?>
            <div class="card">
                <div style="text-align: center; padding: 3rem;">
                    <svg style="width: 64px; height: 64px; margin: 0 auto 1rem; color: #9ca3af;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 style="color: #4b5563; margin-bottom: 1rem;">لا توجد خريطة موقع</h3>
                    <p style="color: #6b7280; margin-bottom: 2rem;">قم بإنشاء خريطة الموقع أولاً لعرض الصفحات هنا</p>
                    <button onclick="generateSitemap()" class="btn btn-primary">إنشاء Sitemap الآن</button>
                </div>
            </div>
            <?php endif; ?>
            
        </main>
        
    </div>
    
    <script>
        function generateSitemap() {
            const button = event.target;
            const originalText = button.innerHTML;
            
            // تغيير النص إلى تحميل
            button.innerHTML = `
                <svg style="width: 20px; height: 20px; animation: spin 1s linear infinite;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                جاري الإنشاء...
            `;
            button.disabled = true;
            
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
                    // عرض رسالة نجاح
                    showAlert('تم إنشاء خريطة الموقع بنجاح!', 'success');
                    
                    // إعادة تحميل الصفحة بعد ثانيتين
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showAlert('حدث خطأ: ' + data.message, 'error');
                }
            })
            .catch(error => {
                showAlert('حدث خطأ في الاتصال', 'error');
                console.error('Error:', error);
            })
            .finally(() => {
                // إعادة النص الأصلي
                button.innerHTML = originalText;
                button.disabled = false;
            });
        }
        
        function showAlert(message, type) {
            // إزالة التنبيهات السابقة
            const existingAlerts = document.querySelectorAll('.alert');
            existingAlerts.forEach(alert => {
                if (alert.classList.contains('alert-success') || alert.classList.contains('alert-danger')) {
                    alert.remove();
                }
            });
            
            // إنشاء تنبيه جديد
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert ${alertClass}`;
            alertDiv.style.marginBottom = '1rem';
            alertDiv.innerHTML = `<strong>${message}</strong>`;
            
            // إدراج التنبيه في أول الصفحة
            const mainContent = document.querySelector('.admin-main');
            const firstCard = mainContent.querySelector('.card');
            mainContent.insertBefore(alertDiv, firstCard);
            
            // إزالة التنبيه بعد 5 ثوانِ
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }
        
        // إضافة أنيمشن دوران للأيقونة
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            .alert-danger {
                background: #fee2e2;
                border: 1px solid #dc2626;
                color: #991b1b;
            }
        `;
        document.head.appendChild(style);
    </script>

</body>
</html>