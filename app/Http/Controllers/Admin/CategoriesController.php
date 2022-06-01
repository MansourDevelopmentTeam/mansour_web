<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Products\Option;
use Illuminate\Validation\Rule;
use App\Models\Products\Product;
use App\Models\Products\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Services\PushService;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Products\CategoryOption;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Repositories\ProductRepository;
use App\Models\Repositories\CategoriesRepository;
use App\Sheets\Export\Categories\CategoriesExport;
use App\Sheets\Import\Categories\CategoriesImport;

class CategoriesController extends Controller
{
    private $categoriesRepo;
    private $productsRepo;

    protected $pushService;

    public function __construct(CategoriesRepository $categoriesRepo, ProductRepository $productsRepo, PushService $pushService)
    {
        $this->categoriesRepo = $categoriesRepo;
        $this->productsRepo = $productsRepo;
        $this->pushService = $pushService;
    }

    public function index()
    {
        $categories = $this->categoriesRepo->getMainCategories();

        //$categories = $categories->transform(function ($item) {
        //    $item->product_count = $item->getProductCount();
        //    $item->products = [];
        //    return $item;
        //});
        return $this->jsonResponse("Success", $categories);
    }

    /**
     * Create new category with subcategories
     *
     * @param CategoryRequest $request
     * @return void
     */
    public function store(CategoryRequest $request)
    {
        $request->merge(["created_by" => auth()->user()->id, "slug" => Str::slug($request->get('slug'), '-'), "active" => true]);

        DB::beginTransaction();
        try {
            $category = Category::firstOrCreate($request->only(["name", "slug", "name_ar", "description", "description_ar", "created_by", "order", "image"]));

            foreach ($request->sub_categories as $sub) {
                $subCategorySlug = Str::slug($sub['slug'], '-');
                $subCategorySlugExists = Category::where('slug', $subCategorySlug)->exists();
                if ($subCategorySlugExists) {
                    return $this->errorResponse(
                        "Sub-category slug ({$sub['slug']}) is already exists in categories table",
                        "Sub-category slug ({$sub['slug']}) is already exists in categories table"
                    );
                    // throw new \Exception("Sub-category slug ({$sub['slug']}) is already exists in categories table");
                }

                $subCatOrder = isset($sub["order"]) ? $sub["order"] : 0;
                $subCategory = $category->subCategories()->firstOrCreate([
                    "name" => $sub["name"],
                    "name_ar" => $sub["name_ar"] ?? null,
                    "image" => $sub["image"] ?? null,
                    "slug" => $sub['slug'],
                    "active" => 1,
                    "slug" => $subCategorySlug,
                    'order' => $subCatOrder,
                    'ex_rate_pts' => $sub['ex_rate_pts'] ?? null,
                    'ex_rate_egp' => $sub['ex_rate_egp'] ?? null,
                    'payment_target' => $sub['payment_target'] ?? null
                ]);
    
                if (isset($sub['options']) && is_array($sub['options'])) {
                    foreach ($sub['options'] as $optionID) {
                        $option = Option::find($optionID);
                        if ($option) {
                            $categoryOptionData = [
                                'sub_category_id' => $subCategory->id,
                                'option_id' => $optionID,
                                'created_by' => auth()->user()->id,
                            ];
                            CategoryOption::create($categoryOptionData);
                        }
                    }
                }
            }
            DB::commit();
            return $this->jsonResponse("Success", $category->load("subCategories", "creator"));
        } catch (Exception $e) {
            DB::rollback();
            return $this->errorResponse($e->getMessage(), "Invalid data", [], 422);
        }
    }

    public function show($id)
    {
        $category = $this->categoriesRepo->getCategoryById($id);

        return $this->jsonResponse("Success", $category->load("subCategories"));
    }

