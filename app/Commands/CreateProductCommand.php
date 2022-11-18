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

    public function ReturnVal()
    {
       return array('data' => 
                            array(
                            'sku'=> $this->getSku(), 
                            'name'=> $this->getName(),
                            'price'=> $this->getPrice(),
                            'stock'=> $this->getStock(),
                            'categoryId'=> $this->getCategoryId(),
                            'createdAt'=> $this->getcreatedAt() 
                            )
                        );
            
    }
}