<?php

class Product{

    private int $_id;
    private string $_name;
    private float $_price1;
    private ?float $_price2; 
    private string $_image;

    public function __construct(int $id, string $name, float $price1, ?float $price2, string $image){
        $this->_id = $id;
        $this->_name= $name;
        $this->_price1=$price1;
        $this->_price2= $price2;
        $this->_image = $image;
    }

    public function getId(): int {
        return $this->_id;
    }

    public function getName(): string {
        return $this->_name;
    }

    public function getPrice1(): float{
        return $this->_price1;
    }

    public function getPrice2(): ?float{
        return $this->_price2;
    }

    public function hasOffer(): bool {
        return $this->_price2 !== null;
    }

    public function getCurrentPrice(): float{
        return ($this->_price2 === null) ? $this->_price1 : $this->_price2; 
    }

    public function getImage(): string {
        return $this->_image;
    }
}