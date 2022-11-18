<?php

namespace App\Commands;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CreateCategoryHandler
{
    public function __invoke(CreateCategoryCommand $command)
    {
		return $this->Store($command);
    }

	public function Store($command){
		DB::beginTransaction();

		try {
			
			$Category = new Category();
			$Category->id = $command->getId();
			$Category->name = $command->getName();
			$Category->createdAt = $command->getcreatedAt();
			$Category->save();
			DB::commit();
			//queue notification, dispatch event etc.
			

		} catch (\Throwable $th) {
			DB::rollBack();

			return $th;
		}
    	
	}
}