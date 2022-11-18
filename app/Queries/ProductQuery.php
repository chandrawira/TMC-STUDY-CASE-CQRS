<?php

namespace App\Queries;

use App\Models\Product;

class ProductQuery
{
    private $keyword;

    public function __construct($keyword)
    {   
       $this->keyword = $keyword;
    }

    public function getDataProductBySKU(): array
    {
        $keyword = collect($this->keyword)->collapse();
        $product = Product::WhereIn('sku',$keyword)->get();
        return ['data'=>$product];
    }

    public function getDataProductByPrice(): array
    {
        $keyword = $this->keyword;
        $priceStart = $keyword['price.start'][0];
        $priceEnd   = $keyword['price.end'][0];

        $product = Product::where('price','>=',$priceStart)
                    ->where('price','<=',$priceEnd)
                   ->paginate(5);
        if(!$product->isEmpty()){
            return ['data'=>$product];
        }else{
            return ['data' => null];
        }
        
    }
}