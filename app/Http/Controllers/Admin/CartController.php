<?php

namespace App\Http\Controllers\Admin;

use App\Models\Users\User;
use App\Models\Orders\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Cart::where('user_id', $id)->first();

        if($cart){
            $cart->cartItems()->delete();
            $cart->delete();
        }

        return $this->jsonResponse("Success");
    }
}
