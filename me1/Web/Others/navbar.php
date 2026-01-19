<?php
require_once __DIR__.'/../Others/init.php';


$isLoggedIn = isset($_SESSION['user']);
?>

<ul class="nav-links">
    <li><a href="products.php">المنتجات</a></li>
    
    <?php if ($isLoggedIn): ?>
        <li><a href="logout.php">تسجيل الخروج</a></li>
    <?php else: ?>
        <li><a href="login.php">تسجيل الدخول</a></li>
    <?php endif; ?>
    <li><a href="MyOrders.php">طلباتي</a></li>
    <li><a href="cart.php">سلة المشتريات</a></li>
    
</ul>