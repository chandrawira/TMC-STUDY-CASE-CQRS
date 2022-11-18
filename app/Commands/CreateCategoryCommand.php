<?php

namespace App\Commands;

class CreateCategoryCommand
{
    private $id,$name,$createdAt;

    public function __construct($id, $name,$createdAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt;
    }

    public function getId(): string
    {
        return $this->id;        
    }
    
    public function getName(): string
    {
        return $this->name;
    }

    public function getcreatedAt(): int
    {
        return $this->createdAt;
    }

    public function getResult(): array
    {   
        return ['data',
                    [
                        'id'=> $this->id,
                        'name'=> $this->name,
                        'createdAt' => $this->createdAt
                    ]
        ];
    }

}