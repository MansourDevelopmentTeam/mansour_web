<?php

namespace App\Http\Controllers\Customer;

use App\Models\Orders\Cart;
use Illuminate\Http\Request;
use App\Models\Products\Brand;
use App\Models\Products\Group;
use App\Models\Products\Lists;
use App\Models\Orders\CartItem;
use App\Models\Products\Option;
use App\Models\Products\Product;
use App\Models\Products\Category;
use App\Models\Products\ListItems;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\Products\OptionValue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use App\Models\Products\StockNotification;
use App\Models\Products\Sort\SorterBuilder;
use App\Models\Repositories\ProductRepository;
use App\Http\Resources\Customer\BrandsResource;
use App\Http\Resources\Customer\GroupsResource;
use App\Http\Resources\Customer\ProductsOption;
use App\Models\Transformers\ProductTransformer;
use App\Services\Promotion\PromotionsServiceV2;
use App\Http\Resources\Customer\OptionsResource;
use App\Http\Resources\Master\ProductCollection;
use App\Models\Transformers\CustomerTransformer;
use App\Models\Transformers\ProductDetailTransformer;
use App\Models\Transformers\Customer\CategoryTransformer;


class ProductsController extends Controller
{
    private $productTrans;
    private $productRepo;
    private $productDetailTrans;
    private $categoryTrans;
    protected $promotionsService;
    private $customerTrans;


    /**
     * Constructor
     *
     * @param ProductTransformer $productTrans
     * @param ProductRepository $productRepo
     * @param ProductDetailTransformer $productDetailTrans
     * @param CategoryTransformer $categoryTrans
     * @param PromotionsService $promotionsService
     * @param CustomerTransformer $customerTrans
     */
    public function __construct(CustomerTransformer $customerTrans, ProductTransformer $productTrans, ProductRepository $productRepo, ProductDetailTransformer $productDetailTrans, CategoryTransformer $categoryTrans, PromotionsServiceV2 $promotionsService)
    {
        $this->productTrans = $productTrans;
        $this->productRepo = $productRepo;
        $this->productDetailTrans = $productDetailTrans;
        $this->categoryTrans = $categoryTrans;
        $this->promotionsService = $promotionsService;
        $this->customerTrans = $customerTrans;

    }

    public function index()
    {
        $products = $this->productRepo->getAllProductsPaginated();

        return $this->jsonResponse("Success", $this->productTrans->transformCollection($products));
    }

    public function home(Request $request)
    {
        $bought = $this->productRepo->getMostBought();
        $recent = $this->productRepo->getMostRecent();
        $discounted = $this->productRepo->getDiscounted();

        $locale = $request->header("lang") == 2 ? "ar" : "en";

        return $this->jsonResponse("Success", [
            [
                "name" => Lang::get("mobile.topPromotions", [], $locale),
                // "description" => "22 items in up to 50% sale.",
                "image" => URL::to('images/top-promotions.jpeg'),
                "sort" => "offers",
                "products" => $this->productTrans->transformCollection($discounted)
            ],
            [
                "name" => Lang::get("mobile.mostBought", [], $locale),
                "image" => URL::to('images/popular.jpeg'),
                "sort" => "popular",
                "products" => $this->productTrans->transformCollection($bought)
            ],
            [
                "name" => Lang::get("mobile.mostRecent", [], $locale),
                "image" => URL::to('images/top-promotions.jpeg'),
                "sort" => "recent",
                "products" => $this->productTrans->transformCollection($recent)
            ]
        ]);
    }

    public function topPromotions()
    {
        $products = Product::MainProduct()->available()->with("category.parent")->active()->where("discount_price", ">", 0)->orderBy("discount_price", "DESC")->paginate(10);

        return response()->json([
            "code" => 200,
            "message" => "Success",
            "data" => $this->productTrans->transformCollection($products->items()),
            "total" => $products->lastPage()
        ], 200);
    }

    public function mostBought()
    {
        $products = Product::MainProduct()->available()->with("category.parent")->active()->orderBy("orders_count", "DESC")->paginate(10);

        return response()->json([
            "code" => 200,
            "message" => "Success",
            "data" => $this->productTrans->transformCollection($products->items()),
            "total" => $products->lastPage()
        ], 200);
    }

    public function show($id)
    {
        $product = $this->productRepo->getProductById($id);

        $relatedSkus = $product->relatedSkus->pluck('sku')->toarray();
        $relatedProducts = Product::whereIn('sku', $relatedSkus)->get();

        $product->is_favourite = $product->isUserFavourite(\Auth::user());

        $similar_products = $this->productRepo->getSimilarProducts($product);
        $product = $this->productDetailTrans->transform($product);
        $similar_products = $this->productTrans->transformCollection($similar_products);
        $relatedProducts = $this->productTrans->transformCollection($relatedProducts);

        $product = array_merge($product, ['related_skus' => $relatedProducts]);
        return $this->jsonResponse("Success", [
            "product" => $product,
            "similar_products" => $similar_products
        ]);
    }

