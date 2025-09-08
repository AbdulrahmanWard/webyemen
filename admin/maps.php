<?php
// Admin Maps Management Page
$page_title = 'إدارة الخرائط - لوحة التحكم';
$page_description = 'إدارة خريطة الموقع وفهرسة المحتوى';
$body_class = 'admin-page maps-page';

// Simple authentication check (in real implementation, use proper authentication)
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    // For demo purposes, set session
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
                <li><a href="maps.php" class="active">الخرائط</a></li>
                <li><a href="seo.php">SEO</a></li>
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
            <h1>إدارة الخرائط والفهرسة</h1>
            <p>إدارة خريطة الموقع وتحسين فهرسة المحتوى في محركات البحث</p>
        </div>

        <!-- Sitemap Section -->
        <div class="admin-section">
            <div class="section-header">
                <h2>خريطة الموقع XML</h2>
                <button class="btn btn-primary" id="generate-sitemap">
                    <span>إنشاء خريطة جديدة</span>
                    <span>🗺️</span>
                </button>
            </div>
            
            <div class="admin-card">
                <div class="sitemap-status">
                    <div class="status-item">
                        <span class="status-label">حالة الخريطة:</span>
                        <span class="status-value success">محدثة</span>
                    </div>
                    <div class="status-item">
                        <span class="status-label">آخر تحديث:</span>
                        <span class="status-value"><?php echo date('Y-m-d H:i:s'); ?></span>
                    </div>
                    <div class="status-item">
                        <span class="status-label">عدد الصفحات:</span>
                        <span class="status-value">127</span>
                    </div>
                </div>
                
                <div class="sitemap-actions">
                    <a href="../sitemap.xml" class="btn btn-secondary" target="_blank">
                        <span>عرض الخريطة</span>
                        <span>👁️</span>
                    </a>
                    <button class="btn btn-outline" id="validate-sitemap">
                        <span>التحقق من صحة الخريطة</span>
                        <span>✅</span>
                    </button>
                    <button class="btn btn-outline" id="submit-google">
                        <span>إرسال لـ Google</span>
                        <span>🚀</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- URL Management -->
        <div class="admin-section">
            <div class="section-header">
                <h2>إدارة الروابط</h2>
                <button class="btn btn-primary" id="add-url">
                    <span>إضافة رابط جديد</span>
                    <span>➕</span>
                </button>
            </div>
            
            <div class="admin-card">
                <div class="urls-table-container">
                    <table class="urls-table">
                        <thead>
                            <tr>
                                <th>الرابط</th>
                                <th>الأولوية</th>
                                <th>تكرار التحديث</th>
                                <th>آخر تعديل</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody id="urls-table-body">
                            <!-- URLs will be loaded dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- HTML Sitemap -->
        <div class="admin-section">
            <div class="section-header">
                <h2>خريطة الموقع HTML</h2>
                <button class="btn btn-primary" id="generate-html-sitemap">
                    <span>إنشاء خريطة HTML</span>
                    <span>📄</span>
                </button>
            </div>
            
            <div class="admin-card">
                <div class="html-sitemap-preview" id="html-sitemap-preview">
                    <div class="sitemap-structure">
                        <div class="sitemap-category">
                            <h3>الصفحات الرئيسية</h3>
                            <ul>
                                <li><a href="../index.php">الصفحة الرئيسية</a></li>
                                <li><a href="../about.php">من نحن</a></li>
                                <li><a href="../contact.php">تواصل معنا</a></li>
                            </ul>
                        </div>
                        
                        <div class="sitemap-category">
                            <h3>الخدمات</h3>
                            <ul>
                                <li><a href="../services/thermal-insulation.php">العزل الحراري</a></li>
                                <li><a href="../services/water-insulation.php">العزل المائي</a></li>
                                <li><a href="../services/renovation.php">أعمال الترميم</a></li>
                                <li><a href="../services/maintenance.php">الصيانة الدورية</a></li>
                            </ul>
                        </div>
                        
                        <div class="sitemap-category">
                            <h3>المشاريع</h3>
                            <ul>
                                <li><a href="../projects.php">جميع المشاريع</a></li>
                                <li><a href="../projects/residential.php">المشاريع السكنية</a></li>
                                <li><a href="../projects/commercial.php">المشاريع التجارية</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Indexing Status -->
        <div class="admin-section">
            <div class="section-header">
                <h2>حالة الفهرسة</h2>
                <button class="btn btn-primary" id="check-indexing">
                    <span>فحص الفهرسة</span>
                    <span>🔍</span>
                </button>
            </div>
            
            <div class="grid grid-cols-3">
                <div class="admin-card indexing-card">
                    <div class="indexing-icon google">🌐</div>
                    <h3>Google</h3>
                    <div class="indexing-stats">
                        <div class="stat-item">
                            <span class="stat-label">مفهرسة:</span>
                            <span class="stat-value">95</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">معلقة:</span>
                            <span class="stat-value">12</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">مرفوضة:</span>
                            <span class="stat-value">3</span>
                        </div>
                    </div>
                </div>
                
                <div class="admin-card indexing-card">
                    <div class="indexing-icon bing">🔍</div>
                    <h3>Bing</h3>
                    <div class="indexing-stats">
                        <div class="stat-item">
                            <span class="stat-label">مفهرسة:</span>
                            <span class="stat-value">87</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">معلقة:</span>
                            <span class="stat-value">18</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">مرفوضة:</span>
                            <span class="stat-value">5</span>
                        </div>
                    </div>
                </div>
                
                <div class="admin-card indexing-card">
                    <div class="indexing-icon yandex">🔎</div>
                    <h3>Yandex</h3>
                    <div class="indexing-stats">
                        <div class="stat-item">
                            <span class="stat-label">مفهرسة:</span>
                            <span class="stat-value">78</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">معلقة:</span>
                            <span class="stat-value">22</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">مرفوضة:</span>
                            <span class="stat-value">7</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- URL Management Modal -->
