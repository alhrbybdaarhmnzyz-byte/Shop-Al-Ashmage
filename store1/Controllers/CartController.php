<?php
require_once __DIR__.'/../Data/CartData.php';
require_once __DIR__.'/../Data/ProductData.php';
class CartController{


    public function __construct(){

    }

    public function perform(){

        if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add' && isset($_POST['product_id'], $_POST['size'], $_POST['quantity'])) {
        $this->addToCart();
    }
    
   
    if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'remove' && isset($_POST['index'])) {
        $this->removeItem();
    }

    
    if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update' && isset($_POST['index'], $_POST['quantity'])) {
        $this->updateQuantity();
    }
    }
    
    
    private function addToCart(){
$productId = (int)$_POST['product_id'];
    $size = (int)$_POST['size'];
    $quantity = (int)$_POST['quantity'];
    
    $product = ProductData::getProductById($productId);
    
    if($product) {
        CartData::addToCart($product, $quantity, $size);
    }
    
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;

    }

    private function removeItem(){
    $index = (int)$_POST['index'];
    
    if(!isset($_SESSION['cart']) || !isset($_SESSION['cart'][$index])) {
        return;
    }
    
    $item = $_SESSION['cart'][$index];
    CartData::removeItem($item);
    
    header('Location: cart.php');
    exit;
    }
    private function updateQuantity(): void {
    
   $index = (int)$_POST['index'];
    $quantity = (int)$_POST['quantity'];
    
    if($quantity < 1) {
        return;
    }
    
    if(isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]->setQuantity($quantity);
    }
    
    header('Location: cart.php');
    exit;
}


}