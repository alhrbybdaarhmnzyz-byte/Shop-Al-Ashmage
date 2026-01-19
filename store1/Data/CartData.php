<?php
require_once __DIR__.'/../Web/Others/init.php';
require_once __DIR__.'/../Business/Item.php';
require_once __DIR__.'/../Business/Product.php';
class CartData{


private function __construct(){

}
    

public static function addToCart(Product $product, int $quantity, int $size):void{
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart']=[];
    }

     $item = new Item($product, $quantity,$size);
     $_SESSION['cart'][]=$item;
}

public static function removeItem(Item $item){
    if(!isset($_SESSION['cart']))
        return;
    
    foreach($_SESSION['cart'] as $key => $cartItem) {
        if($cartItem === $item) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            return;
        }
    }

}

public static function clearCart(){
     $_SESSION['cart'] = [];
}
}