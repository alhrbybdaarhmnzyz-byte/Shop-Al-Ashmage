<?php
require_once __DIR__.'/../Others/init.php';
$controller = new CartController();
$controller->perform();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تصفح المنتجات</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <a href="index.php" class="logo">شماغ الملوك</a>
            <?php include __DIR__.'/../Others/navbar.php' ?>
        </nav>
    </header>

    <main class="main-content">
        <section class="product-list">
            <h2>جميع المنتجات</h2>
            <div class="product-grid">
                <?php
                $allProducts = $_SESSION['products'];
                $randomProducts = $allProducts;
                shuffle($randomProducts);
                
                foreach ($randomProducts as $product):
                ?>
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="<?= htmlspecialchars($product->getImage()) ?>" 
                             alt="<?= htmlspecialchars($product->getName()) ?>">
                    </div>
                    
                    <h3>
                        <?= htmlspecialchars($product->getName()) ?> 
                        <span class="product-number">#<?= $product->getId() ?></span>
                    </h3>
                    
                    <?php if ($product->hasOffer()): ?>
                        <p>
                            <span style="text-decoration: line-through; color: #999;"><?= number_format($product->getPrice1(), 0) ?> ریال</span> 
                            <span style="color: #e74c3c; font-weight: bold;"><?= number_format($product->getCurrentPrice(), 0) ?> ریال</span>
                        </p>
                    <?php else: ?>
                        <p><?= number_format($product->getCurrentPrice(), 0) ?> ريال</p>
                    <?php endif; ?>
                    
                    <form method="POST">
    <input type="hidden" name="action" value="add">
    <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
    
    <div class="size-control">
        <label for="size-<?= $product->getId() ?>">المقاس:</label>
        <select name="size" id="size-<?= $product->getId() ?>" required>
            <option value="">اختر المقاس</option>
            <option value="58">58</option>
            <option value="60">60</option>
            <option value="62">62</option>
        </select>
    </div>
    
    <div class="quantity-control">
        <label for="quantity-<?= $product->getId() ?>">الكمية:</label>
        <input type="number" 
               id="quantity-<?= $product->getId() ?>" 
               name="quantity"
               min="1" 
               value="1"
               required>
    </div>
    
    <button type="submit" class="btn add-to-cart-btn">أضف للسلة</button>
</form>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2025 شماغ الملوك. جميع الحقوق محفوظة.</p>
    </footer>
</body>
</html>