<?php
// Admin Cache Management Page
$page_title = 'إدارة الكاش - لوحة التحكم';
$page_description = 'إدارة ذاكرة التخزين المؤقت وتحسين أداء الموقع';
$body_class = 'admin-page cache-page';

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
                <li><a href="theme-settings.php">الإعدادات</a></li>
                <li><a href="cache-management.php" class="active">الكاش</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="admin-content">
    <div class="container">
        
        <!-- Page Header -->
        <div class="admin-header">
            <h1>إدارة الكاش والأداء</h1>
            <p>مراقبة وإدارة ذاكرة التخزين المؤقت لتحسين سرعة وأداء الموقع</p>
        </div>

        <!-- Cache Overview -->
        <div class="admin-section">
            <div class="section-header">
                <h2>نظرة عامة على الكاش</h2>
                <button class="btn btn-primary" id="refresh-stats">
                    <span>تحديث الإحصائيات</span>
                    <span>🔄</span>
                </button>
            </div>
            
            <div class="grid grid-cols-4">
                <div class="admin-card cache-stat-card">
                    <div class="cache-stat-icon">💾</div>
                    <div class="cache-stat-value">2.3 MB</div>
                    <div class="cache-stat-label">حجم الكاش الإجمالي</div>
                    <div class="cache-stat-change positive">+15%</div>
                </div>
                
                <div class="admin-card cache-stat-card">
                    <div class="cache-stat-icon">⚡</div>
                    <div class="cache-stat-value">94%</div>
                    <div class="cache-stat-label">معدل نجاح الكاش</div>
                    <div class="cache-stat-change positive">+2.1%</div>
                </div>
                
                <div class="admin-card cache-stat-card">
                    <div class="cache-stat-icon">🎯</div>
                    <div class="cache-stat-value">1,247</div>
                    <div class="cache-stat-label">عدد الملفات المخزنة</div>
                    <div class="cache-stat-change positive">+89</div>
                </div>
                
                <div class="admin-card cache-stat-card">
                    <div class="cache-stat-icon">⏱️</div>
                    <div class="cache-stat-value">0.8s</div>
                    <div class="cache-stat-label">متوسط وقت التحميل</div>
                    <div class="cache-stat-change positive">-0.2s</div>
                </div>
            </div>
        </div>

        <!-- Cache Types -->
        <div class="admin-section">
            <div class="section-header">
                <h2>أنواع الكاش</h2>
                <button class="btn btn-primary" id="clear-all-cache">
                    <span>مسح جميع الكاش</span>
                    <span>🗑️</span>
                </button>
            </div>
            
            <div class="grid grid-cols-3">
                <!-- Page Cache -->
                <div class="admin-card cache-type-card">
                    <div class="cache-type-header">
                        <div class="cache-type-icon">📄</div>
                        <h3>كاش الصفحات</h3>
                        <div class="cache-status active">مفعل</div>
                    </div>
                    
                    <div class="cache-type-stats">
                        <div class="stat-row">
                            <span>الحجم:</span>
                            <span>850 KB</span>
                        </div>
                        <div class="stat-row">
                            <span>عدد الملفات:</span>
                            <span>45</span>
                        </div>
                        <div class="stat-row">
                            <span>آخر تحديث:</span>
                            <span>5 دقائق</span>
                        </div>
                    </div>
                    
                    <div class="cache-type-actions">
                        <button class="btn btn-secondary" onclick="clearCache('page')">
                            <span>مسح</span>
                            <span>🗑️</span>
                        </button>
                        <button class="btn btn-outline" onclick="regenerateCache('page')">
                            <span>إعادة إنشاء</span>
                            <span>🔄</span>
                        </button>
                    </div>
                </div>
                
                <!-- CSS/JS Cache -->
                <div class="admin-card cache-type-card">
                    <div class="cache-type-header">
                        <div class="cache-type-icon">🎨</div>
                        <h3>كاش CSS/JS</h3>
                        <div class="cache-status active">مفعل</div>
                    </div>
                    
                    <div class="cache-type-stats">
                        <div class="stat-row">
                            <span>الحجم:</span>
                            <span>1.2 MB</span>
                        </div>
                        <div class="stat-row">
                            <span>عدد الملفات:</span>
                            <span>23</span>
                        </div>
                        <div class="stat-row">
                            <span>آخر تحديث:</span>
                            <span>2 ساعات</span>
                        </div>
                    </div>
                    
                    <div class="cache-type-actions">
                        <button class="btn btn-secondary" onclick="clearCache('assets')">
                            <span>مسح</span>
                            <span>🗑️</span>
                        </button>
                        <button class="btn btn-outline" onclick="regenerateCache('assets')">
                            <span>إعادة إنشاء</span>
                            <span>🔄</span>
                        </button>
                    </div>
                </div>
                
                <!-- Image Cache -->
                <div class="admin-card cache-type-card">
                    <div class="cache-type-header">
                        <div class="cache-type-icon">🖼️</div>
                        <h3>كاش الصور</h3>
                        <div class="cache-status active">مفعل</div>
                    </div>
                    
                    <div class="cache-type-stats">
                        <div class="stat-row">
                            <span>الحجم:</span>
                            <span>5.7 MB</span>
                        </div>
                        <div class="stat-row">
                            <span>عدد الملفات:</span>
                            <span>156</span>
                        </div>
                        <div class="stat-row">
                            <span>آخر تحديث:</span>
                            <span>1 يوم</span>
                        </div>
                    </div>
                    
                    <div class="cache-type-actions">
                        <button class="btn btn-secondary" onclick="clearCache('images')">
                            <span>مسح</span>
                            <span>🗑️</span>
                        </button>
                        <button class="btn btn-outline" onclick="regenerateCache('images')">
                            <span>تحسين</span>
                            <span>⚡</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cache Settings -->
        <div class="admin-section">
            <div class="section-header">
                <h2>إعدادات الكاش</h2>
                <button class="btn btn-primary" id="save-cache-settings">
                    <span>حفظ الإعدادات</span>
                    <span>💾</span>
                </button>
            </div>
            
            <div class="admin-card">
                <form class="cache-settings-form" id="cache-settings-form">
                    <div class="settings-grid">
                        <div class="setting-group">
                            <h4>إعدادات عامة</h4>
                            
                            <div class="setting-item">
                                <label class="setting-label">
                                    <input type="checkbox" id="enable-cache" checked>
                                    <span class="checkmark"></span>
                                    تفعيل نظام الكاش
                                </label>
                                <p class="setting-description">تمكين ذاكرة التخزين المؤقت لتحسين الأداء</p>
                            </div>
                            
                            <div class="setting-item">
                                <label class="setting-label">
                                    <input type="checkbox" id="enable-compression" checked>
                                    <span class="checkmark"></span>
                                    ضغط الملفات (Gzip)
                                </label>
                                <p class="setting-description">ضغط الملفات لتقليل حجم البيانات المنقولة</p>
                            </div>
                            
                            <div class="setting-item">
                                <label class="setting-label">
                                    <input type="checkbox" id="enable-browser-cache" checked>
                                    <span class="checkmark"></span>
                                    كاش المتصفح
                                </label>
                                <p class="setting-description">السماح للمتصفحات بحفظ الملفات محلياً</p>
                            </div>
                        </div>
                        
                        <div class="setting-group">
                            <h4>مدة الصلاحية</h4>
                            
                            <div class="setting-item">
                                <label for="page-cache-duration">كاش الصفحات</label>
                                <select id="page-cache-duration" name="page-cache-duration">
                                    <option value="300">5 دقائق</option>
                                    <option value="900">15 دقيقة</option>
                                    <option value="1800" selected>30 دقيقة</option>
                                    <option value="3600">ساعة واحدة</option>
                                    <option value="86400">يوم واحد</option>
                                </select>
                            </div>
                            
                            <div class="setting-item">
                                <label for="asset-cache-duration">ملفات CSS/JS</label>
                                <select id="asset-cache-duration" name="asset-cache-duration">
                                    <option value="3600">ساعة واحدة</option>
                                    <option value="86400">يوم واحد</option>
                                    <option value="604800" selected>أسبوع واحد</option>
                                    <option value="2592000">شهر واحد</option>
                                    <option value="31536000">سنة واحدة</option>
                                </select>
                            </div>
                            
                            <div class="setting-item">
                                <label for="image-cache-duration">كاش الصور</label>
                                <select id="image-cache-duration" name="image-cache-duration">
                                    <option value="86400">يوم واحد</option>
                                    <option value="604800">أسبوع واحد</option>
                                    <option value="2592000" selected>شهر واحد</option>
                                    <option value="31536000">سنة واحدة</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="setting-group">
                            <h4>تحسينات متقدمة</h4>
                            
                            <div class="setting-item">
                                <label class="setting-label">
                                    <input type="checkbox" id="enable-lazy-loading" checked>
                                    <span class="checkmark"></span>
                                    التحميل البطيء للصور
                                </label>
                                <p class="setting-description">تحميل الصور عند الحاجة فقط</p>
                            </div>
                            
                            <div class="setting-item">
                                <label class="setting-label">
                                    <input type="checkbox" id="enable-webp" checked>
                                    <span class="checkmark"></span>
                                    تحويل الصور إلى WebP
                                </label>
                                <p class="setting-description">استخدام تنسيق WebP المحسن للصور</p>
                            </div>
                            
                            <div class="setting-item">
                                <label class="setting-label">
                                    <input type="checkbox" id="enable-minification">
                                    <span class="checkmark"></span>
                                    ضغط CSS/JS
                                </label>
                                <p class="setting-description">إزالة المسافات والتعليقات من الملفات</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Performance Monitor -->
        <div class="admin-section">
            <div class="section-header">
                <h2>مراقب الأداء</h2>
                <button class="btn btn-primary" id="run-performance-test">
                    <span>اختبار الأداء</span>
                    <span>🚀</span>
                </button>
            </div>
            
            <div class="grid grid-cols-2">
                <div class="admin-card">
                    <h3>سرعة التحميل</h3>
                    <div class="performance-chart">
                        <canvas id="speed-chart" width="400" height="200"></canvas>
                    </div>
                    <div class="performance-metrics">
                        <div class="metric">
                            <span class="metric-label">TTFB (Time to First Byte):</span>
                            <span class="metric-value good">0.2s</span>
                        </div>
                        <div class="metric">
                            <span class="metric-label">First Contentful Paint:</span>
                            <span class="metric-value good">0.8s</span>
                        </div>
                        <div class="metric">
                            <span class="metric-label">Largest Contentful Paint:</span>
                            <span class="metric-value warning">2.1s</span>
                        </div>
                        <div class="metric">
                            <span class="metric-label">Cumulative Layout Shift:</span>
                            <span class="metric-value good">0.05</span>
                        </div>
                    </div>
                </div>
                
                <div class="admin-card">
                    <h3>استخدام الموارد</h3>
                    <div class="resource-usage">
                        <div class="resource-item">
                            <span class="resource-label">استخدام المعالج</span>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 35%"></div>
                            </div>
                            <span class="resource-value">35%</span>
                        </div>
                        
                        <div class="resource-item">
                            <span class="resource-label">استخدام الذاكرة</span>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 68%"></div>
                            </div>
                            <span class="resource-value">68%</span>
                        </div>
                        
                        <div class="resource-item">
                            <span class="resource-label">مساحة التخزين</span>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 42%"></div>
                            </div>
                            <span class="resource-value">42%</span>
                        </div>
                        
                        <div class="resource-item">
                            <span class="resource-label">استخدام الشبكة</span>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 25%"></div>
                            </div>
                            <span class="resource-value">25%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cache Logs -->
        <div class="admin-section">
            <div class="section-header">
                <h2>سجلات الكاش</h2>
                <div class="log-actions">
                    <button class="btn btn-secondary" id="export-logs">
                        <span>تصدير السجلات</span>
                        <span>📥</span>
                    </button>
                    <button class="btn btn-outline" id="clear-logs">
                        <span>مسح السجلات</span>
                        <span>🗑️</span>
                    </button>
                </div>
            </div>
            
            <div class="admin-card">
                <div class="logs-container">
                    <div class="log-filters">
                        <select id="log-level-filter">
                            <option value="all">جميع المستويات</option>
                            <option value="info">معلومات</option>
                            <option value="warning">تحذيرات</option>
                            <option value="error">أخطاء</option>
                        </select>
                        
                        <input type="date" id="log-date-filter" value="<?php echo date('Y-m-d'); ?>">
                        
                        <button class="btn btn-secondary" id="filter-logs">تصفية</button>
                    </div>
                    
                    <div class="logs-table-container">
                        <table class="logs-table">
                            <thead>
                                <tr>
                                    <th>الوقت</th>
                                    <th>المستوى</th>
                                    <th>النوع</th>
                                    <th>الرسالة</th>
                                    <th>الملف</th>
                                </tr>
                            </thead>
                            <tbody id="logs-table-body">
                                <!-- Logs will be populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