<div class="modal" id="url-modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>إدارة الرابط</h3>
            <button class="modal-close">&times;</button>
        </div>
        <form class="url-form" id="url-form">
            <div class="form-group">
                <label for="url-path">مسار الرابط</label>
                <input type="text" id="url-path" name="path" required placeholder="/services/thermal-insulation.php">
            </div>
            
            <div class="form-group">
                <label for="url-priority">الأولوية</label>
                <select id="url-priority" name="priority">
                    <option value="1.0">عالية جداً (1.0)</option>
                    <option value="0.8" selected>عالية (0.8)</option>
                    <option value="0.6">متوسطة (0.6)</option>
                    <option value="0.4">منخفضة (0.4)</option>
                    <option value="0.2">منخفضة جداً (0.2)</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="url-changefreq">تكرار التحديث</label>
                <select id="url-changefreq" name="changefreq">
                    <option value="always">دائماً</option>
                    <option value="hourly">كل ساعة</option>
                    <option value="daily">يومياً</option>
                    <option value="weekly" selected>أسبوعياً</option>
                    <option value="monthly">شهرياً</option>
                    <option value="yearly">سنوياً</option>
                    <option value="never">أبداً</option>
                </select>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">حفظ</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal()">إلغاء</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Admin Styles */
.admin-nav {
    background: var(--gray-800);
    padding: var(--space-4) 0;
    margin-bottom: var(--space-8);
}

.admin-nav-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.admin-logo h2 {
    color: var(--white);
    margin: 0;
}

.admin-menu {
    display: flex;
    list-style: none;
    gap: var(--space-6);
    margin: 0;
    padding: 0;
}

.admin-menu a {
    color: var(--gray-300);
    text-decoration: none;
    padding: var(--space-2) var(--space-4);
    border-radius: var(--radius-md);
    transition: all var(--transition-fast);
}

.admin-menu a:hover,
.admin-menu a.active {
    background: var(--primary-blue);
    color: var(--white);
}

