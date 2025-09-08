<?php
// Admin SEO Management Page
$page_title = 'تحسين محركات البحث - لوحة التحكم';
$page_description = 'إدارة وتحسين محركات البحث وتحليل الأداء';
$body_class = 'admin-page seo-page';

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
                <li><a href="seo.php" class="active">SEO</a></li>
                <li><a href="theme-settings.php">الإعدادات</a></li>
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
            <h1>تحسين محركات البحث (SEO)</h1>
            <p>إدارة وتحسين ظهور الموقع في نتائج البحث وتحليل الأداء</p>
        </div>

        <!-- SEO Overview -->
        <div class="admin-section">
            <div class="section-header">
                <h2>نظرة عامة على الأداء</h2>
                <button class="btn btn-primary" id="refresh-data">
                    <span>تحديث البيانات</span>
                    <span>🔄</span>
                </button>
            </div>
            
            <div class="grid grid-cols-4">
                <div class="admin-card metric-card">
                    <div class="metric-icon">📈</div>
                    <div class="metric-value">2,547</div>
                    <div class="metric-label">الزوار الشهريين</div>
                    <div class="metric-change positive">+12.5%</div>
                </div>
                
                <div class="admin-card metric-card">
                    <div class="metric-icon">🔍</div>
                    <div class="metric-value">1,832</div>
                    <div class="metric-label">الزوار من البحث</div>
                    <div class="metric-change positive">+18.2%</div>
                </div>
                
                <div class="admin-card metric-card">
                    <div class="metric-icon">⏱️</div>
                    <div class="metric-value">3.2</div>
                    <div class="metric-label">متوسط مدة الجلسة</div>
                    <div class="metric-change negative">-2.1%</div>
                </div>
                
                <div class="admin-card metric-card">
                    <div class="metric-icon">📊</div>
                    <div class="metric-value">65%</div>
                    <div class="metric-label">معدل الارتداد</div>
                    <div class="metric-change positive">-5.3%</div>
                </div>
            </div>
        </div>

        <!-- Meta Tags Management -->
        <div class="admin-section">
            <div class="section-header">
                <h2>إدارة العلامات الوصفية</h2>
                <button class="btn btn-primary" id="add-meta-tag">
                    <span>إضافة علامة جديدة</span>
                    <span>➕</span>
                </button>
            </div>
            
            <div class="admin-card">
                <div class="tabs">
                    <button class="tab-button active" data-tab="general">عامة</button>
                    <button class="tab-button" data-tab="og">Open Graph</button>
                    <button class="tab-button" data-tab="twitter">Twitter Cards</button>
                    <button class="tab-button" data-tab="schema">Schema.org</button>
                </div>
                
                <!-- General Meta Tags -->
                <div class="tab-content active" id="general-tab">
                    <form class="meta-form">
                        <div class="form-group">
                            <label for="page-title">عنوان الصفحة</label>
                            <input type="text" id="page-title" name="title" value="الدمام للعوازل والترميم - شركة رائدة في العزل والترميم" maxlength="60">
                            <div class="char-count">60/60</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="meta-description">الوصف التعريفي</label>
                            <textarea id="meta-description" name="description" maxlength="155" rows="3">شركة الدمام للعوازل والترميم تقدم خدمات متميزة في العزل الحراري والمائي وأعمال الترميم بأعلى معايير الجودة والمهنية في المملكة العربية السعودية منذ أكثر من 15 عاماً</textarea>
                            <div class="char-count">155/155</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="meta-keywords">الكلمات المفتاحية</label>
                            <input type="text" id="meta-keywords" name="keywords" value="العزل الحراري, العزل المائي, ترميم المباني, شركة عزل, الدمام, السعودية">
                        </div>
                        
                        <div class="form-group">
                            <label for="canonical-url">الرابط الأساسي</label>
                            <input type="url" id="canonical-url" name="canonical" value="https://dammam-insulation.com/">
                        </div>
                    </form>
                </div>
                
                <!-- Open Graph Meta Tags -->
                <div class="tab-content" id="og-tab">
                    <form class="meta-form">
                        <div class="form-group">
                            <label for="og-title">عنوان Open Graph</label>
                            <input type="text" id="og-title" name="og:title" value="الدمام للعوازل والترميم">
                        </div>
                        
                        <div class="form-group">
                            <label for="og-description">وصف Open Graph</label>
                            <textarea id="og-description" name="og:description" rows="3">خدمات العزل والترميم المتخصصة</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="og-image">صورة Open Graph</label>
                            <input type="url" id="og-image" name="og:image" value="/assets/images/og-image.jpg">
                        </div>
                        
                        <div class="form-group">
                            <label for="og-type">نوع المحتوى</label>
                            <select id="og-type" name="og:type">
                                <option value="website" selected>موقع إلكتروني</option>
                                <option value="article">مقال</option>
                                <option value="business.business">عمل تجاري</option>
                            </select>
                        </div>
                    </form>
                </div>
                
                <!-- Twitter Cards -->
                <div class="tab-content" id="twitter-tab">
                    <form class="meta-form">
                        <div class="form-group">
                            <label for="twitter-card">نوع البطاقة</label>
                            <select id="twitter-card" name="twitter:card">
                                <option value="summary" selected>ملخص</option>
                                <option value="summary_large_image">ملخص بصورة كبيرة</option>
                                <option value="app">تطبيق</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="twitter-title">العنوان</label>
                            <input type="text" id="twitter-title" name="twitter:title" value="الدمام للعوازل والترميم">
                        </div>
                        
                        <div class="form-group">
                            <label for="twitter-description">الوصف</label>
                            <textarea id="twitter-description" name="twitter:description" rows="3">خدمات العزل والترميم المتخصصة</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="twitter-image">الصورة</label>
                            <input type="url" id="twitter-image" name="twitter:image" value="/assets/images/twitter-card.jpg">
                        </div>
                    </form>
                </div>
                
                <!-- Schema.org -->
                <div class="tab-content" id="schema-tab">
                    <div class="schema-editor">
                        <h3>بيانات منظمة - Schema.org</h3>
                        <textarea id="schema-json" rows="15" class="schema-textarea">{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "شركة الدمام للعوازل والترميم",
  "image": "https://dammam-insulation.com/assets/images/logo.png",
  "description": "شركة متخصصة في خدمات العزل الحراري والمائي وأعمال الترميم",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "شارع الملك عبدالعزيز",
    "addressLocality": "الدمام",
    "addressRegion": "المنطقة الشرقية",
    "addressCountry": "SA"
  },
  "telephone": "+966-13-000-0000",
  "url": "https://dammam-insulation.com",
  "sameAs": [
    "https://www.facebook.com/dammam.insulation",
    "https://www.instagram.com/dammam.insulation"
  ],
  "openingHours": "Mo-Sa 08:00-18:00",
  "priceRange": "$$"
}</textarea>
                        <button type="button" class="btn btn-secondary" id="validate-schema">
                            <span>التحقق من صحة البيانات</span>
                            <span>✅</span>
                        </button>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-primary" id="save-meta">
                        <span>حفظ التغييرات</span>
                        <span>💾</span>
                    </button>
                    <button type="button" class="btn btn-secondary" id="preview-meta">
                        <span>معاينة النتائج</span>
                        <span>👁️</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Keywords Analysis -->
        <div class="admin-section">
            <div class="section-header">
                <h2>تحليل الكلمات المفتاحية</h2>
                <button class="btn btn-primary" id="analyze-keywords">
                    <span>تحليل جديد</span>
                    <span>🔬</span>
                </button>
            </div>
            
            <div class="grid grid-cols-2">
                <div class="admin-card">
                    <h3>الكلمات الأكثر أداءً</h3>
                    <div class="keywords-list">
                        <div class="keyword-item">
                            <span class="keyword">العزل الحراري الدمام</span>
                            <span class="position">المركز 3</span>
                            <span class="clicks">245 نقرة</span>
                        </div>
                        <div class="keyword-item">
                            <span class="keyword">شركة عزل مائي</span>
                            <span class="position">المركز 5</span>
                            <span class="clicks">189 نقرة</span>
                        </div>
                        <div class="keyword-item">
                            <span class="keyword">ترميم منازل السعودية</span>
                            <span class="position">المركز 7</span>
                            <span class="clicks">156 نقرة</span>
                        </div>
                        <div class="keyword-item">
                            <span class="keyword">عزل أسطح الرياض</span>
                            <span class="position">المركز 12</span>
                            <span class="clicks">98 نقرة</span>
                        </div>
                    </div>
                </div>
                
                <div class="admin-card">
                    <h3>فرص التحسين</h3>
                    <div class="opportunities-list">
                        <div class="opportunity-item">
                            <span class="keyword">عزل حراري للمباني</span>
                            <span class="potential">إمكانية عالية</span>
                            <span class="volume">1,200 بحث/شهر</span>
                        </div>
                        <div class="opportunity-item">
                            <span class="keyword">ترميم فلل الخبر</span>
                            <span class="potential">إمكانية متوسطة</span>
                            <span class="volume">800 بحث/شهر</span>
                        </div>
                        <div class="opportunity-item">
                            <span class="keyword">شركات العزل المائي</span>
                            <span class="potential">إمكانية عالية</span>
                            <span class="volume">950 بحث/شهر</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Analysis -->
        <div class="admin-section">
            <div class="section-header">
                <h2>تحليل الأداء التقني</h2>
                <button class="btn btn-primary" id="run-audit">
                    <span>تشغيل فحص شامل</span>
                    <span>🔍</span>
                </button>
            </div>
            
            <div class="grid grid-cols-3">
                <div class="admin-card performance-card">
                    <div class="performance-score">
                        <div class="score-circle good">
                            <span class="score-value">85</span>
                        </div>
                        <h3>سرعة الموقع</h3>
                    </div>
                    <ul class="performance-details">
                        <li class="good">وقت التحميل: 2.1 ثانية</li>
                        <li class="good">أول محتوى مرئي: 1.3 ثانية</li>
                        <li class="warning">أكبر محتوى مرئي: 2.8 ثانية</li>
                        <li class="good">التفاعل الأول: 0.8 ثانية</li>
                    </ul>
                </div>
                
                <div class="admin-card performance-card">
                    <div class="performance-score">
                        <div class="score-circle excellent">
                            <span class="score-value">92</span>
                        </div>
                        <h3>إمكانية الوصول</h3>
                    </div>
                    <ul class="performance-details">
                        <li class="good">نصوص بديلة للصور</li>
                        <li class="good">تباين الألوان</li>
                        <li class="good">التنقل بلوحة المفاتيح</li>
                        <li class="warning">تسميات النماذج</li>
                    </ul>
                </div>
                
                <div class="admin-card performance-card">
                    <div class="performance-score">
                        <div class="score-circle good">
                            <span class="score-value">78</span>
                        </div>
                        <h3>أفضل الممارسات</h3>
                    </div>
                    <ul class="performance-details">
                        <li class="good">HTTPS مفعل</li>
                        <li class="good">أمان الموقع</li>
                        <li class="warning">ضغط الصور</li>
                        <li class="warning">ذاكرة التخزين المؤقت</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Recommendations -->
        <div class="admin-section">
            <div class="section-header">
                <h2>توصيات التحسين</h2>
            </div>
            
            <div class="admin-card">
                <div class="recommendations-list">
                    <div class="recommendation-item high-priority">
                        <div class="priority-badge high">أولوية عالية</div>
                        <div class="recommendation-content">
                            <h3>تحسين سرعة تحميل الصور</h3>
                            <p>ضغط الصور وتحويلها إلى صيغة WebP يمكن أن يحسن سرعة التحميل بنسبة 30%</p>
                            <div class="recommendation-actions">
                                <button class="btn btn-small btn-primary">تطبيق الآن</button>
                                <button class="btn btn-small btn-secondary">تفاصيل أكثر</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="recommendation-item medium-priority">
                        <div class="priority-badge medium">أولوية متوسطة</div>
                        <div class="recommendation-content">
                            <h3>إضافة المزيد من المحتوى المحلي</h3>
                            <p>إنشاء صفحات مخصصة لكل مدينة يخدمها الموقع لتحسين البحث المحلي</p>
                            <div class="recommendation-actions">
                                <button class="btn btn-small btn-primary">تطبيق الآن</button>
                                <button class="btn btn-small btn-secondary">تفاصيل أكثر</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="recommendation-item low-priority">
                        <div class="priority-badge low">أولوية منخفضة</div>
                        <div class="recommendation-content">
                            <h3>تحديث المحتوى القديم</h3>
                            <p>مراجعة وتحديث المحتوى الذي لم يتم تحديثه منذ أكثر من 6 أشهر</p>
                            <div class="recommendation-actions">
                                <button class="btn btn-small btn-primary">تطبيق الآن</button>
                                <button class="btn btn-small btn-secondary">تفاصيل أكثر</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
