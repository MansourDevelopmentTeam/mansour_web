<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Resources\ExportFileResource;
use App\Jobs\Export\ExportFilesJob;
use App\Models\Export\Export;
use App\Models\Repositories\ExportRepository;
use App\Services\Cache\CacheService;
use App\Services\ExportFiles\ExportConstants;
use App\Services\ExportFiles\ExportFactory;
use App\Services\ExportFiles\ExportProduct;
use App\Services\ImportFiles\ImportValidation\ImportValidation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ExportController extends Controller
{
    private $_exportRepo;

    public function __construct(){
        $this->_exportRepo = new ExportRepository();
    }

    public function index(Request $request): JsonResponse
    {
        $query = Export::query();
        $filter = $this->_exportRepo->filter($request->all(), $query)->paginate(10);
        $results = [];
        $results['total'] = $filter->total();
        $results['pages'] = $filter->lastPage();
        $results['items'] = ExportFileResource::collection($filter);
        return $this->jsonResponse('success', $results);
    }

    /**
     * @throws ValidationException
     */
    public function export(Request $request): JsonResponse
    {
        $this->validate($request, ['type' => 'required', "list_id" => "required_if:type,==,6"]);
        $type = $request->type;
        $id = $this->_exportRepo->addNewExport($type);
        $job = (new ExportFilesJob($type, $id))->onQueue('export')->delay(Carbon::now()->addSeconds(5));
        $this->dispatch($job);
        return $this->jsonResponse("Prepare your file", ExportFileResource::make(Export::find($id)));
    }

    /**
     * @throws ValidationException
     */
    public function cancel(Request $request): JsonResponse
    {
        $this->validate($request, ['history_id' => 'required']);
        $this->_exportRepo->changeState(ExportConstants::STATE_CANCEL, $request->history_id);
        CacheService::addNewFileStatus('export', ExportConstants::STATE_CANCEL, $request->history_id);
        return $this->jsonResponse('success');
    }

    /**
     * @throws \Exception
     */
    public function test(Request $request){

       $export = new ImportValidation($request->type, 'C:\xampp\htdocs\mobilaty-backend\storage\app\public\uploads\import\MXIKej-1627568147.csv');
    }
}