/* Cache Management Styles */
.cache-stat-card {
    text-align: center;
    padding: var(--space-6);
}

.cache-stat-icon {
    font-size: 2.5rem;
    margin-bottom: var(--space-3);
}

.cache-stat-value {
    font-size: 2rem;
    font-weight: var(--font-weight-bold);
    color: var(--primary-blue);
    margin-bottom: var(--space-2);
}

.cache-stat-label {
    color: var(--text-muted);
    font-size: var(--font-size-sm);
    margin-bottom: var(--space-2);
}

.cache-stat-change {
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-semibold);
}

.cache-stat-change.positive {
    color: var(--accent-green);
}

.cache-stat-change.negative {
    color: var(--accent-red);
}

.cache-type-card {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.cache-type-header {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    margin-bottom: var(--space-4);
    padding-bottom: var(--space-3);
    border-bottom: 1px solid var(--border-light);
}

.cache-type-icon {
    font-size: 1.5rem;
}

.cache-type-header h3 {
    flex: 1;
    margin: 0;
    color: var(--text-primary);
}

.cache-status {
    padding: var(--space-1) var(--space-3);
    border-radius: var(--radius-full);
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-semibold);
}

.cache-status.active {
    background: rgba(16, 185, 129, 0.1);
    color: var(--accent-green);
}

