<?php

namespace App\Commands;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CreateProductHandler
{

	public function __invoke(CreateProductCommand $command)
	{
		return $this->Store($command);
	}

    public function Store($command)
    {
		DB::beginTransaction();
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
			
			DB::commit();
			//other queue
			
			//SentTo MessageBroker

		} catch (\Throwable $th) {
			DB::rollBack();
			return $th;
		}	
			

			//send info
    	
    }
}