    /**
     * Update category with subcategories
     *
     * @param CategoryRequest $request
     * @param int $id
     * @return void
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = $this->categoriesRepo->getCategoryById($id);
//        $request->merge(["slug" => Str::slug($request->get('slug'), '-')]);

//        $category->update($request->only(["name", "slug", "name_ar", "description", "description_ar", "order", "image", "active"]));
        $category->update($request->only(["order", "image"]));

//        if ($request->deleted_ids) {
//            $deleted_ids = $request->deleted_ids;
//            Category::whereIn("id", $deleted_ids)->delete();
//        }


        foreach ($request->sub_categories as $sub) {
            $subCatOrder = isset($sub["order"]) ? $sub["order"] : 0;
//            $subCategorySlug = Str::slug($sub['slug'], '-');
//            $subCategorySlugExists = Category::where('slug', $subCategorySlug)->where('id', '!=', $sub['id'])->exists();
//            if ($subCategorySlugExists) {
//                return $this->errorResponse(
//                    "Sub-category slug ({$sub['slug']}) is already exists in categories table",
//                    "Sub-category slug ({$sub['slug']}) is already exists in categories table"
//                );
                // throw new \Exception("Sub-category slug ({$sub['slug']}) is already exists in categories table");
//            }

            if (isset($sub["id"])) {
                $subCategory = Category::find($sub["id"]);

                $subCategory->update([
//                    "name" => $sub["name"] ?? null,
//                    "name_ar" => $sub["name_ar"] ?? null,
//                    "slug" => $sub['slug'] ?? null,
                    "image" => $sub["image"] ?? null,
                    "order" => $subCatOrder,
                    'ex_rate_pts' => $sub['ex_rate_pts'] ?? null,
                    'ex_rate_egp' => $sub['ex_rate_egp'] ?? null,
//                    'payment_target' => $sub['payment_target'] ?? null
                ]);

//                CategoryOption::whereNotIn('option_id', $sub['options'])->where('sub_category_id', $sub["id"])->delete();

//                if (is_array($sub['options'])) {
//                    foreach ($sub['options'] as $optionID) {
//                        $option = Option::find($optionID);
//                        $catOption = CategoryOption::where('option_id', $optionID)->where('sub_category_id', $sub["id"])->first();
//                        if (!isset($catOption) && isset($option)) {
//                            $categoryOpthionData = [
//                                'sub_category_id' => $subCategory->id,
//                                'option_id' => $optionID,
//                                'created_by' => auth()->user()->id,
//                            ];
//                            CategoryOption::create($categoryOpthionData);
//                        }
//                    }
//                }
            } else {
//                $subCategory = $category->subCategories()->create([
//                    "name" => $sub["name"],
//                    "name_ar" => $sub["name_ar"],
//                    "image" => $sub["image"],
//                    "active" => 1,
//                    "order" => $subCatOrder
//                ]);
//                if (isset($sub['options']) && is_array($sub['options'])) {
//                    foreach ($sub['options'] as $optionID) {
//                        $option = Option::find($optionID);
//                        if ($option) {
//                            $categoryOpthionData = [
//                                'sub_category_id' => $subCategory->id,
//                                'option_id' => $optionID,
//                                'created_by' => auth()->user()->id,
//                            ];
//                            CategoryOption::create($categoryOpthionData);
//                        }
//                    }
//                }
            }
        }

        return $this->jsonResponse("Success", $category->load("subCategories"));
    }

    public function getProducts($id)
    {
        $category = $this->categoriesRepo->getCategoryById($id);

        $products = Product::whereNotNull('parent_id')->active()->where("category_id", $category->id)->get(["id", "name", "image", "price", "sku", "parent_id"]);

        return $this->jsonResponse("Success", $products);
    }

    public function activate($id)
    {
        $category = $this->categoriesRepo->getCategoryById($id);

        $category->active = 1;
        $category->deactivation_notes = null;
        $category->save();

        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        // validate request
        $validator = Validator::make($request->all(), ["deactivation_notes" => "required"]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $category = $this->categoriesRepo->getCategoryById($id);

        $category->active = 0;
        $category->deactivation_notes = $request->deactivation_notes;
        $category->save();

        return $this->jsonResponse("Success");
    }

    public function destroy($id)
    {
        $category = $this->categoriesRepo->getCategoryById($id);

        $category->delete();

        return $this->jsonResponse("Success");
    }

    /**
     * Export categories to excel
     *
     * @return void
     */
    public function export()
    {
        $fileName = 'Categories__by_' . auth()->user()->name . '_' . date("Y_m_d H_i_s") . '.xlsx';
        $filePath = 'public/exports/categories/' . $fileName;
        Excel::store(new CategoriesExport, $filePath);
        $fileUrl = url("storage/exports/categories") ."/". $fileName;
        Log::channel('exports')->info('Action: Export categories, File link: ' . url($filePath) . ' Admin name: ' . auth()->user()->name . ' Date: ' . now());
        $this->pushService->notifyAdmins("File Exported ", "Your export has completed! You can download the file from", '', 11, $fileUrl, auth()->user()->id);
        return $this->jsonResponse("Success");
    }

    /**
     * Import categories to excel
     *
     * @param Request $request
     * @return void
     * @deprecated v1.0.0
     *
     */
    public function import(Request $request)
    {
        $this->validate($request, ["file" => "required"]);
        try {
            $file = $request->file('file');
            $fileName = "Categories_" . date("Y_m_d H_i_s") . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/imports/categories', $fileName);
            Excel::import(new CategoriesImport(), $path);
        } catch (\Exception $e) {
            Log::error("Import File Error: " . $e->getMessage());
            return $this->errorResponse($e->getMessage(), "Invalid data", [], 422);
        }
        return $this->jsonResponse("Success", null);
    }
}
