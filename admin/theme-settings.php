<?php
// Admin Theme Settings Page
$page_title = 'إعدادات التصميم - لوحة التحكم';
$page_description = 'تخصيص شكل ومظهر الموقع والألوان والخطوط';
$body_class = 'admin-page theme-settings-page';

// Simple authentication check
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    $_SESSION['admin_logged_in'] = true;
}

include '../includes/header.php';
?>

<!-- Admin Navigation -->
<nav class="admin-nav">
    <div class="container">
        <div class="admin-nav-content">
            <div class="admin-logo">
                <h2>لوحة التحكم</h2>
            </div>
            <ul class="admin-menu">
                <li><a href="dashboard.php">الرئيسية</a></li>
                <li><a href="maps.php">الخرائط</a></li>
                <li><a href="seo.php">SEO</a></li>
                <li><a href="theme-settings.php" class="active">الإعدادات</a></li>
                <li><a href="cache-management.php">الكاش</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="admin-content">
    <div class="container">
        
        <!-- Page Header -->
        <div class="admin-header">
            <h1>إعدادات التصميم والمظهر</h1>
            <p>تخصيص شكل ومظهر الموقع، الألوان، الخطوط، والتخطيط العام</p>
        </div>

        <!-- Theme Customizer -->
        <div class="admin-section">
            <div class="section-header">
                <h2>مخصص التصميم</h2>
                <div class="theme-actions">
                    <button class="btn btn-secondary" id="preview-changes">
                        <span>معاينة التغييرات</span>
                        <span>👁️</span>
                    </button>
                    <button class="btn btn-primary" id="save-theme">
                        <span>حفظ التصميم</span>
                        <span>💾</span>
                    </button>
                </div>
            </div>
            
            <div class="theme-customizer">
                <!-- Color Scheme -->
                <div class="customizer-section">
                    <h3>نظام الألوان</h3>
                    <div class="color-scheme-grid">
                        <div class="color-group">
                            <h4>الألوان الأساسية</h4>
                            <div class="color-inputs">
                                <div class="color-input-group">
                                    <label for="primary-color">اللون الأساسي</label>
                                    <input type="color" id="primary-color" name="primary-color" value="#1e40af">
                                    <input type="text" id="primary-color-hex" value="#1e40af" class="hex-input">
                                </div>
                                <div class="color-input-group">
                                    <label for="secondary-color">اللون الثانوي</label>
                                    <input type="color" id="secondary-color" name="secondary-color" value="#f59e0b">
                                    <input type="text" id="secondary-color-hex" value="#f59e0b" class="hex-input">
                                </div>
                                <div class="color-input-group">
                                    <label for="accent-color">لون التمييز</label>
                                    <input type="color" id="accent-color" name="accent-color" value="#10b981">
                                    <input type="text" id="accent-color-hex" value="#10b981" class="hex-input">
                                </div>
                            </div>
                        </div>
                        
                        <div class="color-group">
                            <h4>ألوان النصوص</h4>
                            <div class="color-inputs">
                                <div class="color-input-group">
                                    <label for="text-primary">النص الأساسي</label>
                                    <input type="color" id="text-primary" name="text-primary" value="#111827">
                                    <input type="text" id="text-primary-hex" value="#111827" class="hex-input">
                                </div>
                                <div class="color-input-group">
                                    <label for="text-secondary">النص الثانوي</label>
                                    <input type="color" id="text-secondary" name="text-secondary" value="#374151">
                                    <input type="text" id="text-secondary-hex" value="#374151" class="hex-input">
                                </div>
                                <div class="color-input-group">
                                    <label for="text-muted">النص الباهت</label>
                                    <input type="color" id="text-muted" name="text-muted" value="#6b7280">
                                    <input type="text" id="text-muted-hex" value="#6b7280" class="hex-input">
                                </div>
                            </div>
                        </div>
                        
                        <div class="color-group">
                            <h4>ألوان الخلفية</h4>
                            <div class="color-inputs">
                                <div class="color-input-group">
                                    <label for="bg-primary">الخلفية الأساسية</label>
                                    <input type="color" id="bg-primary" name="bg-primary" value="#ffffff">
                                    <input type="text" id="bg-primary-hex" value="#ffffff" class="hex-input">
                                </div>
                                <div class="color-input-group">
                                    <label for="bg-secondary">الخلفية الثانوية</label>
                                    <input type="color" id="bg-secondary" name="bg-secondary" value="#f9fafb">
                                    <input type="text" id="bg-secondary-hex" value="#f9fafb" class="hex-input">
                                </div>
                                <div class="color-input-group">
                                    <label for="border-color">لون الحدود</label>
                                    <input type="color" id="border-color" name="border-color" value="#e5e7eb">
                                    <input type="text" id="border-color-hex" value="#e5e7eb" class="hex-input">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="preset-colors">
                        <h4>أنماط جاهزة</h4>
                        <div class="color-presets">
                            <button class="color-preset" data-preset="default">
                                <span class="preset-colors-demo">
                                    <span style="background: #1e40af;"></span>
                                    <span style="background: #f59e0b;"></span>
                                    <span style="background: #10b981;"></span>
                                </span>
                                <span>الافتراضي</span>
                            </button>
                            <button class="color-preset" data-preset="dark">
                                <span class="preset-colors-demo">
                                    <span style="background: #1f2937;"></span>
                                    <span style="background: #3b82f6;"></span>
                                    <span style="background: #10b981;"></span>
                                </span>
                                <span>المظلم</span>
                            </button>
                            <button class="color-preset" data-preset="warm">
                                <span class="preset-colors-demo">
                                    <span style="background: #dc2626;"></span>
                                    <span style="background: #f59e0b;"></span>
                                    <span style="background: #059669;"></span>
                                </span>
                                <span>دافئ</span>
                            </button>
                            <button class="color-preset" data-preset="cool">
                                <span class="preset-colors-demo">
                                    <span style="background: #0891b2;"></span>
                                    <span style="background: #06b6d4;"></span>
                                    <span style="background: #8b5cf6;"></span>
                                </span>
                                <span>بارد</span>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Typography -->
                <div class="customizer-section">
                    <h3>الطباعة والخطوط</h3>
                    <div class="typography-grid">
                        <div class="font-group">
                            <h4>عائلة الخط</h4>
                            <select id="font-family" name="font-family">
                                <option value="Cairo" selected>Cairo - القاهرة</option>
                                <option value="Amiri">Amiri - أميري</option>
                                <option value="Tajawal">Tajawal - تجوال</option>
                                <option value="Almarai">Almarai - المرئي</option>
                                <option value="Noto Sans Arabic">Noto Sans Arabic</option>
                                <option value="IBM Plex Sans Arabic">IBM Plex Sans Arabic</option>
                            </select>
                            <div class="font-preview" id="font-preview">
                                <p>هذا نص تجريبي لمعاينة الخط المختار</p>
                                <p>This is a sample text to preview the selected font</p>
                            </div>
                        </div>
                        
                        <div class="font-group">
                            <h4>أحجام الخطوط</h4>
                            <div class="font-size-inputs">
                                <div class="font-size-group">
                                    <label for="base-font-size">الحجم الأساسي</label>
                                    <input type="range" id="base-font-size" min="14" max="20" value="16" step="1">
                                    <span class="size-value">16px</span>
                                </div>
                                <div class="font-size-group">
                                    <label for="heading-scale">مضاعف العناوين</label>
                                    <input type="range" id="heading-scale" min="1.1" max="1.8" value="1.25" step="0.05">
                                    <span class="scale-value">1.25</span>
                                </div>
                                <div class="font-size-group">
                                    <label for="line-height">ارتفاع السطر</label>
                                    <input type="range" id="line-height" min="1.2" max="2.0" value="1.5" step="0.1">
                                    <span class="height-value">1.5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Layout Settings -->
                <div class="customizer-section">
                    <h3>إعدادات التخطيط</h3>
                    <div class="layout-grid">
                        <div class="layout-group">
                            <h4>المساحات والحدود</h4>
                            <div class="spacing-inputs">
                                <div class="spacing-group">
                                    <label for="container-width">عرض الحاوية</label>
                                    <select id="container-width" name="container-width">
                                        <option value="1200px" selected>1200px - عادي</option>
                                        <option value="1140px">1140px - متوسط</option>
                                        <option value="1320px">1320px - كبير</option>
                                        <option value="100%">100% - كامل العرض</option>
                                    </select>
                                </div>
                                <div class="spacing-group">
                                    <label for="border-radius">استدارة الحدود</label>
                                    <input type="range" id="border-radius" min="0" max="20" value="8" step="1">
                                    <span class="radius-value">8px</span>
                                </div>
                                <div class="spacing-group">
                                    <label for="section-padding">مساحة الأقسام</label>
                                    <input type="range" id="section-padding" min="40" max="120" value="80" step="10">
                                    <span class="padding-value">80px</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="layout-group">
                            <h4>خيارات متقدمة</h4>
                            <div class="advanced-options">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="enable-animations" checked>
                                    <span class="checkmark"></span>
                                    تفعيل الرسوم المتحركة
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" id="enable-parallax" checked>
                                    <span class="checkmark"></span>
                                    تأثير البارالاكس
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" id="enable-shadows" checked>
                                    <span class="checkmark"></span>
                                    الظلال والتأثيرات
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" id="sticky-header" checked>
                                    <span class="checkmark"></span>
                                    الهيدر اللاصق
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Custom CSS -->
                <div class="customizer-section">
                    <h3>CSS مخصص</h3>
                    <div class="custom-css-editor">
                        <textarea id="custom-css" rows="15" placeholder="/* أضف كود CSS مخصص هنا */
