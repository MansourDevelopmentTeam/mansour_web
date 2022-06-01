<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Branch\Branch;
use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\BranchResource;

class BranchController extends Controller
{
    /**
     * List branches
     *
     * @return void
     */
    public function index()
    {
        $branches = Branch::all()->groupBy('type')->sortBy('order');

        return $this->jsonResponse("Success", BranchResource::collection($branches)->values());
    }
}
