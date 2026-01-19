<?php

class Item {

    private Product $_product;
    private int $_quantity;
    private int $_size;
    public function __construct(Product $product, int $quantity, $size=60) {
        $this->_product = $product;
        $this->_quantity = $quantity;
        $this->_size= $size;
    }

    
    public function getProduct(): Product {
        return $this->_product;
    }

    
    public function getQuantity(): int {
        return $this->_quantity;
    }

    public function getSize(): int{
        return $this->_size;
    }
    public function setQuantity(int $quantity): void {
        if ($quantity >= 1) {
            $this->_quantity = $quantity;
        }
    }

    
    public function increaseQuantity(int $amount): void {
        $this->_quantity += $amount;
    }

   
    public function decreaseQuantity(int $amount): void {
        $this->_quantity = max(1, $this->_quantity - $amount);
    }

   
    public function getTotalPrice(): float {
        return $this->_product->getCurrentPrice() * $this->_quantity;
    }
}