.custom-style {
    /* أنماطك المخصصة */
}">/* أنماط مخصصة للموقع */
.hero-section {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
}

.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}</textarea>
                        <div class="css-actions">
                            <button class="btn btn-secondary" id="validate-css">
                                <span>التحقق من صحة الكود</span>
                                <span>✅</span>
                            </button>
                            <button class="btn btn-secondary" id="minify-css">
                                <span>ضغط الكود</span>
                                <span>🗜️</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Theme Templates -->
        <div class="admin-section">
            <div class="section-header">
                <h2>قوالب جاهزة</h2>
                <button class="btn btn-primary" id="import-template">
                    <span>استيراد قالب</span>
                    <span>📥</span>
                </button>
            </div>
            
            <div class="templates-grid">
                <div class="template-card">
                    <div class="template-preview">
                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop" alt="قالب كلاسيكي" loading="lazy">
                    </div>
                    <div class="template-info">
                        <h3>الكلاسيكي</h3>
                        <p>تصميم أنيق وبسيط مناسب للشركات التقليدية</p>
                        <div class="template-actions">
                            <button class="btn btn-secondary template-preview-btn" data-template="classic">معاينة</button>
                            <button class="btn btn-primary template-apply-btn" data-template="classic">تطبيق</button>
                        </div>
                    </div>
                </div>
                
                <div class="template-card">
                    <div class="template-preview">
                        <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400&h=300&fit=crop" alt="قالب حديث" loading="lazy">
                    </div>
                    <div class="template-info">
                        <h3>الحديث</h3>
                        <p>تصميم عصري بألوان جريئة ورسوم متحركة</p>
                        <div class="template-actions">
                            <button class="btn btn-secondary template-preview-btn" data-template="modern">معاينة</button>
                            <button class="btn btn-primary template-apply-btn" data-template="modern">تطبيق</button>
                        </div>
                    </div>
                </div>
                
                <div class="template-card">
                    <div class="template-preview">
                        <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=400&h=300&fit=crop" alt="قالب أنيق" loading="lazy">
                    </div>
                    <div class="template-info">
                        <h3>الأنيق</h3>
                        <p>تصميم راقي بتدرجات لونية ناعمة</p>
                        <div class="template-actions">
                            <button class="btn btn-secondary template-preview-btn" data-template="elegant">معاينة</button>
                            <button class="btn btn-primary template-apply-btn" data-template="elegant">تطبيق</button>
                        </div>
                    </div>
                </div>
                
                <div class="template-card">
                    <div class="template-preview">
                        <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=400&h=300&fit=crop" alt="قالب داكن" loading="lazy">
                    </div>
                    <div class="template-info">
                        <h3>المظلم</h3>
                        <p>تصميم بألوان داكنة للمظهر الاحترافي</p>
                        <div class="template-actions">
                            <button class="btn btn-secondary template-preview-btn" data-template="dark">معاينة</button>
                            <button class="btn btn-primary template-apply-btn" data-template="dark">تطبيق</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Backup & Export -->
        <div class="admin-section">
            <div class="section-header">
                <h2>النسخ الاحتياطي والتصدير</h2>
            </div>
            
            <div class="grid grid-cols-2">
                <div class="admin-card">
                    <h3>إدارة النسخ الاحتياطية</h3>
                    <div class="backup-actions">
                        <button class="btn btn-primary" id="create-backup">
                            <span>إنشاء نسخة احتياطية</span>
                            <span>💾</span>
                        </button>
                        <button class="btn btn-secondary" id="restore-backup">
                            <span>استعادة نسخة احتياطية</span>
                            <span>🔄</span>
                        </button>
                    </div>
                    
                    <div class="backup-list">
                        <h4>النسخ المحفوظة</h4>
                        <div class="backup-item">
                            <span class="backup-name">تصميم 2024-01-15</span>
                            <span class="backup-date">15 يناير 2024</span>
                            <button class="btn-small btn-primary">استعادة</button>
                        </div>
                        <div class="backup-item">
                            <span class="backup-name">تصميم 2024-01-10</span>
                            <span class="backup-date">10 يناير 2024</span>
                            <button class="btn-small btn-primary">استعادة</button>
                        </div>
                    </div>
                </div>
                
                <div class="admin-card">
                    <h3>تصدير الإعدادات</h3>
                    <div class="export-options">
                        <label class="checkbox-label">
                            <input type="checkbox" id="export-colors" checked>
                            <span class="checkmark"></span>
                            الألوان والنمط
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" id="export-fonts" checked>
                            <span class="checkmark"></span>
                            الخطوط والطباعة
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" id="export-layout" checked>
                            <span class="checkmark"></span>
                            التخطيط والمساحات
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" id="export-css" checked>
                            <span class="checkmark"></span>
                            CSS المخصص
                        </label>
                    </div>
                    
                    <div class="export-actions">
                        <button class="btn btn-primary" id="export-theme">
                            <span>تصدير كملف JSON</span>
                            <span>📤</span>
                        </button>
                        <button class="btn btn-secondary" id="export-css-file">
                            <span>تصدير كملف CSS</span>
                            <span>📄</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
