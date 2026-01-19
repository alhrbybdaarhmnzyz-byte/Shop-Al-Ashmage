<?php
require_once __DIR__.'/../Others/init.php';

UserController::requireAdmin();
UserController::requireLogin();
$products = ProductData::getAllProducts();
$productController = new ProductController();
$productController->perform();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <nav class="navbar">
    
            <ul class="nav-links">

    <li><a href="logout.php">تسجيل الخروج</a></li>
    <li><a href="orders.php">الطلبات </a></li>
</ul>
        </nav>
    </header>

    <main class="main-content">
        <div class="admin-container">
            <h2>لوحة تحكم المدير</h2>
            
            <section class="admin-section">
    <h3>إدارة المنتجات</h3>
    <ul class="admin-list">
        <?php foreach($products as $product): ?>
            <li class="admin-list-item">
                <form method="POST" class="edit-product-form">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
                    
                    <div class="product-fields">
                        <input type="text" name="name" value="<?= htmlspecialchars($product->getName()) ?>" 
                               class="product-input" placeholder="اسم المنتج" required>
                        
                        <input type="number" step="0.01" name="price1" value="<?= $product->getPrice1() ?>" 
                               class="product-input price-input" placeholder="السعر" required>
                        
                        <input type="number" step="0.01" name="price2" value="<?= $product->getPrice2() ?>" 
                               class="product-input price-input" placeholder="سعر العرض">
                        
                        <input type="text" name="image" value="<?= htmlspecialchars($product->getImage()) ?>" 
                               class="product-input" placeholder="رابط الصورة" required>
                    </div>
                    
                    <div class="actions">
                        <button type="submit" class="btn btn-save">حفظ</button>
                        <a href="?action=delete&id=<?= $product->getId() ?>" class="btn btn-remove" 
                           onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">حذف</a>
                    </div>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

            <section class="admin-section">
                <h3>إضافة منتج جديد</h3>
                <form action="#" method="post">
                    <div class="form-group">
                        <label for="product-name">اسم المنتج:</label>
                        <input type="text" id="product-name" name="product-name" required>
                    </div>
                    <div class="form-group">
                        <label for="product-price">السعر:1</label>
                        <input type="number" id="product-price1" name="product-price1" required>
                    </div>
                    <div class="form-group">
                        <label for="product-price">السعر:2</label>
                        <input type="number" id="product-price2" name="product-price2" required>
                    </div>
                    <div class="form-group">
                        <label for="product-image">رابط الصورة:</label>
                        <input type="url" id="product-image" name="product-image" required>
                    </div>
                    <button type="submit" class="btn add-btn">أضف المنتج</button>
                </form>
            </section>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2025 شماغ الملوك. جميع الحقوق محفوظة.</p>
    </footer>
</body>
</html>