.cache-status.inactive {
    background: rgba(239, 68, 68, 0.1);
    color: var(--accent-red);
}

.cache-type-stats {
    flex: 1;
    margin-bottom: var(--space-4);
}

.stat-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: var(--space-2);
    padding: var(--space-2) 0;
    border-bottom: 1px solid var(--border-light);
}

.stat-row:last-child {
    border-bottom: none;
}

.cache-type-actions {
    display: flex;
    gap: var(--space-2);
}

.settings-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--space-8);
}

.setting-group h4 {
    margin-bottom: var(--space-6);
    color: var(--primary-blue);
    padding-bottom: var(--space-2);
    border-bottom: 2px solid var(--border-light);
}

.setting-item {
    margin-bottom: var(--space-6);
}

.setting-label {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    cursor: pointer;
    font-weight: var(--font-weight-medium);
}

.setting-label input[type="checkbox"] {
    width: 20px;
    height: 20px;
}

.setting-description {
    font-size: var(--font-size-sm);
    color: var(--text-muted);
    margin: var(--space-2) 0 0 var(--space-8);
}

.setting-item label:not(.setting-label) {
    display: block;
    font-weight: var(--font-weight-medium);
    margin-bottom: var(--space-2);
    color: var(--text-primary);
}

.setting-item select {
    width: 100%;
    padding: var(--space-2);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-md);
}