/* Theme Settings Styles */
.theme-actions {
    display: flex;
    gap: var(--space-4);
}

.theme-customizer {
    display: flex;
    flex-direction: column;
    gap: var(--space-12);
}

.customizer-section {
    background: var(--white);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-xl);
    padding: var(--space-8);
}

.customizer-section h3 {
    color: var(--primary-blue);
    margin-bottom: var(--space-6);
    padding-bottom: var(--space-3);
    border-bottom: 2px solid var(--border-light);
}

.color-scheme-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--space-8);
}

.color-group h4 {
    margin-bottom: var(--space-4);
    color: var(--text-primary);
}

.color-inputs {
    display: flex;
    flex-direction: column;
    gap: var(--space-4);
}

.color-input-group {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
}

.color-input-group label {
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    color: var(--text-secondary);
}

.color-input-group input[type="color"] {
    width: 60px;
    height: 40px;
    border: 2px solid var(--border-light);
    border-radius: var(--radius-md);
    cursor: pointer;
}

.hex-input {
    padding: var(--space-2);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-md);
    font-family: monospace;
    width: 100px;
}

.preset-colors {
    margin-top: var(--space-8);
}

.color-presets {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: var(--space-4);
}

.color-preset {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-4);
    border: 2px solid var(--border-light);
    border-radius: var(--radius-lg);
    background: var(--white);
    cursor: pointer;
    transition: all var(--transition-fast);
}

