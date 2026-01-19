<?php
require_once __DIR__.'/../Data/StaffData.php';
require_once __DIR__.'/../Business/Item.php';
require_once __DIR__.'/../Business/Order.php';
class OrderData{



    private function __construct(){

    }

    public static function createOrder(int $user_id, float $total_price, $created_at = null):int{
       if ($created_at === null) {
        $created_at = date('Y-m-d H:i:s');
    }
    
    $conn = StaffData::Getconnection();
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, created_at) VALUES (?, ?, ?)");
    
    
    $stmt->bind_param("ids", $user_id, $total_price, $created_at);
    $stmt->execute();
    
    $order_id = $stmt->insert_id;
    $stmt->close();
    
    return $order_id;
    }
    
    public static function addItemsToOrder(Item $item,int $order_id):bool{
        $conn = StaffData::Getconnection();
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, size) VALUES (?, ?, ?, ?)");
    
    $productId = $item->getProduct()->getId();
    $quantity = $item->getQuantity();
    $size = $item->getSize();
    
    $stmt->bind_param("iiii", $order_id, $productId, $quantity, $size);
    $success = $stmt->execute();
    $stmt->close();
    
    return $success;
    }

    public static function getOrderItems(int $order_id):?array{
       $conn = StaffData::Getconnection();
    $stmt = $conn->prepare("SELECT product_id, quantity, size FROM order_items WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while($row = $result->fetch_assoc()) {
        $product = ProductData::getProductById($row['product_id']);
        if($product) {
            $item = new Item($product, $row['quantity'], $row['size']);
            $items[] = $item;
        }
    }

    $stmt->close();
    return empty($items) ? null : $items;
}

public static function getAllOrders(): ?array{
    $conn = StaffData::Getconnection();
    $stmt = $conn->prepare("SELECT * FROM orders");
    $stmt->execute();
    $result = $stmt->get_result();
    
    $orders = [];
    while($row = $result->fetch_assoc()) {
        $order = new Order(
            $row['id'],
            $row['user_id'],
            $row['total_price'],
            $row['created_at'],
            $row['status'] ?? 'pending'
        );
        $orders[] = $order;
    }
    
    $stmt->close();
    return $orders;
}
    public static function getOrdersByUserId(int $user_id) :?array{
       $conn = StaffData::Getconnection();
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while($row = $result->fetch_assoc()) {
    $order = new Order(
        $row['id'],
        $row['user_id'],
        $row['total_price'],
        $row['created_at'],
        $row['status'] ?? 'pending' 
    );
    $orders[] = $order;
}

$stmt->close();
return $orders;
    }
    
    public static function updateStatus(int $order_id, string $status):bool{
        if($status !== "completed" && $status !== "processing" && $status !== "pending" && $status !== "cancelled") {
        return false;
    }
    
    $conn = StaffData::Getconnection();
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $order_id);  // Fixed variable name
    $stmt->execute();
    $stmt->close();
    
    return true;
    }
}