.performance-chart {
    margin-bottom: var(--space-6);
    text-align: center;
}

.performance-metrics {
    display: flex;
    flex-direction: column;
    gap: var(--space-3);
}

.metric {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-2);
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
}

.metric-label {
    font-size: var(--font-size-sm);
    color: var(--text-secondary);
}

.metric-value {
    font-weight: var(--font-weight-bold);
}

.metric-value.good {
    color: var(--accent-green);
}

.metric-value.warning {
    color: #f59e0b;
}

.metric-value.poor {
    color: var(--accent-red);
}

.resource-usage {
    display: flex;
    flex-direction: column;
    gap: var(--space-4);
}

.resource-item {
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.resource-label {
    flex: 1;
    font-size: var(--font-size-sm);
    color: var(--text-secondary);
}

.progress-bar {
    flex: 2;
    height: 8px;
    background: var(--border-light);
    border-radius: var(--radius-full);
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--accent-green), var(--primary-blue));
    transition: width var(--transition-normal);
}

.resource-value {
    font-weight: var(--font-weight-semibold);
    color: var(--primary-blue);
    min-width: 40px;
    text-align: center;
}

.log-actions {
    display: flex;
    gap: var(--space-4);
}

.logs-container {
    max-height: 500px;
    overflow-y: auto;
}