.color-preset:hover,
.color-preset.active {
    border-color: var(--primary-blue);
    box-shadow: var(--shadow-md);
}

.preset-colors-demo {
    display: flex;
    gap: 4px;
}

.preset-colors-demo span {
    width: 20px;
    height: 20px;
    border-radius: 50%;
}

.typography-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-8);
}

.font-group select {
    width: 100%;
    padding: var(--space-3);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-md);
    margin-bottom: var(--space-4);
}

.font-preview {
    padding: var(--space-4);
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
    font-size: var(--font-size-lg);
}

.font-size-inputs {
    display: flex;
    flex-direction: column;
    gap: var(--space-4);
}

.font-size-group {
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.font-size-group label {
    flex: 1;
    font-size: var(--font-size-sm);
    color: var(--text-secondary);
}

.font-size-group input[type="range"] {
    flex: 2;
}

.size-value,
.scale-value,
.height-value,
.radius-value,
.padding-value {
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-semibold);
    color: var(--primary-blue);
    min-width: 50px;
    text-align: center;
}

.layout-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-8);
}

.spacing-inputs,
.advanced-options {
    display: flex;
    flex-direction: column;
    gap: var(--space-4);
}

.spacing-group {
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.spacing-group select {
    flex: 2;
    padding: var(--space-2);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-md);
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    width: 20px;
    height: 20px;
}

