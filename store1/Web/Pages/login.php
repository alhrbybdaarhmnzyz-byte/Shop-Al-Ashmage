<?php
require_once __DIR__.'/../Others/init.php';
$controller = new UserController();
$controller->login();
$errors= $controller->getErrors();
UserController::requireNonUser();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <a href="index.php" class="logo">شماغ الملوك</a>
            <ul class="nav-links">
    <li><a href="products.php">المنتجات</a></li>
    <li><a href="login.php">تسجيل الدخول</a></li>
    <li><a href="cart.php">سلة المشتريات</a></li>
    <li id="admin-link"><a href="admin.html">لوحة التحكم</a></li>
</ul>
        </nav>
    </header>

    <main class="main-content">
        <div class="form-container">
            <h2>تسجيل الدخول</h2>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error" id="errorAlert">
                    <div class="alert-content">
                        <span class="alert-icon">⚠</span>
                        <div class="alert-messages">
                            <?php foreach ($errors as $error): ?>
                                <p><?= htmlspecialchars($error) ?></p>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="alert-close" onclick="this.parentElement.parentElement.remove()">&times;</button>
                    </div>
                </div>
            <?php endif; ?>


            <form action="#" method="post">
                <div class="form-group">
                    <label for="username">اسم المستخدم:</label>
                    <input type="text" id="username" name="username"  value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">كلمة المرور:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn">دخول</button>
            </form>
            <p class="link-text">
                ليس لديك حساب؟ <a href="register.php">انشاء حساب جديد</a>
            </p>
        </div>
    </main>
    <pre>

    </pre>
    <footer class="footer">
        <p>&copy; 2025 شماغ الملوك. جميع الحقوق محفوظة.</p>
    </footer>
</body>
</html>