/* SEO Admin Styles */
.metric-card {
    text-align: center;
    padding: var(--space-6);
}

.metric-icon {
    font-size: 2.5rem;
    margin-bottom: var(--space-3);
}

.metric-value {
    font-size: 2rem;
    font-weight: var(--font-weight-bold);
    color: var(--primary-blue);
    margin-bottom: var(--space-2);
}

.metric-label {
    color: var(--text-muted);
    font-size: var(--font-size-sm);
    margin-bottom: var(--space-2);
}

.metric-change {
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-semibold);
}

.metric-change.positive {
    color: var(--accent-green);
}

.metric-change.negative {
    color: var(--accent-red);
}

.tabs {
    display: flex;
    border-bottom: 2px solid var(--border-light);
    margin-bottom: var(--space-6);
}

.tab-button {
    padding: var(--space-3) var(--space-6);
    background: none;
    border: none;
    cursor: pointer;
    color: var(--text-muted);
    border-bottom: 2px solid transparent;
    transition: all var(--transition-fast);
}

.tab-button.active,
.tab-button:hover {
    color: var(--primary-blue);
    border-bottom-color: var(--primary-blue);
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

.char-count {
    font-size: var(--font-size-xs);
    color: var(--text-muted);
    text-align: left;
    margin-top: var(--space-1);
}

.schema-textarea {
    width: 100%;
    font-family: monospace;
    background: var(--gray-50);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-md);
    padding: var(--space-4);
    resize: vertical;
}

