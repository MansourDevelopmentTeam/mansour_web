<?php

namespace App\Http\Controllers\Admin;


use App\Facade\Sms;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Services\SmsService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Models\Repositories\CustomerRepository;

class DashboardController extends Controller
{
    private $customerRepo;

    public function __construct(CustomerRepository $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }

    
    public function index()
    {
        $products = Product::MainProduct()->count();
        $orders = Order::count();
        $customers = $this->customerRepo->customerCount();

        $sms = Sms::getBalance();

        return $this->jsonResponse("Success", [
            "products" => $products,
            "orders" => $orders,
            "customers" => $customers,
            "smsCredit" => !empty(config('integrations.sms.default')) ? (int) $sms : 0
        ]);
    }
    public function clearCache()
    {
        Artisan::call('cache:clear');
        return $this->jsonResponse("cache Cleared Successfully", null);
    }
}
