<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notifications\PushMessage;

use App\Models\Products\ProductReview;
use App\Models\Services\PushService;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
class ProductReviewsController extends Controller
{

    public function index()
    {
        $rate = ProductReview::paginate();
        return $this->jsonResponse("Success", ['rates'=>$rate->items(),'total'=>$rate->total()]);
    }

    public function show($id)
    {
        $rate = ProductReview::find($id);
        if ($rate){
            return $this->jsonResponse("Success",$rate);
        }else{
            return $this->jsonResponse("Rate Not Found",[]);
        }
    }
    public function approve($id)
    {
        $rate = ProductReview::find($id);
        if ($rate){
            $rate->update(['status'=>1]);
            $product = Product::where('id',$rate->product_id)->first();
            if ($product){
                $rateAVG = $product->ratesApprovedAvg();

                $product->update(['rate'=>$rateAVG]);
            }
            return $this->jsonResponse("Success",$rate);
        }else{
            return $this->jsonResponse("Rate Not Found",[]);
        }
    }
    public function reject(Request $request,$id)
    {
        $rate = ProductReview::find($id);
        $validator = Validator::make($request->all(), [
            "rejection_reason" => "required|string",
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        if ($rate){
            $rate->update(['status'=>2,'rejection_reason'=>$request->rejection_reason]);
            return $this->jsonResponse("Success",$rate);
        }else{
            return $this->jsonResponse("Rate Not Found",[]);
        }
    }

}