.admin-content {
    min-height: 60vh;
    padding-bottom: var(--space-16);
}

.admin-header {
    margin-bottom: var(--space-12);
}

.admin-header h1 {
    color: var(--primary-blue);
    margin-bottom: var(--space-2);
}

.admin-section {
    margin-bottom: var(--space-12);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-6);
}

.section-header h2 {
    color: var(--text-primary);
    margin: 0;
}

.admin-card {
    background: var(--white);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-xl);
    padding: var(--space-8);
    box-shadow: var(--shadow-sm);
}

.sitemap-status {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--space-6);
    margin-bottom: var(--space-8);
}

.status-item {
    text-align: center;
}

.status-label {
    display: block;
    font-size: var(--font-size-sm);
    color: var(--text-muted);
    margin-bottom: var(--space-2);
}

.status-value {
    display: block;
    font-size: var(--font-size-xl);
    font-weight: var(--font-weight-bold);
    color: var(--text-primary);
}

.status-value.success {
    color: var(--accent-green);
}

.sitemap-actions {
    display: flex;
    gap: var(--space-4);
    justify-content: center;
    flex-wrap: wrap;
}

.urls-table-container {
    overflow-x: auto;
}

.urls-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: var(--space-4);
}

.urls-table th,
.urls-table td {
    padding: var(--space-3);
    text-align: right;
    border-bottom: 1px solid var(--border-light);
}

.urls-table th {
    background: var(--bg-secondary);
    font-weight: var(--font-weight-semibold);
    color: var(--text-primary);
}

.sitemap-structure {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--space-6);
}

.sitemap-category h3 {
    color: var(--primary-blue);
    margin-bottom: var(--space-4);
}

.sitemap-category ul {
    list-style: none;
    padding: 0;
}

.sitemap-category li {
    margin-bottom: var(--space-2);
}

.sitemap-category a {
    color: var(--text-secondary);
    text-decoration: none;
}

.sitemap-category a:hover {
    color: var(--primary-blue);
}

.indexing-card {
    text-align: center;
}

.indexing-icon {
    font-size: 3rem;
    margin-bottom: var(--space-4);
}

.indexing-stats {
    margin-top: var(--space-4);
}

.stat-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: var(--space-2);
    padding: var(--space-2) 0;
    border-bottom: 1px solid var(--border-light);
}

.stat-item:last-child {
    border-bottom: none;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-content {
    background: var(--white);
    padding: var(--space-8);
    border-radius: var(--radius-xl);
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-6);
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: var(--text-muted);
}

.form-actions {
    display: flex;
    gap: var(--space-4);
    justify-content: flex-end;
    margin-top: var(--space-6);
}

.btn-outline {
    background: transparent;
    color: var(--primary-blue);
    border: 2px solid var(--primary-blue);
}

.btn-outline:hover {
    background: var(--primary-blue);
    color: var(--white);
}

@media (max-width: 768px) {
    .admin-nav-content {
        flex-direction: column;
        gap: var(--space-4);
    }
    
    .admin-menu {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .section-header {
        flex-direction: column;
        gap: var(--space-4);
    }
    
    .sitemap-status {
        grid-template-columns: 1fr;
    }
    
    .sitemap-actions {
        flex-direction: column;
    }
}
</style>

<script>
// Maps Management JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Load URLs table
    loadUrlsTable();
    
    // Event listeners
    document.getElementById('generate-sitemap').addEventListener('click', generateSitemap);
    document.getElementById('add-url').addEventListener('click', openUrlModal);
    document.getElementById('url-form').addEventListener('submit', saveUrl);
    document.getElementById('generate-html-sitemap').addEventListener('click', generateHtmlSitemap);
    document.getElementById('check-indexing').addEventListener('click', checkIndexing);
});

