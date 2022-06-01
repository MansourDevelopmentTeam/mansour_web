<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CustomerRequestRequest;
use App\Models\Users\CustomerRequest;

class CustomerRequestController extends Controller
{
    public function index()
    {
        $requests = CustomerRequest::paginate(20);
        return $this->jsonResponse("Success", $requests);
    }

    /**
     * Create new category with subcategories
     *
     * @param CustomerRequestRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CustomerRequestRequest $request)
    {
        $data = $request->validated();
        CustomerRequest::create($data);
        return $this->jsonResponse(__('message.customer_request_succeeded'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        CustomerRequest::destroy($id);
        return $this->jsonResponse("Success");
    }
}
