<?php

class Order{

    private int $_id;
    private int $_user_id;
    private float $_total_price;

    private string $_status;
    private string $_created_at;

    public function __construct(int $id, int $user_id, float $totalPrice,  string $created_at , string $status ="pending"){
        $this->_id =$id;
        $this->_user_id = $user_id;
        $this->_total_price= $totalPrice;
        $this->_status= $status;
        $this->_created_at = $created_at;
    }


    public function getId(): int{
        return $this->_id;
    }

    public function getUser_id(): int {
        return $this->_user_id;
    }
    public function getTotalPrice(): float{
        return $this->_total_price;
    }
    public function getStatus(): string{
        return $this->_status;
    }
    public function getCreatedAt():string{
        return $this->_created_at;
    }
    
}