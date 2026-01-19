<?php
require_once __DIR__.'/../Web/Others/init.php';


class ProductController{

public function perform(){
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit')
        $this->editProduct();

    elseif($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') 
        $this->deleteProduct();
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product-name']))
        $this->addProduct();
}
private function editProduct(){
//if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') 
        
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        
        if($product_id === false || $product_id === null) {
            die('Invalid product ID');
        }
        
        
        $name = trim($_POST['name']);
        $price1 = floatval($_POST['price1']);
        $price2 = !empty($_POST['price2']) ? floatval($_POST['price2']) : null;
        $image = trim($_POST['image']);
        
        
        if(empty($name) || $price1 <= 0 || empty($image)) {
            die('Invalid product data');
        }
        
       
        ProductData::editProductById($product_id, $name, $price1, $price2, $image);
        
        
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    
    
}
private function deleteProduct() {
    //if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') 
       
        $product_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if($product_id === false || $product_id === null) {
            die('Invalid product ID');
        }
        
        
        ProductData::deleteProductById($product_id);
        
       
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    
}

public function addProduct() {
    
        
        $name = trim($_POST['product-name']);
        $price1 = floatval($_POST['product-price1']);
        $price2 = !empty($_POST['product-price2']) ? floatval($_POST['product-price2']) : null;
        $image = trim($_POST['product-image']);
        
        
        if(empty($name) || $price1 <= 0 || empty($image)) {
            die('Invalid product data');
        }
        
        
        ProductData::addProduct($name, $price1, $price2, $image);
        
        
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    
}
}