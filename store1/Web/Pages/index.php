<?php
require_once __DIR__.'/../Others/init.php';
UserController::requireNonAdmin();
$controller = new CartController();
$controller->perform();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شماغ الملوك - الصفحة الرئيسية</title>
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
        
        <section class="hero-section">
            <div class="hero-content">
                <h2 class="hero-title">شماغ الملوك تكمل الأصالة</h2>
                <h5>تراثنا العريق يتجسد في كل خيط منسوج صمم خصيصا لتكتمل أناقتك</h5>
                <pre></pre>
                <a href="products.php" class="btn">تسـوق الآن</a>
            </div>
            <img src="https://cdn.salla.sa/form-builder/fEoBZfevn0v6UfgLkJtPBw4hbDydOxIkLtxUHb2O.jpg" alt="تسوق الان">
        </section>

        
        <section class="featured-products">
            <h2>أشمغة مميزة</h2>
            <div class="product-grid">
                <?php
                $featuredProducts = array_filter($_SESSION['products'], function($product) {
                    return !$product->hasOffer();
                });
                
                foreach ($featuredProducts as $product):
                ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($product->getImage()) ?>" 
                         alt="<?= htmlspecialchars($product->getName()) ?>">
                    
                    <h3>
                        <?= htmlspecialchars($product->getName()) ?> 
                        <span class="product-number">#<?= $product->getId() ?></span>
                    </h3>
                    
                    <p><?= number_format($product->getCurrentPrice(), 0) ?> ريال</p>
                    
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

       
        <section class="sale-products">
            <h2>عروض خاصة</h2>
            <div class="product-grid">
                <?php
                $saleProducts = array_filter($_SESSION['products'], function($product) {
                    return $product->hasOffer();
                });
                
                foreach ($saleProducts as $product):
                ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($product->getImage()) ?>" 
                         alt="<?= htmlspecialchars($product->getName()) ?>">
                    
                    <h3>
                        <?= htmlspecialchars($product->getName()) ?> 
                        <span class="product-number">#<?= $product->getId() ?></span>
                    </h3>
                    
                    <p>
                        <span class="original-price"><?= number_format($product->getPrice1(), 0) ?> ریال</span> 
                        <?= number_format($product->getCurrentPrice(), 0) ?> ریال
                    </p>
                    
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