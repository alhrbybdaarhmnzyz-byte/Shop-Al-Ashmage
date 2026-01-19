<?php
require_once __DIR__.'/../Web/Others/init.php';
require_once __DIR__.'/../Data/OrderData.php';
require_once __DIR__.'/../Web/Others/init.php';

class OrderController{
    

    private function confirmOrder():void{
    

    $user_id = $_SESSION['user']->getID();
    $items = $_SESSION['cart'];
    
    
    $total = 0;
    foreach($items as $item) {
       
        $total += $item->getProduct()->getCurrentPrice() * $item->getQuantity();
    }
    
   
    $order_id = OrderData::createOrder($user_id, $total);
    
    if(!$order_id) {
        return ;
    }

   
    foreach($items as $item){
        $success = OrderData::addItemsToOrder($item, $order_id);
        if(!$success) {
           
            error_log("Failed to add item to order: " . $order_id);
        }
    }

    
    $_SESSION['cart'] = [];
    
    
}
public function perform(){
    if(isset($_POST['action']) && $_POST['action'] === 'cancel') {
        $this->cancelStatus();
    }
    elseif(isset($_POST['action']) && $_POST['action'] === 'update_status') {
        $this->updateStatus();
    }
    elseif(isset($_POST['action']) && $_POST['action'] === 'checkout' && isset($_SESSION['user']) && !empty($_SESSION['cart'])) {
        $this->confirmOrder();
}
}
private function cancelStatus(){

        $order_id = $_POST['order_id'];
        OrderData::updateStatus($order_id, "cancelled");
        
        
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    
}

private function updateStatus() {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    OrderData::updateStatus($order_id, $new_status);
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
}
