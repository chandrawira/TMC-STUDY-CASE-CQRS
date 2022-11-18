<?php

namespace App\Commands;

class CreateProductCommand
{
    private $sku, $name, $price, $stock, $categoryId, $createdAt;
    
    public function __construct($sku, $name, $price, $stock, $categoryId, $createdAt)
    {   
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->categoryId = $categoryId;
        $this->createdAt = $createdAt;
        
        
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSku(): string
    {
        return $this->sku;
    }
    
    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function getcreatedAt(): string
    {
        return $this->createdAt;
    }

    

}