.log-filters {
    display: flex;
    gap: var(--space-4);
    margin-bottom: var(--space-6);
    align-items: center;
}

.log-filters select,
.log-filters input {
    padding: var(--space-2);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-md);
}

.logs-table-container {
    overflow-x: auto;
}

.logs-table {
    width: 100%;
    border-collapse: collapse;
    font-size: var(--font-size-sm);
}

.logs-table th,
.logs-table td {
    padding: var(--space-3);
    text-align: right;
    border-bottom: 1px solid var(--border-light);
}

.logs-table th {
    background: var(--bg-secondary);
    font-weight: var(--font-weight-semibold);
    color: var(--text-primary);
    position: sticky;
    top: 0;
}

.log-level-info {
    color: var(--primary-blue);
}

.log-level-warning {
    color: #f59e0b;
}

.log-level-error {
    color: var(--accent-red);
}

@media (max-width: 1024px) {
    .settings-grid {
        grid-template-columns: 1fr;
    }
    
    .log-actions {
        flex-direction: column;
    }
}

@media (max-width: 768px) {
    .cache-type-actions {
        flex-direction: column;
    }
    
    .log-filters {
        flex-direction: column;
        align-items: stretch;
    }
    
    .resource-item {
        flex-direction: column;
        align-items: stretch;
        gap: var(--space-2);
    }
}
</style>

<script>
// Cache Management JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initPerformanceChart();
    loadCacheLogs();
    
    // Event listeners
    document.getElementById('refresh-stats').addEventListener('click', refreshStats);
    document.getElementById('clear-all-cache').addEventListener('click', clearAllCache);
    document.getElementById('save-cache-settings').addEventListener('click', saveCacheSettings);
    document.getElementById('run-performance-test').addEventListener('click', runPerformanceTest);
    document.getElementById('export-logs').addEventListener('click', exportLogs);
    document.getElementById('clear-logs').addEventListener('click', clearLogs);
    document.getElementById('filter-logs').addEventListener('click', filterLogs);
});

