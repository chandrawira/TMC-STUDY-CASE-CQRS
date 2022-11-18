<?php

namespace App\Commands;

class CreateCategoryCommand
{
    private $name,$createdAt;

    public function __construct($name,$createdAt)
    {
        $this->name = $name;
        $this->createdAt = $createdAt;
    }
    
    public function getName(): string
    {
        return $this->name;
    }

    public function getcreatedAt(): int
    {
        return $this->createdAt;
    }
}