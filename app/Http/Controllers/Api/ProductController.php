<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Product;
use App\Rules\Uppercase;
use Illuminate\Http\Request;
use App\Rules\ValidateInteger;
use App\Http\Response\ApiResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    public function Store(Request $request){
        $response = ApiResponse::getInstance();
        $validator = Validator::make($request->all(), [
            'sku' => ['required','size:15','string','unique:products,sku',new Uppercase], //OT-855-46-44789
            'name' => ['required','min:5','max:200','string','unique:products,name', new Uppercase],
            'categoryId' => ['required','min:2','max:200','string','exists:categories,id'],
            'price' => ['required','integer',new ValidateInteger],
            'stock' => ['required','integer','between:1,9000']
        ]);

        if ($validator->fails()) {
            return $response->message($validator->getMessageBag())->badRequest();
        }
        DB::beginTransaction();

        try {

            $Product = new Product();
            $Product->sku = $request->sku;
            $Product->name = $request->name;
            $Product->price = $request->price;
            $Product->stock = $request->stock;
            $Product->category_id = $request->categoryId;
            $Product->createdAt = Carbon::now()->timestamp;
            $Product->save();
            DB::commit();
            return $response->success($Product);
        
        } catch (\Throwable $th) {
            DB::rollBack();
            $ErrMsg = $th->getMessage();
            return $response->serverError($ErrMsg);
        }
    }

}
