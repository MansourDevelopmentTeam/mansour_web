<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Admin\CategoryGroupsResource;
use App\Models\Notifications\PushMessage;
use App\Http\Controllers\Controller;
use App\Models\Products\Category;
use App\Models\Products\Group;
use App\Models\Products\ProductReview;
use App\Models\Products\SubCategoryGroup;
use App\Models\Services\PushService;
use App\Models\Users\User;
use App\Sheets\Export\Groups\GroupsExport;
use App\Sheets\Import\Groups\GroupsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CategoryGroupsController extends Controller
{

    public function index()
    {
        $group = Group::get();
        return $this->jsonResponse("Success", CategoryGroupsResource::collection($group));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Group::$validation);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->valid();
        $group = Group::create($data);
        if (isset($data['sub_categories']) && is_array($data['sub_categories'])) {
            foreach ($data['sub_categories'] as $sub_category) {
                $category = Category::find($sub_category);
                if ($category->parent_id != null) {
                    $groupData = [
                        'group_id' => $group->id,
                        'category_id' => $category->parent->id,
                        'sub_category_id' => $category->id,
                    ];
                    SubCategoryGroup::create($groupData);
                }
            }
        }
        return $this->jsonResponse("Success", new CategoryGroupsResource($group->refresh()));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), Group::$validation);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->valid();
        $group = Group::find($id);
        if (!$group) {
            return $this->jsonResponse("Group Not Found", $group);
        }
        $group->update($data);
        SubCategoryGroup::where('group_id', $group->id)->delete();
        if (isset($data['sub_categories']) && is_array($data['sub_categories'])) {
            foreach ($data['sub_categories'] as $sub_category) {
                $category = Category::find($sub_category);
                if ($category->parent_id != null) {
                    $groupData = [
                        'group_id' => $group->id,
                        'category_id' => $category->parent->id,
                        'sub_category_id' => $category->id,
                    ];
                    SubCategoryGroup::updateOrCreate($groupData);
                }
            }
        }
        return $this->jsonResponse("Success", new CategoryGroupsResource($group->refresh()));
    }

    public function activate($id)
    {
        $group = Group::findOrFail($id);
        $group->active = 1;
        $group->save();
        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $group->active = 0;
        $group->save();
        return $this->jsonResponse("Success");
    }

    /**
     * Export categories group to excel
     *
     * @return void
     * @deprecated v1.0.0
     */
    public function export()
    {
        return Excel::download(new GroupsExport(), 'Groups_' . date("Ymd") . '.xlsx');
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
            $fileName = "CategoryGroups_" . date("Y_m_d H_i_s") . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/imports/category_groups', $fileName);
            Excel::import(new GroupsImport(), $path);
        } catch (\Exception $e) {
            Log::error("Import File Error: " . $e->getMessage());
            return $this->errorResponse($e->getMessage(), "Invalid data", [], 422);
        }
        return $this->jsonResponse("Success", null);
    }
}