.keywords-list,
.opportunities-list {
    display: flex;
    flex-direction: column;
    gap: var(--space-3);
}

.keyword-item,
.opportunity-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-3);
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
}

.keyword {
    font-weight: var(--font-weight-semibold);
}

.position,
.clicks,
.potential,
.volume {
    font-size: var(--font-size-sm);
    color: var(--text-muted);
}

.performance-card {
    text-align: center;
}

.performance-score {
    margin-bottom: var(--space-6);
}

.score-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto var(--space-4);
    border: 4px solid;
}

.score-circle.excellent {
    border-color: var(--accent-green);
    background: rgba(16, 185, 129, 0.1);
}

.score-circle.good {
    border-color: #f59e0b;
    background: rgba(245, 158, 11, 0.1);
}

.score-circle.poor {
    border-color: var(--accent-red);
    background: rgba(239, 68, 68, 0.1);
}

.score-value {
    font-size: 1.5rem;
    font-weight: var(--font-weight-bold);
}

.performance-details {
    list-style: none;
    padding: 0;
    text-align: right;
}

.performance-details li {
    padding: var(--space-2) 0;
    border-bottom: 1px solid var(--border-light);
    font-size: var(--font-size-sm);
}

.performance-details li:last-child {
    border-bottom: none;
}

