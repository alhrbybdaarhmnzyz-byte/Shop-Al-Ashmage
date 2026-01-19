<?php
require_once __DIR__.'/../Business/Product.php';
require_once __DIR__.'/../Data/StaffData.php';

class ProductData{

    private function __construct(){

    }


    public static function addProduct(string $name, float $price1, $price2=null, string $image):void{
        $conn = StaffData::Getconnection();
    $stmt = $conn->prepare("INSERT INTO products (name, price1, price2, image) VALUES (?,?,?,?)");
    $stmt->bind_param("sdds", $name, $price1, $price2, $image);
    $stmt->execute();
    $stmt->close();
    }

public static function getAllProducts():array  {
    
    $conn = StaffData::Getconnection();
    $query = "SELECT id, name, price1, price2, image FROM products ORDER BY id DESC";
    $result = $conn->query($query);
    
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = new Product(
            $row['id'],
            $row['name'],
            $row['price1'],
            $row['price2'],
            $row['image']
        );
    }
    
    return $products;
}


public static function getProductById(int $id) :? Product{
    $conn = StaffData::Getconnection();
    $stmt = $conn->prepare("SELECT id, name, price1, price2, image FROM products WHERE id =?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if($data){
        return new Product($data['id'], $data['name'], $data['price1'], $data['price2'], $data['image']);
    }
    
    return null;
}

public static function deleteProductById(int $id){
    $conn = StaffData::Getconnection();
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    
    return $result;
}

public static function editProductById(int $id, string $name, float $price1, float $price2, string $image) {
    $conn = StaffData::Getconnection();
    $stmt = $conn->prepare("UPDATE products SET name = ?, price1 = ?, price2 = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sddsi", $name, $price1, $price2, $image, $id);
    $result = $stmt->execute();
    
    return $result;
}
}