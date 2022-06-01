<?php

namespace App\Http\Controllers\Customer;

use App\Services\PromotionB2B\PromotionsB2BService;
use Exception;
use App\Models\Orders\Cart;
use Illuminate\Http\Request;
use App\Models\Orders\CartItem;
use App\Models\Products\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Services\OrdersService;
use App\Models\Services\PromotionsService;
use App\Services\Promotion\PromotionsServiceV2;
use App\Http\Resources\Customer\CartResource;
use App\Models\Transformers\ProductTransformer;

class CartController extends Controller
{
    /** @var ProductTransformer $productTrans */
    protected $productTrans;
    /** @var PromotionsService $promotionsService */
    protected $promotionsService;
    /** @var OrdersService $ordersService */
    private $ordersService;

    /**
     * Cart Controller Constructor
     *
     * @param ProductTransformer $productTrans
     * @param PromotionsService $promotionsService
     * @param OrdersService $ordersService
     */
    public function __construct(ProductTransformer $productTrans, PromotionsServiceV2 $promotionsService, OrdersService $ordersService)
    {
        $this->productTrans = $productTrans;
        $this->promotionsService = $promotionsService;
        $this->ordersService = $ordersService;
    }

    /**
     * List cart
     *
     */
    public function index()
    {
        $user = auth()->user();

        try {
            $cart = Cart::with('cartItems.product')->where('user_id', $user->id)->firstOrFail();
            $cartItems = $cart->cartItems;

            $products = collect([]);
            foreach ($cartItems as $cartItem) {

                $product = $cartItem->product;
                $product->amount = $cartItem->amount;
                $products->push($product);
            }

            $newCart = $this->promotionsService->checkForDiscounts($products);

            $this->ordersService->customerCanBuyItems($newCart['items']);

            $response['items'] = $this->productTrans->transformCollection($newCart['items']);
            $response['gifts'] = $newCart['gifts'] ?? [];
            $response['suggestions'] = $newCart['suggestions'] ?? null;
            $response['isApplied'] = $newCart['isApplied'];
            $response['promotionDiscounts'] = $newCart['promotionDiscounts'];

            return $this->jsonResponse("Success", $response);

        } catch (Exception $e) {
            return $this->jsonResponse("Success", [
                'items' => [],
                'gifts' => [],
                'suggestions' => [],
                'isApplied' => false,
                'promotionDiscounts' => [],
            ]);
        }
    }

    /**
     * Add to store
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'reset' => 'required|boolean',
            'items.*.id' => 'required|exists:products,id,deleted_at,NULL,parent_id,NOT_NULL',
            'items.*.amount' => 'required'
        ]);
        $user = Auth::user();
        if ($user->id == 999999) {
            return $this->jsonResponse("Success", []);
        }
        DB::beginTransaction();

        !($request->reset && $user->cart) ?: $user->cart()->delete();

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        foreach ($request->items as $item) {
            $cartItem = CartItem::updateOrCreate([
                'cart_id' => $cart->id,
                'product_id' => $item['id']
            ], [
                'amount' => $item['amount']
            ]);
            $cartItem->amount != 0 ?: $cartItem->delete();
        }

        $cartItems = CartItem::with('product')->where('cart_id', $cart->id)->get();
        $products = collect([]);

        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;
            $product->amount = $cartItem->amount;
            $products->push($product);
        }

        DB::commit();

        $newCart = $this->promotionsService->checkForDiscounts($products);

        $this->ordersService->customerCanBuyItems($newCart['items']);

        $response['items'] = $this->productTrans->transformCollection($newCart['items']);
        $response['gifts'] = $newCart['gifts'] ?? [];
        $response['suggestions'] = $newCart['suggestions'];
        $response['isApplied'] = $newCart['isApplied'];
        $response['promotionDiscounts'] = $newCart['promotionDiscounts'];

        return $this->jsonResponse("Success", $response);
    }
}