function initPerformanceChart() {
    const canvas = document.getElementById('speed-chart');
    const ctx = canvas.getContext('2d');
    
    // Sample data for demonstration
    const data = {
        labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '24:00'],
        datasets: [{
            label: 'وقت التحميل (ثانية)',
            data: [0.8, 0.7, 1.2, 1.5, 1.1, 0.9, 0.8],
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            fill: true,
            tension: 0.4
        }]
    };
    
    // Simple line chart implementation
    drawLineChart(ctx, data);
}

function drawLineChart(ctx, data) {
    const canvas = ctx.canvas;
    const width = canvas.width;
    const height = canvas.height;
    const padding = 40;
    
    // Clear canvas
    ctx.clearRect(0, 0, width, height);
    
    // Draw background
    ctx.fillStyle = '#f9fafb';
    ctx.fillRect(0, 0, width, height);
    
    // Calculate chart area
    const chartWidth = width - (padding * 2);
    const chartHeight = height - (padding * 2);
    
    const maxValue = Math.max(...data.datasets[0].data) * 1.2;
    const minValue = 0;
    
    // Draw grid lines
    ctx.strokeStyle = '#e5e7eb';
    ctx.lineWidth = 1;
    
    for (let i = 0; i <= 5; i++) {
        const y = padding + (chartHeight * i / 5);
        ctx.beginPath();
        ctx.moveTo(padding, y);
        ctx.lineTo(width - padding, y);
        ctx.stroke();
    }
    
    // Draw data line
    ctx.strokeStyle = '#3b82f6';
    ctx.lineWidth = 3;
    ctx.beginPath();
    
    data.datasets[0].data.forEach((value, index) => {
        const x = padding + (chartWidth * index / (data.datasets[0].data.length - 1));
        const y = height - padding - ((value - minValue) / (maxValue - minValue)) * chartHeight;
        
        if (index === 0) {
            ctx.moveTo(x, y);
        } else {
            ctx.lineTo(x, y);
        }
    });
    
    ctx.stroke();
    
    // Draw data points
    ctx.fillStyle = '#3b82f6';
    data.datasets[0].data.forEach((value, index) => {
        const x = padding + (chartWidth * index / (data.datasets[0].data.length - 1));
        const y = height - padding - ((value - minValue) / (maxValue - minValue)) * chartHeight;
        
        ctx.beginPath();
        ctx.arc(x, y, 4, 0, 2 * Math.PI);
        ctx.fill();
    });
    
    // Draw labels
    ctx.fillStyle = '#6b7280';
    ctx.font = '12px Arial';
    ctx.textAlign = 'center';
    
    data.labels.forEach((label, index) => {
        const x = padding + (chartWidth * index / (data.labels.length - 1));
        ctx.fillText(label, x, height - 10);
    });
}

function loadCacheLogs() {
    const tbody = document.getElementById('logs-table-body');
    
    // Sample log data
    const logs = [
        { time: '14:35:22', level: 'info', type: 'Page Cache', message: 'تم تحديث كاش الصفحة الرئيسية', file: 'index.php' },
        { time: '14:33:15', level: 'warning', type: 'CSS Cache', message: 'فشل في ضغط ملف main.css', file: 'main.css' },
        { time: '14:30:48', level: 'info', type: 'Image Cache', message: 'تم تحسين 15 صورة', file: 'multiple' },
        { time: '14:28:33', level: 'error', type: 'Asset Cache', message: 'خطأ في قراءة ملف animations.js', file: 'animations.js' },
        { time: '14:25:10', level: 'info', type: 'Page Cache', message: 'تم مسح كاش الصفحات المنتهية الصلاحية', file: 'cleanup' }
    ];
    
    tbody.innerHTML = logs.map(log => `
        <tr>
            <td>${log.time}</td>
            <td><span class="log-level-${log.level}">${getLogLevelText(log.level)}</span></td>
            <td>${log.type}</td>
            <td>${log.message}</td>
            <td>${log.file}</td>
        </tr>
    `).join('');
}