.performance-details li.good:before {
    content: "✅ ";
}

.performance-details li.warning:before {
    content: "⚠️ ";
}

.performance-details li.error:before {
    content: "❌ ";
}

.recommendations-list {
    display: flex;
    flex-direction: column;
    gap: var(--space-4);
}

.recommendation-item {
    display: flex;
    gap: var(--space-4);
    padding: var(--space-4);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-lg);
    background: var(--bg-secondary);
}

.priority-badge {
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-full);
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-semibold);
    white-space: nowrap;
    align-self: flex-start;
}

.priority-badge.high {
    background: rgba(239, 68, 68, 0.1);
    color: var(--accent-red);
}

.priority-badge.medium {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}

.priority-badge.low {
    background: rgba(16, 185, 129, 0.1);
    color: var(--accent-green);
}

.recommendation-content {
    flex: 1;
}

.recommendation-content h3 {
    margin-bottom: var(--space-2);
    color: var(--text-primary);
}

.recommendation-content p {
    margin-bottom: var(--space-4);
    color: var(--text-secondary);
}

.recommendation-actions {
    display: flex;
    gap: var(--space-2);
}

@media (max-width: 768px) {
    .tabs {
        flex-wrap: wrap;
    }
    
    .tab-button {
        flex: 1;
        min-width: 120px;
    }
    
    .recommendation-item {
        flex-direction: column;
    }
    
    .recommendation-actions {
        justify-content: flex-start;
    }
}
</style>

