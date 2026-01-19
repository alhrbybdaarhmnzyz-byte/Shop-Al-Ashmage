<?php
require_once __DIR__.'/../Others/init.php';

$controller = new UserController();
$controller->register();
$errors = $controller->getErrors();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب</title>
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
                <li id="admin-link"><a href="admin.php">لوحة التحكم</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-content">
        <div class="form-container">
            <h2>إنشاء حساب جديد</h2>

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

            <form method="post">
                <div class="form-group">
                    <label for="username">اسم المستخدم:</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">البريد الإلكتروني:</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">كلمة المرور:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">تأكيد كلمة المرور:</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
                <button type="submit" class="btn">إنشاء حساب</button>
            </form>
            <p class="link-text">
                لديك حساب بالفعل؟ <a href="login.php">تسجيل الدخول</a>
            </p>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2025 شماغ الملوك. جميع الحقوق محفوظة.</p>
    </footer>

    <script>
        
        const errorAlert = document.getElementById('errorAlert');
        if (errorAlert) {
            setTimeout(() => {
                errorAlert.style.opacity = '0';
                errorAlert.style.transition = 'opacity 0.5s ease-out';
                setTimeout(() => errorAlert.remove(), 500);
            }, 5000);
        }
    </script>
</body>
</html>