<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Product;
use App\Rules\Uppercase;
use Illuminate\Http\Request;
use App\Rules\ValidateInteger;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\CommandBus;
use App\Commands\CreateProductCommand;

class ProductController extends Controller
{

    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

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

        try {

            $createdAt = Carbon::now()->timestamp;
            $CreateProduct = new CreateProductCommand($request->sku,$request->name, $request->price,$request->stock,$request->categoryId, $createdAt);
            $this->commandBus->handle($CreateProduct);
            
            return $response->success($CreateProduct);
        
        } catch (\Throwable $th) {

            $ErrMsg = $th->getMessage();
            return $response->serverError($ErrMsg);
        }
    }

}