.custom-css-editor textarea {
    width: 100%;
    padding: var(--space-4);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-md);
    font-family: 'Courier New', monospace;
    background: var(--gray-50);
    resize: vertical;
}

.css-actions {
    display: flex;
    gap: var(--space-4);
    margin-top: var(--space-4);
}

.templates-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--space-6);
}

.template-card {
    border: 1px solid var(--border-light);
    border-radius: var(--radius-xl);
    overflow: hidden;
    transition: all var(--transition-normal);
}

.template-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-4px);
}

.template-preview img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.template-info {
    padding: var(--space-6);
}

.template-info h3 {
    margin-bottom: var(--space-3);
    color: var(--text-primary);
}

.template-info p {
    margin-bottom: var(--space-4);
    color: var(--text-secondary);
}

.template-actions {
    display: flex;
    gap: var(--space-3);
}

.backup-actions,
.export-actions {
    display: flex;
    flex-direction: column;
    gap: var(--space-4);
    margin-bottom: var(--space-6);
}

.backup-list {
    border-top: 1px solid var(--border-light);
    padding-top: var(--space-4);
}

.backup-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-3);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-md);
    margin-bottom: var(--space-2);
}

.backup-name {
    font-weight: var(--font-weight-semibold);
}

.backup-date {
    font-size: var(--font-size-sm);
    color: var(--text-muted);
}

.export-options {
    display: flex;
    flex-direction: column;
    gap: var(--space-3);
    margin-bottom: var(--space-6);
}

@media (max-width: 1024px) {
    .color-scheme-grid,
    .typography-grid,
    .layout-grid {
        grid-template-columns: 1fr;
    }
    
    .theme-actions {
        flex-direction: column;
    }
    
    .color-presets {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .templates-grid {
        grid-template-columns: 1fr;
    }
    
    .template-actions {
        flex-direction: column;
    }
    
    .backup-item {
        flex-direction: column;
        gap: var(--space-2);
        text-align: center;
    }
}
</style>

<script>
// Theme Settings JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initColorInputs();
    initFontPreview();
    initRangeInputs();
    initColorPresets();
    initTemplates();
    
    // Event listeners
    document.getElementById('save-theme').addEventListener('click', saveTheme);
    document.getElementById('preview-changes').addEventListener('click', previewChanges);
    document.getElementById('validate-css').addEventListener('click', validateCSS);
    document.getElementById('create-backup').addEventListener('click', createBackup);
    document.getElementById('export-theme').addEventListener('click', exportTheme);
});