<script>
// SEO Management JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    initTabs();
    
    // Character counters
    initCharCounters();
    
    // Event listeners
    document.getElementById('refresh-data').addEventListener('click', refreshData);
    document.getElementById('save-meta').addEventListener('click', saveMeta);
    document.getElementById('preview-meta').addEventListener('click', previewMeta);
    document.getElementById('validate-schema').addEventListener('click', validateSchema);
    document.getElementById('analyze-keywords').addEventListener('click', analyzeKeywords);
    document.getElementById('run-audit').addEventListener('click', runAudit);
});

function initTabs() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetTab = button.getAttribute('data-tab');
            
            // Remove active class from all tabs
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding content
            button.classList.add('active');
            document.getElementById(targetTab + '-tab').classList.add('active');
        });
    });
}

function initCharCounters() {
    const inputs = document.querySelectorAll('[maxlength]');
    
    inputs.forEach(input => {
        const maxLength = input.getAttribute('maxlength');
        const counter = input.parentNode.querySelector('.char-count');
        
        if (counter) {
            updateCharCount(input, counter, maxLength);
            
            input.addEventListener('input', () => {
                updateCharCount(input, counter, maxLength);
            });
        }
    });
}

function updateCharCount(input, counter, maxLength) {
    const currentLength = input.value.length;
    counter.textContent = `${currentLength}/${maxLength}`;
    
    if (currentLength > maxLength * 0.9) {
        counter.style.color = 'var(--accent-red)';
    } else if (currentLength > maxLength * 0.7) {
        counter.style.color = '#f59e0b';
    } else {
        counter.style.color = 'var(--text-muted)';
    }
}

function refreshData() {
    const button = document.getElementById('refresh-data');
    const originalText = button.innerHTML;
    button.innerHTML = '<span>جاري التحديث...</span><span>⏳</span>';
    button.disabled = true;
    
    setTimeout(() => {
        // Simulate data refresh
        const metrics = document.querySelectorAll('.metric-value');
        metrics.forEach(metric => {
            const currentValue = parseInt(metric.textContent.replace(/[^0-9]/g, ''));
            const newValue = currentValue + Math.floor(Math.random() * 100);
            metric.textContent = newValue.toLocaleString('ar-SA');
        });
        
        button.innerHTML = originalText;
        button.disabled = false;
        alert('تم تحديث البيانات بنجاح!');
    }, 2000);
}

function saveMeta() {
    const button = document.getElementById('save-meta');
    const originalText = button.innerHTML;
    button.innerHTML = '<span>جاري الحفظ...</span><span>⏳</span>';
    button.disabled = true;
    
    // Collect form data from all tabs
    const formData = new FormData();
    
    // General meta tags
    const generalInputs = document.querySelectorAll('#general-tab input, #general-tab textarea');
    generalInputs.forEach(input => {
        formData.append(input.name, input.value);
    });
    
    // Open Graph tags
    const ogInputs = document.querySelectorAll('#og-tab input, #og-tab textarea, #og-tab select');
    ogInputs.forEach(input => {
        formData.append(input.name, input.value);
    });
    
    // Twitter Cards
    const twitterInputs = document.querySelectorAll('#twitter-tab input, #twitter-tab textarea, #twitter-tab select');
    twitterInputs.forEach(input => {
        formData.append(input.name, input.value);
    });
    
    // Schema.org
    const schemaData = document.getElementById('schema-json').value;
    formData.append('schema', schemaData);
    
    setTimeout(() => {
        // In real implementation, send to server
        console.log('Saving meta data:', Object.fromEntries(formData));
        
        button.innerHTML = originalText;
        button.disabled = false;
        alert('تم حفظ البيانات التعريفية بنجاح!');
    }, 1500);
}

