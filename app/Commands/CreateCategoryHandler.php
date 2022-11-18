<?php

namespace App\Commands;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CreateCategoryHandler
{
    public function __invoke(CreateProductCommand $command)
    {
		DB::beginTransaction();

		try {
			DB::commit();
			$Category = new Category();
			$Category->name = $command->getName();
			$Category->createdAt = $command->getcreatedAt();
			return $Category->save();

		} catch (\Throwable $th) {
			//throw new \ErrorException('Error found');
			DB::rollBack();

			return $th;
		}
    	

    	// other logic, eg queue slack notification, dispatch event etc.
    }
}