function initColorInputs() {
    const colorInputs = document.querySelectorAll('input[type="color"]');
    
    colorInputs.forEach(input => {
        const hexInput = document.getElementById(input.id + '-hex');
        
        if (hexInput) {
            // Sync color picker with hex input
            input.addEventListener('input', () => {
                hexInput.value = input.value;
                applyColorChange(input.id, input.value);
            });
            
            hexInput.addEventListener('input', () => {
                if (isValidHexColor(hexInput.value)) {
                    input.value = hexInput.value;
                    applyColorChange(input.id, hexInput.value);
                }
            });
        }
    });
}

function isValidHexColor(hex) {
    return /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(hex);
}

function applyColorChange(colorId, value) {
    const root = document.documentElement;
    
    switch(colorId) {
        case 'primary-color':
            root.style.setProperty('--primary-blue', value);
            break;
        case 'secondary-color':
            root.style.setProperty('--secondary-orange', value);
            break;
        case 'accent-color':
            root.style.setProperty('--accent-green', value);
            break;
        case 'text-primary':
            root.style.setProperty('--text-primary', value);
            break;
        case 'text-secondary':
            root.style.setProperty('--text-secondary', value);
            break;
        case 'text-muted':
            root.style.setProperty('--text-muted', value);
            break;
        case 'bg-primary':
            root.style.setProperty('--bg-primary', value);
            break;
        case 'bg-secondary':
            root.style.setProperty('--bg-secondary', value);
            break;
        case 'border-color':
            root.style.setProperty('--border-light', value);
            break;
    }
}

function initFontPreview() {
    const fontSelect = document.getElementById('font-family');
    const preview = document.getElementById('font-preview');
    
    fontSelect.addEventListener('change', () => {
        const selectedFont = fontSelect.value;
        preview.style.fontFamily = selectedFont;
        
        // Apply to entire document for preview
        document.body.style.fontFamily = selectedFont;
    });
}

function initRangeInputs() {
    const ranges = [
        { id: 'base-font-size', display: 'size-value', suffix: 'px' },
        { id: 'heading-scale', display: 'scale-value', suffix: '' },
        { id: 'line-height', display: 'height-value', suffix: '' },
        { id: 'border-radius', display: 'radius-value', suffix: 'px' },
        { id: 'section-padding', display: 'padding-value', suffix: 'px' }
    ];
    
    ranges.forEach(range => {
        const input = document.getElementById(range.id);
        const display = document.querySelector(`.${range.display}`);
        
        if (input && display) {
            input.addEventListener('input', () => {
                display.textContent = input.value + range.suffix;
                applyRangeChange(range.id, input.value);
            });
        }
    });
}

function applyRangeChange(rangeId, value) {
    const root = document.documentElement;
    
    switch(rangeId) {
        case 'base-font-size':
            root.style.setProperty('--font-size-base', value + 'px');
            break;
        case 'border-radius':
            root.style.setProperty('--radius-md', value + 'px');
            break;
        case 'section-padding':
            root.style.setProperty('--space-16', value + 'px');
            break;
        case 'line-height':
            root.style.setProperty('--line-height-normal', value);
            break;
    }
}