function previewMeta() {
    // Create preview popup
    const preview = window.open('', '_blank', 'width=800,height=600,scrollbars=yes');
    
    const title = document.getElementById('page-title').value;
    const description = document.getElementById('meta-description').value;
    const ogImage = document.getElementById('og-image').value;
    
    preview.document.write(`
        <!DOCTYPE html>
        <html lang="ar" dir="rtl">
        <head>
            <meta charset="UTF-8">
            <title>معاينة النتائج في محركات البحث</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
                .search-result { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
                .result-title { color: #1a0dab; font-size: 20px; margin-bottom: 5px; text-decoration: none; }
                .result-url { color: #006621; font-size: 14px; margin-bottom: 5px; }
                .result-description { color: #545454; line-height: 1.4; }
                .social-preview { background: white; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; margin: 20px 0; max-width: 500px; }
                .social-image { width: 100%; height: 200px; background: #eee; display: flex; align-items: center; justify-content: center; }
                .social-content { padding: 15px; }
                .social-title { font-weight: bold; margin-bottom: 5px; }
                .social-description { color: #666; font-size: 14px; }
            </style>
        </head>
        <body>
            <h1>معاينة النتائج</h1>
            
            <h2>نتيجة البحث في Google</h2>
            <div class="search-result">
                <a href="#" class="result-title">${title}</a>
                <div class="result-url">https://dammam-insulation.com</div>
                <div class="result-description">${description}</div>
            </div>
            
            <h2>معاينة Facebook/Open Graph</h2>
            <div class="social-preview">
                <div class="social-image">صورة Open Graph</div>
                <div class="social-content">
                    <div class="social-title">${title}</div>
                    <div class="social-description">${description}</div>
                </div>
            </div>
            
            <h2>معاينة Twitter Card</h2>
            <div class="social-preview">
                <div class="social-image">صورة Twitter Card</div>
                <div class="social-content">
                    <div class="social-title">${title}</div>
                    <div class="social-description">${description}</div>
                </div>
            </div>
        </body>
        </html>
    `);
}

function validateSchema() {
    const schemaData = document.getElementById('schema-json').value;
    
    try {
        JSON.parse(schemaData);
        alert('✅ البيانات المنظمة صحيحة وجاهزة للاستخدام!');
    } catch (error) {
        alert('❌ خطأ في تنسيق JSON: ' + error.message);
    }
}

function analyzeKeywords() {
    const button = document.getElementById('analyze-keywords');
    const originalText = button.innerHTML;
    button.innerHTML = '<span>جاري التحليل...</span><span>⏳</span>';
    button.disabled = true;
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
        alert('تم تحليل الكلمات المفتاحية بنجاح!');
    }, 3000);
}

function runAudit() {
    const button = document.getElementById('run-audit');
    const originalText = button.innerHTML;
    button.innerHTML = '<span>جاري الفحص...</span><span>⏳</span>';
    button.disabled = true;
    
    setTimeout(() => {
        // Update performance scores randomly for demo
        const scores = document.querySelectorAll('.score-value');
        scores.forEach(score => {
            const newScore = Math.floor(Math.random() * 30) + 70;
            score.textContent = newScore;
            
            const circle = score.parentNode;
            circle.className = 'score-circle';
            if (newScore >= 90) circle.classList.add('excellent');
            else if (newScore >= 70) circle.classList.add('good');
            else circle.classList.add('poor');
        });
        
        button.innerHTML = originalText;
        button.disabled = false;
        alert('تم إجراء الفحص الشامل بنجاح!');
    }, 4000);
}
</script>

<?php
// Include footer
include '../includes/footer.php';
?>