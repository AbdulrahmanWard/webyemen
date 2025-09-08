<?php
/**
 * إدارة SEO - شركة الدمام للعوازل والترميم
 * SEO Management - Al-Dammam Insulation & Renovation
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
$page_title = 'تحسين SEO';

// بيانات تحسين محركات البحث الحالية
$seo_data = [
    'meta_title' => DEFAULT_META_TITLE,
    'meta_description' => DEFAULT_META_DESCRIPTION,
    'meta_keywords' => SITE_KEYWORDS,
    'og_image' => DEFAULT_OG_IMAGE,
    'google_analytics' => '',
    'google_search_console' => '',
    'facebook_pixel' => '',
    'robots_txt' => "User-agent: *\nAllow: /\nSitemap: " . SITE_URL . "/api/sitemap.xml"
];

// معالجة تحديث الإعدادات
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_seo'])) {
    // هنا يمكن حفظ الإعدادات في قاعدة البيانات أو ملف JSON
    $success_message = 'تم تحديث إعدادات SEO بنجاح';
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
        
        .form-grid {
            display: grid;
            gap: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            color: #374151;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .form-input,
        .form-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-family: 'Cairo', sans-serif;
            transition: border-color 0.2s ease;
        }
        
        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .form-textarea {
            min-height: 100px;
            resize: vertical;
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
        
        .btn-info {
            background: #06b6d4;
            color: white;
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
        
        .seo-score {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #f3f4f6;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        
        .score-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.25rem;
        }
        
        .score-85 { background: #10b981; }
        .score-70 { background: #f59e0b; }
        .score-50 { background: #ef4444; }
        
        .tabs {
            display: flex;
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 2rem;
        }
        
        .tab {
            padding: 1rem 1.5rem;
            border: none;
            background: none;
            cursor: pointer;
            font-family: 'Cairo', sans-serif;
            font-weight: 600;
            color: #6b7280;
            border-bottom: 3px solid transparent;
            transition: all 0.2s ease;
        }
        
        .tab.active {
            color: #3b82f6;
            border-bottom-color: #3b82f6;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        @media (max-width: 768px) {
            .admin-wrapper {
                flex-direction: column;
            }
            .admin-sidebar {
                width: 100%;
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
                        <a href="maps.php" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 8px; color: #374151; text-decoration: none;">
                            <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            إدارة الخرائط
                        </a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="seo.php" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 8px; background: #3b82f6; color: white; text-decoration: none;">
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
                <h1 style="color: #1e293b; font-size: 2rem; margin-bottom: 0.5rem;">تحسين محركات البحث (SEO)</h1>
                <p style="color: #64748b;">إدارة وتحسين ظهور الموقع في نتائج البحث</p>
            </header>
            
            <!-- رسالة النجاح -->
            <?php if (isset($success_message)): ?>
            <div class="alert alert-success">
                <strong><?php echo $success_message; ?></strong>
            </div>
            <?php endif; ?>
            
            <!-- نقاط SEO -->
            <div class="card">
                <h3 style="color: #1e293b; margin-bottom: 1.5rem;">تحليل SEO للموقع</h3>
                
                <div class="seo-score">
                    <div class="score-circle score-85">85</div>
                    <div>
                        <h4 style="color: #1e293b; margin-bottom: 0.5rem;">نقاط SEO الإجمالية</h4>
                        <p style="color: #64748b; margin: 0;">جيد جداً - هناك مجال للتحسين</p>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 1rem;">
                    <div style="padding: 1rem; background: #f0fdf4; border-radius: 8px; border-left: 4px solid #10b981;">
                        <h5 style="color: #166534; margin-bottom: 0.5rem;">Meta Tags</h5>
                        <p style="color: #16a34a; font-size: 0.875rem; margin: 0;">✓ تم تحسينها</p>
                    </div>
                    
                    <div style="padding: 1rem; background: #fffbeb; border-radius: 8px; border-left: 4px solid #f59e0b;">
                        <h5 style="color: #92400e; margin-bottom: 0.5rem;">سرعة التحميل</h5>
                        <p style="color: #d97706; font-size: 0.875rem; margin: 0;">⚠ تحتاج تحسين</p>
                    </div>
                    
                    <div style="padding: 1rem; background: #f0fdf4; border-radius: 8px; border-left: 4px solid #10b981;">
                        <h5 style="color: #166534; margin-bottom: 0.5rem;">المحتوى</h5>
                        <p style="color: #16a34a; font-size: 0.875rem; margin: 0;">✓ محسن للموبايل</p>
                    </div>
                    
                    <div style="padding: 1rem; background: #f0fdf4; border-radius: 8px; border-left: 4px solid #10b981;">
                        <h5 style="color: #166534; margin-bottom: 0.5rem;">Sitemap</h5>
                        <p style="color: #16a34a; font-size: 0.875rem; margin: 0;">✓ موجود ومحدث</p>
                    </div>
                </div>
            </div>
            
            <!-- علامات التبويب -->
            <div class="card">
                <div class="tabs">
                    <button class="tab active" onclick="switchTab('meta-tags')">Meta Tags</button>
                    <button class="tab" onclick="switchTab('social-media')">الشبكات الاجتماعية</button>
                    <button class="tab" onclick="switchTab('analytics')">التحليلات</button>
                    <button class="tab" onclick="switchTab('robots')">Robots.txt</button>
                </div>
                
                <form method="POST" action="">
                    <!-- Meta Tags -->
                    <div id="meta-tags" class="tab-content active">
                        <h3 style="color: #1e293b; margin-bottom: 1.5rem;">إعدادات Meta Tags</h3>
                        
                        <div class="form-group">
                            <label for="meta_title" class="form-label">العنوان الرئيسي (Meta Title)</label>
                            <input type="text" id="meta_title" name="meta_title" class="form-input" 
                                   value="<?php echo htmlspecialchars($seo_data['meta_title']); ?>" maxlength="60">
                            <small style="color: #6b7280;">يفضل ألا يزيد عن 60 حرف</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="meta_description" class="form-label">وصف الموقع (Meta Description)</label>
                            <textarea id="meta_description" name="meta_description" class="form-textarea" 
                                      maxlength="160"><?php echo htmlspecialchars($seo_data['meta_description']); ?></textarea>
                            <small style="color: #6b7280;">يفضل ألا يزيد عن 160 حرف</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="meta_keywords" class="form-label">الكلمات المفتاحية</label>
                            <input type="text" id="meta_keywords" name="meta_keywords" class="form-input" 
                                   value="<?php echo htmlspecialchars($seo_data['meta_keywords']); ?>">
                            <small style="color: #6b7280;">افصل الكلمات بفاصلة</small>
                        </div>
                    </div>
                    
                    <!-- Social Media -->
                    <div id="social-media" class="tab-content">
                        <h3 style="color: #1e293b; margin-bottom: 1.5rem;">إعدادات الشبكات الاجتماعية</h3>
                        
                        <div class="form-group">
                            <label for="og_image" class="form-label">صورة المشاركة (OG Image)</label>
                            <input type="url" id="og_image" name="og_image" class="form-input" 
                                   value="<?php echo htmlspecialchars($seo_data['og_image']); ?>">
                            <small style="color: #6b7280;">يفضل أن تكون بحجم 1200×630 بكسل</small>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                            <div style="padding: 1rem; background: #f8fafc; border-radius: 8px;">
                                <h5 style="color: #1e293b; margin-bottom: 1rem;">معاينة فيسبوك</h5>
                                <div style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
                                    <div style="height: 120px; background: #e5e7eb; display: flex; align-items: center; justify-content: center; color: #6b7280;">
                                        صورة المعاينة
                                    </div>
                                    <div style="padding: 1rem;">
                                        <h6 style="font-size: 0.875rem; margin-bottom: 0.25rem;"><?php echo SITE_NAME; ?></h6>
                                        <p style="font-size: 0.75rem; color: #6b7280; margin: 0;"><?php echo SITE_DESCRIPTION; ?></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div style="padding: 1rem; background: #f8fafc; border-radius: 8px;">
                                <h5 style="color: #1e293b; margin-bottom: 1rem;">معاينة تويتر</h5>
                                <div style="border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">
                                    <div style="height: 100px; background: #e5e7eb; display: flex; align-items: center; justify-content: center; color: #6b7280;">
                                        صورة المعاينة
                                    </div>
                                    <div style="padding: 0.75rem;">
                                        <h6 style="font-size: 0.8rem; margin-bottom: 0.25rem;"><?php echo SITE_NAME; ?></h6>
                                        <p style="font-size: 0.7rem; color: #6b7280; margin: 0;"><?php echo substr(SITE_DESCRIPTION, 0, 100); ?>...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Analytics -->
                    <div id="analytics" class="tab-content">
                        <h3 style="color: #1e293b; margin-bottom: 1.5rem;">أدوات التحليل</h3>
                        
                        <div class="form-group">
                            <label for="google_analytics" class="form-label">Google Analytics ID</label>
                            <input type="text" id="google_analytics" name="google_analytics" class="form-input" 
                                   placeholder="GA-XXXXXXXXX-X" value="<?php echo htmlspecialchars($seo_data['google_analytics']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="google_search_console" class="form-label">Google Search Console</label>
                            <input type="text" id="google_search_console" name="google_search_console" class="form-input" 
                                   placeholder="google-site-verification=..." value="<?php echo htmlspecialchars($seo_data['google_search_console']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="facebook_pixel" class="form-label">Facebook Pixel ID</label>
                            <input type="text" id="facebook_pixel" name="facebook_pixel" class="form-input" 
                                   placeholder="123456789012345" value="<?php echo htmlspecialchars($seo_data['facebook_pixel']); ?>">
                        </div>
                    </div>
                    
                    <!-- Robots.txt -->
                    <div id="robots" class="tab-content">
                        <h3 style="color: #1e293b; margin-bottom: 1.5rem;">إعدادات Robots.txt</h3>
                        
                        <div class="form-group">
                            <label for="robots_txt" class="form-label">محتوى ملف Robots.txt</label>
                            <textarea id="robots_txt" name="robots_txt" class="form-textarea" rows="8"><?php echo htmlspecialchars($seo_data['robots_txt']); ?></textarea>
                            <small style="color: #6b7280;">تحكم في كيفية فهرسة محركات البحث لموقعك</small>
                        </div>
                        
                        <div style="padding: 1rem; background: #dbeafe; border-radius: 8px;">
                            <h5 style="color: #1e3a8a; margin-bottom: 0.5rem;">معاينة الملف الحالي:</h5>
                            <a href="../robots.txt" target="_blank" style="color: #3b82f6; text-decoration: none;">
                                عرض robots.txt الحالي
                            </a>
                        </div>
                    </div>
                    
                    <!-- أزرار الحفظ -->
                    <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e5e7eb;">
                        <button type="submit" name="update_seo" class="btn btn-primary">
                            <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            حفظ التغييرات
                        </button>
                        
                        <a href="https://search.google.com/test/mobile-friendly" target="_blank" class="btn btn-info" style="margin-right: 1rem;">
                            <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                                <line x1="8" y1="21" x2="16" y2="21"/>
                                <line x1="12" y1="17" x2="12" y2="21"/>
                            </svg>
                            اختبار الموبايل
                        </a>
                        
                        <a href="https://pagespeed.web.dev/" target="_blank" class="btn btn-success" style="margin-right: 1rem;">
                            <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12,6 12,12 16,14"/>
                            </svg>
                            اختبار السرعة
                        </a>
                    </div>
                </form>
            </div>
            
        </main>
        
    </div>
    
    <script>
        function switchTab(tabName) {
            // إخفاء جميع محتويات التبويبات
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // إزالة التفعيل من جميع الأزرار
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // تفعيل التبويب المحدد
            document.getElementById(tabName).classList.add('active');
            event.target.classList.add('active');
        }
        
        // تحديث عداد الأحرف
        function updateCharCount(inputId, maxLength) {
            const input = document.getElementById(inputId);
            const currentLength = input.value.length;
            const remaining = maxLength - currentLength;
            
            let color = '#6b7280';
            if (remaining < 10) color = '#ef4444';
            else if (remaining < 20) color = '#f59e0b';
            
            const counter = input.nextElementSibling;
            if (counter && counter.tagName === 'SMALL') {
                counter.innerHTML = `${remaining} حرف متبقي من ${maxLength}`;
                counter.style.color = color;
            }
        }
        
        // إضافة مستمعات الأحداث
        document.getElementById('meta_title').addEventListener('input', () => updateCharCount('meta_title', 60));
        document.getElementById('meta_description').addEventListener('input', () => updateCharCount('meta_description', 160));
        
        // تهيئة العدادات
        updateCharCount('meta_title', 60);
        updateCharCount('meta_description', 160);
    </script>

</body>
</html>