function loadUrlsTable() {
    const tbody = document.getElementById('urls-table-body');
    
    // Sample data - in real implementation, load from server
    const urls = [
        { path: '/index.php', priority: '1.0', changefreq: 'weekly', lastmod: '2024-01-15', status: 'مفهرسة' },
        { path: '/services/thermal-insulation.php', priority: '0.8', changefreq: 'monthly', lastmod: '2024-01-10', status: 'مفهرسة' },
        { path: '/services/water-insulation.php', priority: '0.8', changefreq: 'monthly', lastmod: '2024-01-10', status: 'معلقة' },
        { path: '/about.php', priority: '0.6', changefreq: 'yearly', lastmod: '2024-01-01', status: 'مفهرسة' },
        { path: '/contact.php', priority: '0.7', changefreq: 'monthly', lastmod: '2024-01-12', status: 'مفهرسة' }
    ];
    
    tbody.innerHTML = urls.map(url => `
        <tr>
            <td>${url.path}</td>
            <td>${url.priority}</td>
            <td>${url.changefreq}</td>
            <td>${url.lastmod}</td>
            <td><span class="status ${url.status === 'مفهرسة' ? 'success' : 'pending'}">${url.status}</span></td>
            <td>
                <button class="btn-small btn-primary" onclick="editUrl('${url.path}')">تعديل</button>
                <button class="btn-small btn-secondary" onclick="deleteUrl('${url.path}')">حذف</button>
            </td>
        </tr>
    `).join('');
}

function generateSitemap() {
    // Show loading state
    const button = document.getElementById('generate-sitemap');
    const originalText = button.innerHTML;
    button.innerHTML = '<span>جاري الإنشاء...</span><span>⏳</span>';
    button.disabled = true;
    
    // Simulate sitemap generation
    setTimeout(() => {
        alert('تم إنشاء خريطة الموقع بنجاح!');
        button.innerHTML = originalText;
        button.disabled = false;
        
        // Update last modified time
        document.querySelector('.status-value:nth-of-type(2)').textContent = new Date().toLocaleString('ar-SA');
    }, 2000);
}

function openUrlModal() {
    document.getElementById('url-modal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('url-modal').style.display = 'none';
    document.getElementById('url-form').reset();
}

function saveUrl(e) {
    e.preventDefault();
    
    // Get form data
    const formData = new FormData(e.target);
    const urlData = {
        path: formData.get('path'),
        priority: formData.get('priority'),
        changefreq: formData.get('changefreq')
    };
    
    // In real implementation, send to server
    console.log('Saving URL:', urlData);
    
    alert('تم حفظ الرابط بنجاح!');
    closeModal();
    loadUrlsTable();
}

function editUrl(path) {
    // In real implementation, load URL data and populate form
    openUrlModal();
}

function deleteUrl(path) {
    if (confirm('هل أنت متأكد من حذف هذا الرابط؟')) {
        // In real implementation, send delete request to server
        alert('تم حذف الرابط بنجاح!');
        loadUrlsTable();
    }
}

function generateHtmlSitemap() {
    alert('تم إنشاء خريطة الموقع HTML بنجاح!');
}

function checkIndexing() {
    const button = document.getElementById('check-indexing');
    const originalText = button.innerHTML;
    button.innerHTML = '<span>جاري الفحص...</span><span>⏳</span>';
    button.disabled = true;
    
    setTimeout(() => {
        alert('تم فحص حالة الفهرسة بنجاح!');
        button.innerHTML = originalText;
        button.disabled = false;
    }, 3000);
}

// Close modal on outside click
document.getElementById('url-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Add some additional styles for buttons
const additionalStyles = `
.btn-small {
    padding: 4px 8px;
    font-size: 12px;
    margin: 0 2px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.status {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: bold;
}

.status.success {
    background: #d1fae5;
    color: #065f46;
}

.status.pending {
    background: #fef3c7;
    color: #92400e;
}
`;

const styleSheet = document.createElement('style');
styleSheet.textContent = additionalStyles;
document.head.appendChild(styleSheet);
</script>

<?php
// Include footer
include '../includes/footer.php';
?>