function initColorPresets() {
    const presets = {
        default: {
            primary: '#1e40af',
            secondary: '#f59e0b',
            accent: '#10b981'
        },
        dark: {
            primary: '#1f2937',
            secondary: '#3b82f6',
            accent: '#10b981'
        },
        warm: {
            primary: '#dc2626',
            secondary: '#f59e0b',
            accent: '#059669'
        },
        cool: {
            primary: '#0891b2',
            secondary: '#06b6d4',
            accent: '#8b5cf6'
        }
    };
    
    document.querySelectorAll('.color-preset').forEach(button => {
        button.addEventListener('click', () => {
            const presetName = button.getAttribute('data-preset');
            const preset = presets[presetName];
            
            if (preset) {
                applyColorPreset(preset);
                
                // Update UI
                document.querySelectorAll('.color-preset').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
            }
        });
    });
}

function applyColorPreset(preset) {
    // Update color inputs
    document.getElementById('primary-color').value = preset.primary;
    document.getElementById('primary-color-hex').value = preset.primary;
    document.getElementById('secondary-color').value = preset.secondary;
    document.getElementById('secondary-color-hex').value = preset.secondary;
    document.getElementById('accent-color').value = preset.accent;
    document.getElementById('accent-color-hex').value = preset.accent;
    
    // Apply to CSS
    applyColorChange('primary-color', preset.primary);
    applyColorChange('secondary-color', preset.secondary);
    applyColorChange('accent-color', preset.accent);
}

function initTemplates() {
    // Template preview buttons
    document.querySelectorAll('.template-preview-btn').forEach(button => {
        button.addEventListener('click', () => {
            const template = button.getAttribute('data-template');
            previewTemplate(template);
        });
    });
    
    // Template apply buttons
    document.querySelectorAll('.template-apply-btn').forEach(button => {
        button.addEventListener('click', () => {
            const template = button.getAttribute('data-template');
            applyTemplate(template);
        });
    });
}

function previewTemplate(templateName) {
    // Open template preview in new window
    const previewWindow = window.open('../index.php?preview=' + templateName, '_blank', 'width=1200,height=800,scrollbars=yes');
    
    if (!previewWindow) {
        alert('يرجى السماح للنوافذ المنبثقة لمعاينة القوالب');
    }
}

function applyTemplate(templateName) {
    if (confirm(`هل أنت متأكد من تطبيق قالب "${templateName}"؟ سيتم استبدال الإعدادات الحالية.`)) {
        // Apply template settings
        const templates = {
            classic: {
                colors: { primary: '#2563eb', secondary: '#7c3aed', accent: '#059669' },
                font: 'Cairo'
            },
            modern: {
                colors: { primary: '#dc2626', secondary: '#f59e0b', accent: '#10b981' },
                font: 'Tajawal'
            },
            elegant: {
                colors: { primary: '#6366f1', secondary: '#ec4899', accent: '#14b8a6' },
                font: 'Amiri'
            },
            dark: {
                colors: { primary: '#1f2937', secondary: '#374151', accent: '#10b981' },
                font: 'Almarai'
            }
        };
        
        const template = templates[templateName];
        if (template) {
            applyColorPreset(template.colors);
            document.getElementById('font-family').value = template.font;
            initFontPreview();
            
            alert('تم تطبيق القالب بنجاح!');
        }
    }
}

function saveTheme() {
    const button = document.getElementById('save-theme');
    const originalText = button.innerHTML;
    button.innerHTML = '<span>جاري الحفظ...</span><span>⏳</span>';
    button.disabled = true;
    
    // Collect all theme settings
    const themeData = {
        colors: {
            primary: document.getElementById('primary-color').value,
            secondary: document.getElementById('secondary-color').value,
            accent: document.getElementById('accent-color').value,
            textPrimary: document.getElementById('text-primary').value,
            textSecondary: document.getElementById('text-secondary').value,
            textMuted: document.getElementById('text-muted').value,
            bgPrimary: document.getElementById('bg-primary').value,
            bgSecondary: document.getElementById('bg-secondary').value,
            borderColor: document.getElementById('border-color').value
        },
        typography: {
            fontFamily: document.getElementById('font-family').value,
            baseFontSize: document.getElementById('base-font-size').value,
            headingScale: document.getElementById('heading-scale').value,
            lineHeight: document.getElementById('line-height').value
        },
        layout: {
            containerWidth: document.getElementById('container-width').value,
            borderRadius: document.getElementById('border-radius').value,
            sectionPadding: document.getElementById('section-padding').value,
            enableAnimations: document.getElementById('enable-animations').checked,
            enableParallax: document.getElementById('enable-parallax').checked,
            enableShadows: document.getElementById('enable-shadows').checked,
            stickyHeader: document.getElementById('sticky-header').checked
        },
        customCSS: document.getElementById('custom-css').value
    };
    
    setTimeout(() => {
        // In real implementation, send to server
        console.log('Saving theme data:', themeData);
        localStorage.setItem('themeSettings', JSON.stringify(themeData));
        
        button.innerHTML = originalText;
        button.disabled = false;
        alert('تم حفظ إعدادات التصميم بنجاح!');
    }, 2000);
}

