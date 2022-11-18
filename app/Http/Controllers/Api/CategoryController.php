<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\CommandBus;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;
use App\Commands\CreateCategoryCommand;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }
    
    public function Store(Request $request){
        $response = ApiResponse::getInstance();
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:2','max:200','string','unique:categories,name']
        ]);

        if ($validator->fails()) {
            return $response->message($validator->getMessageBag())->badRequest();
        }

        try {

            $id = Str::uuid()->toString();
            $createdAt = Carbon::now()->timestamp;
            $CreateCategory = new CreateCategoryCommand($id ,$request->name, $createdAt);
            $this->commandBus->handle($CreateCategory);

            return $response->success($CreateCategory->getResult());
        
        
        } catch (\Throwable $th) {

            $ErrMsg = $th->getMessage();
            return $response->notFound($ErrMsg);
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