function getLogLevelText(level) {
    const levels = {
        'info': 'معلومات',
        'warning': 'تحذير',
        'error': 'خطأ'
    };
    return levels[level] || level;
}

function refreshStats() {
    const button = document.getElementById('refresh-stats');
    const originalText = button.innerHTML;
    button.innerHTML = '<span>جاري التحديث...</span><span>⏳</span>';
    button.disabled = true;
    
    setTimeout(() => {
        // Update cache statistics with random values for demo
        const statValues = document.querySelectorAll('.cache-stat-value');
        statValues.forEach(stat => {
            const currentValue = parseFloat(stat.textContent);
            const newValue = currentValue + (Math.random() - 0.5) * 0.1;
            
            if (stat.textContent.includes('MB')) {
                stat.textContent = newValue.toFixed(1) + ' MB';
            } else if (stat.textContent.includes('%')) {
                stat.textContent = Math.round(newValue) + '%';
            } else if (stat.textContent.includes('s')) {
                stat.textContent = newValue.toFixed(1) + 's';
            } else {
                stat.textContent = Math.round(newValue).toLocaleString('ar-SA');
            }
        });
        
        button.innerHTML = originalText;
        button.disabled = false;
        alert('تم تحديث الإحصائيات بنجاح!');
    }, 2000);
}

function clearCache(type) {
    const typeNames = {
        'page': 'الصفحات',
        'assets': 'CSS/JS',
        'images': 'الصور'
    };
    
    if (confirm(`هل أنت متأكد من مسح كاش ${typeNames[type]}؟`)) {
        // Show loading state
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '<span>جاري المسح...</span><span>⏳</span>';
        button.disabled = true;
        
        setTimeout(() => {
            // Reset cache stats for this type
            const card = button.closest('.cache-type-card');
            const statsRows = card.querySelectorAll('.stat-row span:last-child');
            
            if (statsRows[0]) statsRows[0].textContent = '0 KB';
            if (statsRows[1]) statsRows[1].textContent = '0';
            if (statsRows[2]) statsRows[2].textContent = 'الآن';
            
            button.innerHTML = originalText;
            button.disabled = false;
            alert(`تم مسح كاش ${typeNames[type]} بنجاح!`);
        }, 1500);
    }
}

function regenerateCache(type) {
    const typeNames = {
        'page': 'الصفحات',
        'assets': 'CSS/JS',
        'images': 'الصور'
    };
    
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<span>جاري الإنشاء...</span><span>⏳</span>';
    button.disabled = true;
    
    setTimeout(() => {
        // Simulate cache regeneration
        const card = button.closest('.cache-type-card');
        const statsRows = card.querySelectorAll('.stat-row span:last-child');
        
        // Update stats with new values
        if (type === 'page') {
            if (statsRows[0]) statsRows[0].textContent = '950 KB';
            if (statsRows[1]) statsRows[1].textContent = '52';
        } else if (type === 'assets') {
            if (statsRows[0]) statsRows[0].textContent = '1.4 MB';
            if (statsRows[1]) statsRows[1].textContent = '28';
        } else if (type === 'images') {
            if (statsRows[0]) statsRows[0].textContent = '4.2 MB';
            if (statsRows[1]) statsRows[1].textContent = '142';
        }
        
        if (statsRows[2]) statsRows[2].textContent = 'الآن';
        
        button.innerHTML = originalText;
        button.disabled = false;
        alert(`تم إعادة إنشاء كاش ${typeNames[type]} بنجاح!`);
    }, 3000);
}

