<?php
require_once __DIR__.'/../Others/init.php';
UserController::requireLogin();
UserController::requireNonAdmin();
$cartController= new CartController();
$cartController->perform();
$orderController= new OrderController();
$orderController->perform();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سلة المشتريات</title>
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
        <div class="cart-container">
            <h2>سلة المشتريات</h2>
            <div class="cart-items-list">
    <?php for($i = 0; $i < count($_SESSION['cart']); $i++): ?>
        <?php $item = $_SESSION['cart'][$i]; ?>
        <div class="cart-item">
            <div class="cart-item-info">
                <img src="<?= $item->getProduct()->getImage() ?>" alt="<?= $item->getProduct()->getName() ?>">
                <div>
                    <h4><?= $item->getProduct()->getName() ?> <span class="product-number">#<?= $item->getProduct()->getId() ?></span></h4>
                    <p>المقاس: <?= $item->getSize() ?></p>
                    <?php if($item->getProduct()->hasOffer()): ?>
                        <p><del><?= $item->getProduct()->getPrice1() ?> ریال</del> <?= $item->getProduct()->getPrice2() ?> ریال بعد الخصم</p>
                    <?php else: ?>
                        <p><?= $item->getProduct()->getPrice1() ?> ریال</p>
                    <?php endif; ?>
                    <p><strong>المجموع: <?= $item->getTotalPrice() ?> ریال</strong></p>
                </div>
            </div>
            
            <form method="POST" style="display: inline;">
                <div class="item-quantity-control">
                    <label for="cart-qty-<?= $i ?>">الكمية:</label>
                    <input type="number" id="cart-qty-<?= $i ?>" name="quantity" min="1" value="<?= $item->getQuantity() ?>">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="index" value="<?= $i ?>">
                    <button type="submit" class="btn btn-update">تحديث</button>
                </div>
            </form>
            
            <form method="POST" style="display: inline;">
                <input type="hidden" name="action" value="remove">
                <input type="hidden" name="index" value="<?= $i ?>">
                <button type="submit" class="btn btn-remove">إزالة</button>
            </form>
        </div>
    <?php endfor; ?>
</div>
</div>
            
            <div class="cart-summary">
    <?php 
    $total = 0;
    for($i = 0; $i < count($_SESSION['cart']); $i++) {
        $total += $_SESSION['cart'][$i]->getTotalPrice();
    }
    ?>
    <p class="total-price">الإجمالي: <span><?= number_format($total, 2) ?> ريال</span></p>
    
    <form method="POST" ">
        <input type="hidden" name="action" value="checkout">
        <input type="hidden" name="total" value="<?= $total ?>">
        <button type="submit" class="btn checkout-btn">إتمام الشراء</button>
    </form>
</div>
    </main>

    <footer class="footer">
        <p>&copy; 2025 شماغ الملوك. جميع الحقوق محفوظة.</p>
    </footer>
</body>
</html>