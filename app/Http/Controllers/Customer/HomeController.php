<?php

namespace App\Http\Controllers\Customer;

use App\Models\Localization\Country;
use App\Models\Products\Ad;
use App\Models\Home\Section;
use Illuminate\Http\Request;
use App\Models\Products\Brand;
use App\Models\Orders\CartItem;
use App\Models\Products\Product;
use App\Models\Products\CustomAd;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Services\OrdersService;
use App\Models\Services\PromotionsService;
use App\Services\Promotion\PromotionsServiceV2;
use App\Http\Resources\Customer\AdsResource;
use App\Models\Repositories\ProductRepository;
use App\Http\Resources\Customer\BrandsResource;
use App\Models\Transformers\ProductTransformer;
use App\Models\Transformers\CustomerTransformer;
use App\Models\Repositories\CategoriesRepository;
use App\Models\Transformers\Customer\AdsTransformer;
use App\Http\Resources\Customer\Home\SectionCollection;
use App\Models\Transformers\Customer\SectionTransformer;
use App\Models\Transformers\Customer\CategoryTransformer;
use App\Models\Transformers\Customer\CustomAdsTransformer;
use App\Http\Resources\Customer\CategoryWithGroupsResource;

class HomeController extends Controller
{
    private $categoryTrans;
    private $categoriesRepo;
    private $productRepo;
    private $productTrans;
    private $customerTrans;
    private $customAds;
    protected $promotionsService;
    protected $ordersService;

    /**
     * Constructor
     *
     * @param CustomAdsTransformer $customAds
     * @param CategoryTransformer $categoryTrans
     * @param CategoriesRepository $categoriesRepo
     * @param ProductRepository $productRepo
     * @param ProductTransformer $productTrans
     * @param CustomerTransformer $customerTrans
     * @param PromotionsService $promotionsService
     * @param OrdersService $ordersService
     */
    public function __construct(CustomAdsTransformer $customAds, CategoryTransformer $categoryTrans, CategoriesRepository $categoriesRepo, ProductRepository $productRepo, ProductTransformer $productTrans, CustomerTransformer $customerTrans, PromotionsServiceV2 $promotionsService, OrdersService $ordersService)
    {
        $this->categoryTrans = $categoryTrans;
        $this->categoriesRepo = $categoriesRepo;
        $this->productRepo = $productRepo;
        $this->productTrans = $productTrans;
        $this->customerTrans = $customerTrans;
        $this->customAds = $customAds;
        $this->promotionsService = $promotionsService;
        $this->ordersService = $ordersService;
    }

    /**
     * Home api V2
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $ads = Cache::remember('ads', 60 * 30, function () {
            return Ad::active()->where("popup", 0)->where("banner_ad", 0)->orderBy("order", "ASC")->get();
        });
        $ads->each->setAppends(["name"]);

        $banner_ads = Cache::remember('banner_ads', 60 * 30, function () {
            return Ad::active()->where("popup", 0)->where("banner_ad", 1)->get();
        });
        $banner_ads->each->setAppends(["name"]);

        $popup_ads = Cache::remember('popup_ads', 60 * 30, function () {
            return Ad::active()->where("popup", 1)->where("banner_ad", 0)->orderBy("order", "ASC")->get();
        });
        $popup_ads->each->setAppends(["name"]);

        $customAd = Cache::remember('customAd', 60 * 30, function () {
            return CustomAd::all();
        });

        $sections = Cache::remember('sections', 60 * 30, function () {
            return Section::with(['images'])->where('active', 1)->orderBy('order')->get();
        });

        return $this->jsonResponse("Success", [
            "sections" => new SectionCollection($sections),
            // "categories" => $categories,
            "ads" => AdsResource::collection($ads),
            "custom_ads" => $this->customAds->transformCollection($customAd),
            "popup_ads" => AdsResource::collection($popup_ads),
            "banner_ads" => AdsResource::collection($banner_ads),
            "app_version" => [
                "ios" => "1",
                "android" => "1.1",
            ],
        ]);
    }

    public function initialize()
    {
        $categoriesWithGroups = CategoryWithGroupsResource::collection($this->categoriesRepo->getActiveCategories());
        $user = auth()->user();

        $user_active = false;

        if ($user) {
            $user->token = (string)JWTAuth::getToken();
            $user_profile = $this->customerTrans->transform($user);
            $notifications = Auth::user()->notifications()->orderBy("created_at", "DESC")->paginate(20)->getCollection();
            $unreadNotifications = $user->notifications()->where('read', 0)->count();

            $user_active = $user->active ? true : false;
        } else {
            $user_profile = null;
            $notifications = [];
            $unreadNotifications = 0;
        }

        $products = collect([]);
        $favourites = [];
        $compare = [];

        if (auth()->check() && $user->id != 999999) {
            $cart = $user->cart;
            $products = collect([]);

            if ($cart) {
                $cartItems = CartItem::with('product')->where('cart_id', $cart->id)->get();
                foreach ($cartItems as $cartItem) {
                    $product = $cartItem->product;
                    $product->amount = $cartItem->amount;
                    $products->push($product);
                }
            }


            $favourites = $user->favourites;
            $compare = $user->comparisons;
        }

        if (auth()->check() && $user->id == 999999) {
            $user_profile = null;
        }

        $products = $this->promotionsService->checkForDiscounts($products);
        $this->ordersService->customerCanBuyItems($products['items']);

        $localization = Country::where('country_code', config('app.country_code'))->first();
        if (!$localization) {
            $localization = Country::where('fallback', true)->first();
        }

        return $this->jsonResponse("Success", [
            "localization" => $localization,
            "categories" => $categoriesWithGroups,
            "profile" => $user_profile,
            "user_active" => $user_active,
            "cart" => $this->productTrans->transformCollection($products['items']),
            "favourites" => $this->productTrans->transformCollection($favourites),
            "compare" => $this->productTrans->transformCollection($compare),
            "notifications" => $notifications,
            "unreadNotifications" => $unreadNotifications
        ]);
    }
    /**
     * Get sections for home sections
     *
     * @return void
     */
    public function sections()
    {
        $sections = Cache::remember('sections', 60 * 30, function () {
            return Section::with(['images'])->where('active', 1)->orderBy('order')->get();
        });

        return $this->jsonResponse("Success", new SectionCollection($sections));
    }
    /**
     * Get ads for home sections
     *
     * @return void
     */
    public function ads()
    {
        $ads = Cache::remember('ads', 60 * 30, function () {
            return Ad::active()->where("popup", 0)->where("banner_ad", 0)->orderBy("order", "ASC")->get();
        });
        $ads->each->setAppends(["name"]);

        return $this->jsonResponse("Success",  AdsResource::collection($ads));
    }
    /**
     * Get custom ads for home sections
     *
     * @return void
     */
    public function customAds()
    {
        $customAd = Cache::remember('customAd', 60 * 30, function () {
            return CustomAd::all();
        });

        return $this->jsonResponse("Success", $this->customAds->transformCollection($customAd));
    }
}
