<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Products\Ad;
use App\Models\Transformers\Customer\AdsTransformer;
use Illuminate\Http\Request;

class AdsController extends Controller
{
	private $adsTransformer;

	public function __construct(AdsTransformer $adsTransformer)
	{
		$this->adsTransformer = $adsTransformer;
	}

    
    public function index()
    {
    	$ads = Ad::active()->get();

    	$ads->each->setAppends([]);
    	return $this->jsonResponse("Success", $this->adsTransformer->transform($ads));
    }
}
