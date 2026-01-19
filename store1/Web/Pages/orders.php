<?php
require_once __DIR__.'/../Others/init.php';
UserController::requireLogin();
UserController::requireAdmin();
$orders= OrderData::getAllOrders();
$orderController= new OrderController();
$orderController->perform();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شماغ الملوك - الكلبات</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <nav class="navbar">
           
            <ul class="nav-links">
                <li><a href="logout.php">تسجيل الخروج</a></li>
                <li><a href="admin.php">لوحة التحكم </a></li>
            </ul>
        </nav>
    </header>
    
    <main class="main-content">
        <div class="page-header">
            <h1>الطلبات</h1>
            <p>تتبع جميع طلباتك وحالتها</p>
        </div>

        <div class="orders-container">
            <?php if(empty($orders)): ?>
               
                <div class="empty-orders">
                    <h2>لا توجد طلبات بعد</h2>
                    
                </div>
            <?php else: ?>
                <?php foreach($orders as $order): ?>
                    <?php 
                    $orderItems = OrderData::getOrderItems($order->getId());
                    $statusClass = 'status-' . strtolower($order->getStatus());
                    $statusText = match($order->getStatus()) {
                        'pending' => 'قيد الانتظار',
                        'processing' => 'قيد المعالجة',
                        'completed' => 'مكتمل',
                        'cancelled' => 'ملغي',
                        default => $order->getStatus()
                    };
                    ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-info">
                                <div class="order-detail">
                                    <span class="order-detail-label">رقم الطلب</span>
                                    <span class="order-detail-value">#<?= $order->getId() ?></span>
                                </div>
                                <div class="order-detail">
                                    <span class="order-detail-label">تاريخ الطلب</span>
                                    <span class="order-detail-value"><?= date('Y-m-d', strtotime($order->getCreatedAt())) ?></span>
                                </div>
                            </div>
                            <span class="order-status <?= $statusClass ?>"><?= $statusText ?></span>
                        </div>

                        <div class="order-items">
                            <?php if($orderItems): ?>
                                <?php foreach($orderItems as $item): ?>
                                    <div class="order-item">
                                        <img src="<?= htmlspecialchars($item->getProduct()->getImage()) ?>" 
                                             alt="<?= htmlspecialchars($item->getProduct()->getName()) ?>">
                                        <div class="order-item-details">
                                            <div class="order-item-name"><?= htmlspecialchars($item->getProduct()->getName()) ?></div>
                                            <div class="order-item-info">
                                                <span>المقاس: <?= $item->getSize() ?></span>
                                                <span>الكمية: <?= $item->getQuantity() ?></span>
                                            </div>
                                        </div>
                                        <div class="order-item-price"><?= number_format($item->getTotalPrice(), 2) ?> ریال</div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="order-footer">
                            <div class="order-total">الإجمالي: <span><?= number_format($order->getTotalPrice(), 2) ?> ریال</span></div>
                            <div>
                                <?php if($order->getStatus() === 'pending'): ?>
                                    
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="order_id" value="<?= $order->getId() ?>">
                                        <input type="hidden" name="new_status" value="processing">
                                        <button type="submit" class="btn" style="background-color: #007bff;">بدء المعالجة</button>
                                    </form>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="order_id" value="<?= $order->getId() ?>">
                                        <input type="hidden" name="new_status" value="cancelled">
                                        <button type="submit" class="btn btn-remove" onclick="return confirm('هل أنت متأكد من إلغاء الطلب؟')">إلغاء الطلب</button>
                                    </form>
                                    
                                <?php elseif($order->getStatus() === 'processing'): ?>
                                    
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="order_id" value="<?= $order->getId() ?>">
                                        <input type="hidden" name="new_status" value="completed">
                                        <button type="submit" class="btn" style="background-color: #28a745;">إكمال الطلب</button>
                                    </form>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="order_id" value="<?= $order->getId() ?>">
                                        <input type="hidden" name="new_status" value="cancelled">
                                        <button type="submit" class="btn btn-remove" onclick="return confirm('هل أنت متأكد من إلغاء الطلب؟')">إلغاء الطلب</button>
                                    </form>
                                    
                                <?php elseif($order->getStatus() === 'completed' || $order->getStatus() === 'cancelled'): ?>
                                    
                                    <span style="color: #6c757d; font-style: italic;">لا توجد إجراءات متاحة</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2025 شماغ الملوك. جميع الحقوق محفوظة.</p>
    </footer>
</body>
</html>