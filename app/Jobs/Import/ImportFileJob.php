<?php

namespace App\Jobs\Import;

use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Models\Import\ImportHistory;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Sheets\Import\Brands\BrandsImport;
use App\Services\ImportFiles\ImportFactory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Repositories\ImportRepository;
use App\Services\ImportFiles\ImportConstants;

class ImportFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deleteWhenMissingModels = true;

    protected $_importRepo;
    private $_filePath;
    private $_type;
    private $_id;
    private $listID;
    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filePath, $type, $id, $listID = null)
    {
        $this->_importRepo = new ImportRepository();
        $this->_filePath = $filePath;
        $this->_type = $type;
        $this->_id = $id;
        $this->listID = $listID;
        $this->user = auth()->User();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $history = ImportHistory::find($this->_id);
        if ($history->state != ImportConstants::STATE_CANCEL) {
            $this->_importRepo->changeState(ImportConstants::STATE_PROGRESS, $history->id);
            $importFiles = (new ImportFactory($this->_type, $this->_id, $this->listID))->import();
            Excel::import($importFiles, $this->_filePath);
            Log::channel('imports')->info("file Imported");
            $history->update(['report' => $importFiles->reportData]);
            $this->_importRepo->sendImportNotifications($importFiles->status, $importFiles->reportData, $importFiles->statusCode, $importFiles->errorMessage,$this->user);
        } else {
            Log::channel('imports')->info("import canceled");
        }
    }

    public function failed(Throwable $exception)
    {
        $history = ImportHistory::find($this->_id);
        $this->_importRepo->changeState(ImportConstants::STATE_ERROR, $history->id);
    }
}
