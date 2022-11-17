<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Response\ApiResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function Store(Request $request){
        $response = ApiResponse::getInstance();
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:2','max:200','string','unique:categories,name']
        ]);

        if ($validator->fails()) {
            return $response->message($validator->getMessageBag())->badRequest();
        }
        DB::beginTransaction();

        try {

            $category = new Category;
            $category->name = $request->name;
            $category->createdAt = Carbon::now()->timestamp;
            $category->save();
            DB::commit();
            return $response->success($category);
        
        } catch (\Throwable $th) {
            DB::rollBack();
            $ErrMsg = $th->getMessage();
            return $response->notFound('message');
        }
    }
    
    public function Find(Request $request)
    {
        //
        $response = ApiResponse::getInstance();
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:2','max:200','string']
        ]);

        if ($validator->fails()) {
            return $response->message($validator->getMessageBag())->badRequest();
        }

        try {
            $data = Category::where('name',$request->name)
                    ->FirstOrFail();    
            return $response->success($data);

        } catch (\Throwable $th) {
            
            $ErrMsg = $th->getMessage();
            return $response->notFound('message');

        }
       

    }

    
}
