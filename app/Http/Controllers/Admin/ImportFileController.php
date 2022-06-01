<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Jobs\Import\ImportFileJob;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Import\ImportHistory;
use App\Services\Cache\CacheService;
use App\Models\Services\UploadService;
use Illuminate\Support\Facades\Storage;
use App\Models\Repositories\ImportRepository;
use App\Services\ImportFiles\ImportConstants;
use Illuminate\Validation\ValidationException;
use App\Services\ImportFiles\ImportTemplate\Template;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Http\Resources\Admin\Import\ImportHistoryResource;
use App\Services\ImportFiles\ImportValidation\ImportValidation;


class ImportFileController extends Controller
{

    private $_importRepo;

    public function __construct()
    {
        $this->_importRepo = new ImportRepository();
    }


    public function index(Request $request): JsonResponse
    {
        $query = ImportHistory::query();
        $filter = $this->_importRepo->filter($request->all(), $query)->paginate(10);
        $results = [];
        $results['total'] = $filter->total();
        $results['pages'] = $filter->lastPage();
        $results['items'] = ImportHistoryResource::collection($filter);
        return $this->jsonResponse('success', $results);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function checkFileValidation(Request $request)
    {
        $this->validate($request, ["file" => "required", "type" => "required|integer"]);
        $validationFile = new ImportValidation($request->type, $request->file);
        if ($validationFile->isEmptyFile()) {
            return $this->jsonResponse('File is empty');
        }
        if (!$validationFile->isValidFileTemplate()) {
            return $this->errorResponse('Failed to import', $validationFile->getMissingFields());
        }
        $fileContent = $validationFile->getFileContent();
        $firstRow = array_combine($fileContent[0], $fileContent[1]);
        $data = [
            'first_row' => $firstRow,
            'total_rows_count' => count($fileContent),
        ];
        return $this->jsonResponse('Success', $data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function import(Request $request)
    {
        $this->validate($request, ["file" => "required", "type" => "required|integer", "list_id" => "required_if:type,==,7"]);
        $validationFile = new ImportValidation($request->type, $request->file);
        if ($validationFile->isEmptyFile()) {
            return $this->jsonResponse('File is empty');
        }
        if (!$validationFile->isValidFileTemplate()) {
            return $this->errorResponse('Failed to import', $validationFile->getMissingFields());
        }
        $response = (new UploadService())->uploadWithCustomPath($request, 'import');
        $type = $request->type;
        $id = $this->_importRepo->storeHistory($type, $response['filePath']);

        Log::channel('imports')->info("DISPATCHING IMPORT", ["id" => $id, "path" => $response]);
        $job = (new ImportFileJob($response['name'], $type, $id, $request->list_id))->onQueue('import')->delay(Carbon::now()->addSeconds(5));
        $this->dispatch($job);
        return $this->jsonResponse("Success", ImportHistoryResource::make(ImportHistory::find($id)));
    }

    public function retryImport(Request $request,$historyID)
    {
        $oldHistory = ImportHistory::findOrFail($historyID);
        $id = $this->_importRepo->storeHistory($oldHistory->type, $oldHistory->file_path);
        $separatedFilePath = explode('storage/', $oldHistory->file_path);
        $filePath =public_path('storage/' . $separatedFilePath[1]);
        $job = (new ImportFileJob($filePath, $oldHistory->type, $id))->onQueue('import')->delay(Carbon::now()->addSeconds(5));
        $this->dispatch($job);
        return $this->jsonResponse("Success", ImportHistoryResource::make(ImportHistory::find($id)));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws \Exception
     */
    public function getTemplate(Request $request): JsonResponse
    {
        $this->validate($request, ['type' => 'required']);
        return (new Template($request->type))->getTemplate()->downloadTemplate();
        // return $this->jsonResponse("Success");
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function ImportCancel(Request $request): JsonResponse
    {
        $this->validate($request, ['history_id' => 'required']);
        $this->_importRepo->changeState(ImportConstants::STATE_CANCEL, $request->history_id);
        CacheService::addNewFileStatus('import', ImportConstants::STATE_CANCEL, $request->history_id);
        return $this->jsonResponse('success');
    }

}