    public function search(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), ["q" => "required"], ["query.required" => "Please enter a search term"]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $products = $this->productRepo->searchProducts($request->q);

        // $products = array_values($products->filter(function ($item)
        // {
        //     return $item->active;
        // }));


        return $this->jsonResponse("Success", $this->productTrans->transformCollection($products));
    }

    /**
     * Search product in web
     *
     * @param Request $request
     * @return void
     */
    public function search_products(Request $request)
    {
        if(config('constants.products') == "main"){
            $products = $this->productRepo->searchMainProducts($request);
        }else{
            $products = $this->productRepo->searchVariantProducts($request);
        }

        $orProducts = $products;

        if ($request->has('options_values_ids') && count($request->get('options_values_ids'))) {
            $requestValues = OptionValue::find($request->options_values_ids);
            $products = $orProducts->filter(function ($product) use ($request, $requestValues) {
                $productValuesIds = $this->productRepo->getProductsOptionsValues(collect([$product])->merge($product->availableProductVariants))->pluck('values')->flatten(1)->pluck('id');
                $found = 0;
                foreach ($requestValues as $value) {
                    $valuesOptions = $requestValues->where('option_id', $value->option_id);
                    if ($valuesOptions->count() === 1) {
                        !in_array($value->id, $productValuesIds->toArray()) ?: $found++;
                    } else {
                        $multipleValueIds = $requestValues->whereIn('option_id', $valuesOptions->pluck('option_id')->toArray())->pluck('id');
                        foreach ($multipleValueIds as $valueId) {
                            if (in_array($valueId, $productValuesIds->toArray())) {
                                $found++;
                            }
                        }
                    }
                }
                return $found >= $requestValues->count();
            });
        }
        $productsOptions = $this->productRepo->getProductsOptionsValues($products)->sortBy('id');
        $orProductsOptions = $this->productRepo->getProductsOptionsValues($orProducts)->sortBy('id');

        if ($request->has('options_values_ids') && count($request->get('options_values_ids'))) {
            foreach ($productsOptions as $option) {
                $orProductsOption = $orProductsOptions->where('id', $option['id'])->first();
                foreach ($option['values'] as $value) {
                    if (in_array($value['id'], $request->options_values_ids)) {
                        $option['values'] = $orProductsOption['values'];
                    }
                }
            }
        }

        $pageSize = $request->page_size ?: 10;
        // $options =  Option::where("type",'!=', '5')->with('values')->get();
        $productsOptions = $productsOptions->sortBy('order')->values();

        $groups = $this->productRepo->getProductGroups($products);
        $brands = $this->productRepo->getProductBrands($products);

        // $max_price = Product::whereNotNull('parent_id')->max("price");
        // $min_price = Product::whereNotNull('parent_id')->min("price");

        $paginated = $products->forPage($request->page ?: 1, $pageSize)->values();

        return $this->jsonResponse("Success", [
                "products" => new ProductCollection($paginated),
                "products_options" => ProductsOption::collection($productsOptions),
                "total" => ceil($products->count() / $pageSize),
                "total_products" => $products->count(),
                "sub_categories" => GroupsResource::collection($groups)->sortBy('name')->values(),
                "brands" => BrandsResource::collection($brands)->sortBy('name')->values(),
                "min_price" => $request->get('price_from') ?? (int) ($products->min('final_price') / 100),
                "max_price" => $request->get('price_to') ?? (int) ($products->max('final_price') / 100),
            ]
        );
    }

    public function myFavourites()
    {
        $user = \Auth::user();

        $favourites = $user->favourites;

        return $this->jsonResponse("Success", $this->productTrans->transformCollection($favourites));
    }

    public function favourite($id)
    {
        $user = \Auth::user();

        $product = Product::findOrFail($id);

        if ($user->favourites()->find($id)) {
        } else {
            $user->favourites()->attach($id);
        }


        return $this->jsonResponse("Success", $this->productTrans->transformCollection($user->favourites));
    }

    public function addProductsToFavourite(Request $request)
    {
        $user = \Auth::user();

        $user->favourites()->syncWithoutDetaching($request->product_ids);

        return $this->jsonResponse("Success", $this->productTrans->transformCollection($user->favourites));
    }

    public function removeAllFavourites()
    {
        $user = \Auth::user();

        $user->favourites()->sync([]);

        return $this->jsonResponse("Success", $this->productTrans->transformCollection($user->favourites));
    }

    public function myComparisons()
    {
        $user = Auth::user();
        $comparisons = $user->comparisons;
        return $this->jsonResponse("Success", $this->productDetailTrans->transformCollection($comparisons));
    }

    public function setCompare($id)
    {
        $user = Auth::user();

        $product = Product::findOrFail($id);
        if ($product) {
            $user->comparisons()->syncWithoutDetaching([$id]);
        }
        $comparisons = $user->comparisons()->get();

        return $this->jsonResponse("Success", $this->productDetailTrans->transformCollection($comparisons));
    }

    public function removeCompare($id)
    {
        $user = Auth::user();

        $product = Product::findOrFail($id);
        if ($product) {
            $user->comparisons()->detach([$id]);
        }
        $comparisons = $user->comparisons()->get();

        return $this->jsonResponse("Success", $this->productDetailTrans->transformCollection($comparisons));
    }

    public function setProductsCompare(Request $request)
    {
        $user = Auth::user();

        $user->comparisons()->syncWithoutDetaching($request->product_ids);

        // $products = Product::whereIn('id',$request->product_ids)->get();
        return $this->jsonResponse("Success", $this->productTrans->transformCollection($user->comparisons));
    }

    public function removeProductsCompare()
    {
        $user = Auth::user();

        $user->comparisons()->sync([]);

        return $this->jsonResponse("Success");
    }

    public function unfavourite($id)
    {
        $user = \Auth::user();

        $product = Product::findOrFail($id);

        if ($user->favourites()->find($id)) {
            $user->favourites()->detach($id);
        }

        return $this->jsonResponse("Success");
    }

    public function notifyAvailability(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'required|string|email'
        ]);

        $user = auth()->user();
        if ($user->id == 999999) {
            if (!StockNotification::where('product_id', $id)->where("email", $request->get('email'))->exists()) {
                StockNotification::create(['product_id' => $id, "email" => $request->get('email')]);
            }
        } elseif (!$user->stock_notifications->contains($id)) {
            $user->stock_notifications()->attach([$id => ["email" => $request->get('email')]]);
        }
        return $this->jsonResponse("Success");
    }

    /**
     * Clone guet Product
     *
     * @param Request $request
     * @return void
     */
    public function cloneGuestProduct(Request $request)
    {
        $user = Auth::user();

        if ($request->get('compare') != null) {
            $user->comparisons()->syncWithoutDetaching($request->get('compare'));
        }

        if ($request->get('favourites') != null) {
            $user->favourites()->syncWithoutDetaching($request->get('favourites'));
        }

        if ($request->get('cart') != null) {

            if ($user->id == 999999) {
                return $this->jsonResponse("Success", []);
            }
            DB::beginTransaction();

            !($request->reset && $user->cart) ?: $user->cart()->delete();

            $cart = Cart::firstOrCreate(['user_id' => $user->id]);

            foreach ($request->input('cart.items') as $item) {

                $cartInc = CartItem::where([
                    'cart_id' => $cart->id,
                    'product_id' => $item['id']
                ])->increment('amount', $item['amount']);

                if ($cartInc) {
                    $cartItem = CartItem::where([
                        'cart_id' => $cart->id,
                        'product_id' => $item['id']
                    ])->first();
                } else {
                    $cartItem = CartItem::firstOrCreate([
                        'cart_id' => $cart->id,
                        'product_id' => $item['id'],
                        'amount' =>  $item['amount']
                    ]);
                }

                $cartItem->amount != 0 ?: $cartItem->delete();
            }
            DB::commit();
        } else {
            $cart = Cart::where(['user_id' => $user->id])->first();
        }
        $products = collect([]);

        if ($cart) {
            foreach ($cart->cartItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->amount = $item->amount;
                    $products->push($product);
                }
            }
        }

        if ($products->isNotEmpty()) {
            $products = $this->promotionsService->checkForDiscounts($products)['items'];
        }
        $user->token = (string)JWTAuth::getToken();
        $user_profile = $this->customerTrans->transform($user);
        if (auth()->check() && $user->id == 999999) {
            $user_profile = null;
        }

        if ($user) {

            $notifications = Auth::user()->notifications()->orderBy("created_at", "DESC")->paginate(20)->getCollection();
            $unreadNotifications = $user->notifications()->where('read', 0)->count();


        } else {
            $user_profile = null;
            $notifications = [];
            $unreadNotifications = 0;
        }

        return $this->jsonResponse("Success", [
            "compare" => $this->productTrans->transformCollection($user->comparisons),
            "favourites" => $this->productTrans->transformCollection($user->favourites),
            "cart" => $this->productTrans->transformCollection($products),
            "profile" => $user_profile,
            "notifications" => $notifications,
            "unreadNotifications" => $unreadNotifications
        ]);
    }
}