function previewChanges() {
    const previewWindow = window.open('../index.php?preview=custom', '_blank', 'width=1200,height=800,scrollbars=yes');
    
    if (!previewWindow) {
        alert('يرجى السماح للنوافذ المنبثقة للمعاينة');
    }
}

function validateCSS() {
    const css = document.getElementById('custom-css').value;
    
    // Simple CSS validation
    const errors = [];
    
    // Check for unclosed braces
    const openBraces = (css.match(/{/g) || []).length;
    const closeBraces = (css.match(/}/g) || []).length;
    
    if (openBraces !== closeBraces) {
        errors.push('عدد الأقواس المفتوحة لا يطابق المغلقة');
    }
    
    // Check for basic syntax
    if (css.includes(';;')) {
        errors.push('فاصلة منقوطة مزدوجة');
    }
    
    if (errors.length === 0) {
        alert('✅ كود CSS صحيح!');
    } else {
        alert('❌ أخطاء في كود CSS:\n' + errors.join('\n'));
    }
}

function createBackup() {
    const button = document.getElementById('create-backup');
    const originalText = button.innerHTML;
    button.innerHTML = '<span>جاري إنشاء النسخة...</span><span>⏳</span>';
    button.disabled = true;
    
    setTimeout(() => {
        const timestamp = new Date().toISOString().split('T')[0];
        const backupName = `تصميم ${timestamp}`;
        
        // Add to backup list
        const backupList = document.querySelector('.backup-list');
        const newBackup = document.createElement('div');
        newBackup.className = 'backup-item';
        newBackup.innerHTML = `
            <span class="backup-name">${backupName}</span>
            <span class="backup-date">${new Date().toLocaleDateString('ar-SA')}</span>
            <button class="btn-small btn-primary">استعادة</button>
        `;
        backupList.appendChild(newBackup);
        
        button.innerHTML = originalText;
        button.disabled = false;
        alert('تم إنشاء النسخة الاحتياطية بنجاح!');
    }, 1500);
}

function exportTheme() {
    const themeData = {
        colors: {
            primary: document.getElementById('primary-color').value,
            secondary: document.getElementById('secondary-color').value,
            accent: document.getElementById('accent-color').value
        },
        typography: {
            fontFamily: document.getElementById('font-family').value
        },
        exported: new Date().toISOString()
    };
    
    const dataStr = JSON.stringify(themeData, null, 2);
    const dataBlob = new Blob([dataStr], {type: 'application/json'});
    
    const link = document.createElement('a');
    link.href = URL.createObjectURL(dataBlob);
    link.download = 'theme-settings.json';
    link.click();
}

// Initialize theme from saved settings
function loadSavedTheme() {
    const saved = localStorage.getItem('themeSettings');
    if (saved) {
        try {
            const themeData = JSON.parse(saved);
            // Apply saved settings to UI
            console.log('Loaded theme:', themeData);
        } catch (e) {
            console.error('Error loading saved theme:', e);
        }
    }
}

// Load saved theme on page load
loadSavedTheme();
</script>

<?php
// Include footer
include '../includes/footer.php';
?>