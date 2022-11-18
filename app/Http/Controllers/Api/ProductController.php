<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\CommandBus;
use App\Models\Product;
use App\Rules\Uppercase;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Queries\ProductQuery;
use App\Rules\ValidateInteger;

use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;
use App\Commands\CreateProductCommand;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function Query(Request $request)
    {
        $response = ApiResponse::getInstance();
        $validator = Validator::make($request->all(), [
            'sku' => ['nullable','size:15','string','exists:products,sku',new Uppercase], //OT-855-46-44789
            'name' => ['nullable','min:5','max:200','string','exists:products,name', new Uppercase],
            'category.id' => ['nullable','min:2','max:200','string','exists:categories,id'],
            'price.start' => ['nullable','min:0','integer',new ValidateInteger, 'lte:price.end'],
            'price.end' => ['nullable','min:0','integer',new ValidateInteger,'gte:price.start'],

        ]);

        if ($validator->fails()) {
            return $response->message($validator->getMessageBag())->badRequest();
        }


        try {
            $query  = explode('&', $_SERVER['QUERY_STRING']);
            $params = array();
            
            foreach( $query as $param )
            {
            if (strpos($param, '=') === false) $param += '=';
            
            list($name, $value) = explode('=', $param, 2);
            $params[urldecode($name)][] = urldecode($value);
            }
            
            $keyword = $params;
            $query = new ProductQuery($keyword);
            
            if(!empty($keyword['sku'])){$result = $query->getDataProductBySKU();} //BySKU

            if((!empty($keyword['price.start'])) && !empty($keyword['price.end']) ){
                $result = $query->getDataProductByPrice();
                
            }//ByPrice

            if((!empty($keyword['stock.start'])) && !empty($keyword['stock.end']) ){
                $result = $query->getDataProductByStock();
                
            }//ByStock
            

            //Result
            if(empty($result['data'])){
                return $response->notFound('Not Found');
            }else{
                 return $response->success($result);
            }

           

        } catch (\Throwable $th) {
            $ErrMsg = $th->getMessage();
            return $response->serverError($ErrMsg);
        }


        
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

            $id = Str::uuid()->toString();
            $createdAt = Carbon::now()->timestamp;
            $CreateProduct = new CreateProductCommand($id , $request->sku,$request->name, $request->price,$request->stock,$request->categoryId, $createdAt);
            $this->commandBus->handle($CreateProduct);

            return $response->success($CreateProduct->getResult());
        
        } catch (\Throwable $th) {

            $ErrMsg = $th->getMessage();
            return $response->serverError($ErrMsg);
        }
    }

}
