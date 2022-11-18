<?php

namespace App\Commands;

use App\Models\Product;

class CreateProductHandler
{

	public function __invoke(CreateProductCommand $command)
	{
		return $this->Store($command);
	}

    public function Store($command)
    {
		try {

			$product = new Product();
			$product->id = $command->getId();
			$product->sku = $command->getSku();
			$product->name = $command->getName();
			$product->price = $command->getPrice();
			$product->stock = $command->getStock();
			$product->category_id = $command->getCategoryId();
			$product->createdAt = $command->getcreatedAt();
			$product->save();

			//return $product->toArray();
			
			//other queue

		} catch (\Throwable $th) {
			//throw $th;
			return $th;
		}	
			

			//send info
    	
    }
}