function clearAllCache() {
    if (confirm('هل أنت متأكد من مسح جميع أنواع الكاش؟ قد يؤثر هذا على أداء الموقع مؤقتاً.')) {
        const button = document.getElementById('clear-all-cache');
        const originalText = button.innerHTML;
        button.innerHTML = '<span>جاري المسح...</span><span>⏳</span>';
        button.disabled = true;
        
        setTimeout(() => {
            // Reset all cache stats
            document.querySelectorAll('.cache-type-card .stat-row span:last-child').forEach((span, index) => {
                if (index % 3 === 0) span.textContent = '0 KB';
                else if (index % 3 === 1) span.textContent = '0';
                else span.textContent = 'الآن';
            });
            
            button.innerHTML = originalText;
            button.disabled = false;
            alert('تم مسح جميع أنواع الكاش بنجاح!');
        }, 4000);
    }
}

function saveCacheSettings() {
    const button = document.getElementById('save-cache-settings');
    const originalText = button.innerHTML;
    button.innerHTML = '<span>جاري الحفظ...</span><span>⏳</span>';
    button.disabled = true;
    
    // Collect form data
    const formData = new FormData(document.getElementById('cache-settings-form'));
    const settings = {
        enableCache: document.getElementById('enable-cache').checked,
        enableCompression: document.getElementById('enable-compression').checked,
        enableBrowserCache: document.getElementById('enable-browser-cache').checked,
        enableLazyLoading: document.getElementById('enable-lazy-loading').checked,
        enableWebP: document.getElementById('enable-webp').checked,
        enableMinification: document.getElementById('enable-minification').checked,
        pageCacheDuration: document.getElementById('page-cache-duration').value,
        assetCacheDuration: document.getElementById('asset-cache-duration').value,
        imageCacheDuration: document.getElementById('image-cache-duration').value
    };
    
    setTimeout(() => {
        // In real implementation, send to server
        console.log('Saving cache settings:', settings);
        localStorage.setItem('cacheSettings', JSON.stringify(settings));
        
        button.innerHTML = originalText;
        button.disabled = false;
        alert('تم حفظ إعدادات الكاش بنجاح!');
    }, 2000);
}

function runPerformanceTest() {
    const button = document.getElementById('run-performance-test');
    const originalText = button.innerHTML;
    button.innerHTML = '<span>جاري الاختبار...</span><span>⏳</span>';
    button.disabled = true;
    
    setTimeout(() => {
        // Update performance metrics with new values
        const metrics = document.querySelectorAll('.metric-value');
        const newValues = ['0.18s', '0.75s', '1.9s', '0.03'];
        
        metrics.forEach((metric, index) => {
            if (newValues[index]) {
                metric.textContent = newValues[index];
                
                // Update color based on performance
                metric.className = 'metric-value ' + (Math.random() > 0.7 ? 'warning' : 'good');
            }
        });
        
        // Regenerate chart with new data
        initPerformanceChart();
        
        button.innerHTML = originalText;
        button.disabled = false;
        alert('تم اكتمال اختبار الأداء بنجاح!');
    }, 5000);
}

function exportLogs() {
    // Create CSV content
    const logs = Array.from(document.querySelectorAll('#logs-table-body tr')).map(row => {
        const cells = row.querySelectorAll('td');
        return Array.from(cells).map(cell => cell.textContent).join(',');
    });
    
    const csvContent = 'الوقت,المستوى,النوع,الرسالة,الملف\n' + logs.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'cache-logs-' + new Date().toISOString().split('T')[0] + '.csv';
    link.click();
}

function clearLogs() {
    if (confirm('هل أنت متأكد من مسح جميع السجلات؟')) {
        document.getElementById('logs-table-body').innerHTML = '<tr><td colspan="5" style="text-align: center; color: var(--text-muted);">لا توجد سجلات</td></tr>';
        alert('تم مسح السجلات بنجاح!');
    }
}

function filterLogs() {
    const level = document.getElementById('log-level-filter').value;
    const date = document.getElementById('log-date-filter').value;
    
    // In real implementation, filter logs based on criteria
    alert(`تصفية السجلات: المستوى = ${level}, التاريخ = ${date}`);
    
    // Reload logs with filters applied
    loadCacheLogs();
}
</script>

<?php
// Include footer
include '../includes/footer.php';
?>