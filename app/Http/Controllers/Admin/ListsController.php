<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ListResource;
use App\Models\Products\ListItems;
use App\Models\Products\Lists;
use App\Models\Products\Product;
use App\Models\Services\PushService;
use App\Models\Transformers\ProductFullTransformer;
use App\Sheets\Export\Lists\ExportListItems;
use App\Sheets\Import\Lists\ImportListItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ListsController extends Controller
{
    protected $pushService;
    private $lists;

    public function __construct(Lists $lists, PushService $pushService)
    {
        $this->lists = $lists;
        $this->pushService = $pushService;
    }

    public function index()
    {
        $lists = Lists::withCount('products')->get();

        $listsResources = ListResource::collection($lists);

        return $this->jsonResponse("Success", $listsResources);
    }

    public function show($id)
    {
        $list = Lists::withCount('products')->with("products")->findOrFail($id);

        $listsResource = new ListResource($list);

        return $this->jsonResponse("Success", $listsResource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Lists::$validation);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $data = $validator->valid();

        $list = Lists::create($data);

        if (isset($request->items) && is_array($request->items)) {
            foreach ($data['items'][0]['items'] as $item) {
                ListItems::create([
                    'list_id' => $list->id,
                    'item_id' => $item
                ]);
            }
        }

        return $this->jsonResponse("Success", $list->loadCount('products'));
    }

    public function update(Request $request, $id)
    {
        $list = Lists::findOrFail($id);

        $validator = Validator::make($request->all(), Lists::$validation);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $data = $validator->valid();
        $list->update($data);

        ListItems::where('list_id', $list->id)->delete();

        if (isset($request->items) && is_array($request->items)) {
            foreach ($data['items'][0]['items'] as $item) {
                ListItems::create([
                    'list_id' => $list->id,
                    'item_id' => $item
                ]);
            }
        }

        return $this->jsonResponse("Success", $list->loadCount('products'));
    }

    public function activate($id)
    {
        $list = Lists::findOrFail($id);

        $list->update(['active' => '1']);

        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        $list = Lists::findOrFail($id);

        $list->update(['active' => '0']);

        return $this->jsonResponse("Success");
    }

    public function sync()
    {
        $this->lists->sync();
        return $this->jsonResponse("Success", '');
    }

    public function exportListItems($id)
    {
        $list = Lists::findOrFail($id);
        $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $list->name_en);
        $fileName .= '_by_' . str_replace(' ', '_', auth()->user()->name);
        $fileName .= '_' . date("Y_m_d H_i_s") . '.xlsx';
        $filePath = 'public/exports/lists/List_' . $fileName;
        $fileUrl = url("storage/exports/lists") . '/List_' . $fileName;
        Excel::store(new ExportListItems($list->id), $filePath);
        $this->pushService->notifyAdmins("File Exported ", "Your export has completed! You can download the file from", '', 11, $fileUrl, auth()->User()->id);
        return $this->jsonResponse("Success");
    }

    public function importListItems(Request $request, $id)
    {
        $this->validate($request, ["file" => "required"]);
        $list = Lists::findOrFail($id);
        $missedItems = [];
        try {

            $file = $request->file('file');
            $fileName = $list->name_en . "_by_" . auth()->user()->name . "_" . date("Y_m_d H_i_s") . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/imports/lists', $fileName);
            $pathUrl = Str::replaceFirst('public/', 'storage/', $path);
            Excel::import(new ImportListItems($list->id, $this->pushService), $path);
            Log::channel('imports')->info('Action: import Custom list, File link: ' . url($pathUrl) . ' Admin name: ' . auth()->user()->name . ' Date: ' . now());

        } catch (\Exception $e) {
            Log::error("Import File Error: " . $e->getMessage());
            return $this->errorResponse($e->getMessage(), "Invalid data", [], 422);
        }
        return $this->jsonResponse("Success", $missedItems);


        $totalCount = 0;
        $totalAddedCount = 0;
        $totalMissedCount = 0;
        $missedDetails = [];
        $this->validate($request, ["file" => "required"]);
        $list = Lists::findOrFail($id);
        try {
            Excel::load($request->file, function ($reader) use ($list, &$totalCount, &$totalAddedCount, &$totalMissedCount, &$missedDetails) {
                // Loop through all sheets
                $results = $reader->all();
                //$list->listItems()->delete();
                foreach ($results as $key => $record) {
                    $totalCount++;
                    $product = Product::where('sku', $record)->first();
                    if ($product) {
                        $totalAddedCount++;
                        $data = [
                            'item_id' => $product->id,
                            'list_id' => $list->id,
                        ];
                        ListItems::updateOrCreate($data);
                    } else {
                        $totalMissedCount++;
                        $missedDetails[] = 'product with sku ' . $record . '( Sku Not Found )';
                    }
                }
            });
        } catch (\Exception $e) {
            Log::error("HandleFileError: " . $e->getMessage());
        }
        $data = [
            'total_count'       => $totalCount,
            'total_added_count' => $totalAddedCount,
            'missed_count'      => $totalMissedCount,
            'missed_details'    => $missedDetails,
        ];


        return $this->jsonResponse("Success");
    }

    public function destroy($id)
    {
        $list = Lists::findOrFail($id);
        $list->delete();
        return $this->jsonResponse("Success");
    }
}
