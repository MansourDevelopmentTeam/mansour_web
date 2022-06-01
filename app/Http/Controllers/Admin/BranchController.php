<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Branch\Branch;
use App\Models\Products\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\BranchRequest;
use App\Http\Resources\Admin\BranchResource;

class BranchController extends Controller
{
    /**
     * List branches
     *
     * @return void
     */
    public function index()
    {
        $branches = Branch::query();
        $queryWord = request('q');
        if($queryWord) {
            $branches->where(function($q) use ($queryWord){
                $q->where('shop_name', 'like', "%$queryWord%")
                    ->orWhere('shop_name_ar', 'like', "%$queryWord%")
                    ->orWhere('phone', 'like', "%$queryWord%");
            });
        }
        $branches = $branches->paginate(20);
        $total = $branches->total();
        return $this->jsonResponse("Success", ['branches' => BranchResource::collection($branches), "total" => $total]);
    }

    public function show($id)
    {
        $branch = Branch::find($id);
        return $this->jsonResponse("Success", new BranchResource($branch));
    }

    /**
     * Create a new branch
     *
     * @param BranchRequest $request
     * @return void
     */
    public function store(BranchRequest $request)
    {
        $branch = Branch::create($request->validated());

        return $this->jsonResponse("Success", new BranchResource($branch));
    }

    /**
     * Update  branch details
     *
     * @param BranchRequest  $request
     * @param Branch  $branch
     * @return void
     */
    public function update(BranchRequest $request, Branch $branch)
    {
        // TODO: Delete Removed Images
        $branch->update($request->validated());
        return $this->jsonResponse("Success", new BranchResource($branch));
    }

    /**
     * Delete branch
     *
     * @param Branch $branch
     * @return void
     */
    public function destroy(Branch $branch)
    {
        // TODO: Delete Removed Images
        $branch->delete();
        return $this->jsonResponse("Success");
    }

}
