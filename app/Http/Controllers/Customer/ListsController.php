<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Products\Lists;
use App\Models\Transformers\Customer\ListTransformer;

class ListsController extends Controller
{
    private $listTrans;

    public function __construct(ListTransformer $listTrans)
    {
        $this->listTrans = $listTrans;
    }

    public function index($id)
    {
        $list = Lists::find($id);
        if (!$list){
            $message = 'List Not Found';
            return $this->errorResponse($message, "Invalid data", 422);
        }
        $listTransform = $this->listTrans->transform($list);
        return $this->jsonResponse("Success", $listTransform);

    }
}
