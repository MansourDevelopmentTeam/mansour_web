<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Products\Category;
use App\Models\Repositories\CategoriesRepository;
use App\Models\Repositories\ProductRepository;
use App\Models\Transformers\Customer\CategoryTransformer;
use App\Models\Transformers\ProductTransformer;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
	private $categoriesRepo;
    private $productTrans;
    private $productsRepo;
    private $categoryTrans;

	public function __construct(CategoriesRepository $categoriesRepo, ProductTransformer $productTrans, ProductRepository $productsRepo, CategoryTransformer $categoryTrans)
	{
		$this->categoriesRepo = $categoriesRepo;
        $this->productTrans = $productTrans;
        $this->productsRepo = $productsRepo;
        $this->categoryTrans = $categoryTrans;
	}

    
    public function index()
    {
    	return $this->jsonResponse("Success", $this->categoryTrans->transformCollection($this->categoriesRepo->getActiveCategories()));
    }

    public function getProducts($id)
    {
    	$category = $this->categoriesRepo->getCategoryById($id);

        $products = $this->productsRepo->getProductsByCategory($category->id);
        $total = $this->productsRepo->getProductsByCategoryCount($category->id);

        $pages = $total / 10;

        return response()->json([
            "code" => 200,
            "message" => "Success",
            "data" => $this->productTrans->transformCollection($products),
            "total" => ceil($pages)
            ], 200);
    }
}
