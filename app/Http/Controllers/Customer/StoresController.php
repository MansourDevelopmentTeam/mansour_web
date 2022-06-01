<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Trolley\Pages\Page;
use App\Trolley\Products\Lists;
use App\Trolley\Stores\Store;
use App\Models\Transformers\Customer\ListTransformer;
use App\Models\Transformers\Customer\PagesTransformer;
use App\Models\Transformers\Customer\StoresTransformer;

class StoresController extends Controller
{
    private $storeTrans;

    public function __construct(StoresTransformer $storeTrans)
    {
        $this->storeTrans = $storeTrans;
    }

    public function getAllStores()
    {
        $store = Store::where('active',1)->get();
        $storeTransform = $this->storeTrans->transformCollection($store);
        return $this->jsonResponse("Success", $storeTransform);

    }
}
