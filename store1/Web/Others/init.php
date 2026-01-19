<?php
require_once __DIR__.'/../../Data/StaffData.php';
require_once __DIR__.'/../../Data/UserData.php';
require_once __DIR__.'/../../Controllers/UserController.php';
require_once __DIR__.'/../../Data/ProductData.php';
require_once __DIR__.'/../../Controllers/CartController.php';
require_once __DIR__.'/../../Controllers/OrderController.php';
require_once __DIR__.'/../../Data/OrderData.php';
require_once __DIR__.'/../../Business/User.php';
require_once __DIR__.'/../../Business/Product.php';
require_once __DIR__.'/../../Data/ProductData.php';
require_once __DIR__.'/../../Controllers/ProductController.php';
require_once __DIR__.'/../../Business/Order.php';
session_start();

StaffData::connect();

$_SESSION['products'] = ProductData::getAllProducts();
if(!isset($_SESSION['cart']))
    $_SESSION['cart'] = [];

