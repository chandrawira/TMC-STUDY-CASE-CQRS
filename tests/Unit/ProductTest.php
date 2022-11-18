<?php

namespace Tests\Unit;

use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    //use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_ProductCreation()
    {
        
        $response =  $this->withHeaders([
            'Authorization' => 'GeSAXqfDomWFnDrSVedo0JgrKPPX9IRa0tbkvEuNtBkTO76IHLph7f9AGUUpcC9a',
        ])
        ->json('POST', '/api/product', [
            'sku'  => $sku = 'FO-491-53-17352',
            'name'  =>  $name = time().'test',
            'price'  =>  $price = '1000',
            'stock'  =>  $stock = '12',
            'categoryId'  =>  $categoryId = Str::uuid()->toString(),
        ]);

        Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);

    }
}
