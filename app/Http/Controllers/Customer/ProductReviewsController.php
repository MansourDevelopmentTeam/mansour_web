<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Products\Product;
use App\Models\Products\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductReviewsController extends Controller
{

   public function addRate(Request $request){
       $validator = Validator::make($request->all(), ProductReview::$validation);

       if ($validator->fails()) {
           return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
       }
       $data = $validator->valid();
       $data['type'] = 1;
       $product = Product::find($request->product_id);
       if (!$product){
           return $this->jsonResponse("Product Not Found",null);
       }
       $data['user_id'] = auth()->user()->id;
       $productRate = ProductReview::create($data);

       return $this->jsonResponse("Success", $productRate);

   }
}
