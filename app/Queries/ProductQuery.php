<?php

namespace App\Queries;

use App\Models\Product;

class ProductQuery
{
    private $productId;

    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }

    public function getData(): array
    {
        $product = Product::query()->findOrFail($this->productId);
        return ['data'=>$product];
    }
}