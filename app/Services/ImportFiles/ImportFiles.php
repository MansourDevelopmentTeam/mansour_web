<?php


namespace App\Services\ImportFiles;


use App\Models\Import\ImportHistory;
use App\Models\Repositories\ImportRepository;
use App\Services\Cache\CacheService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

abstract class ImportFiles
{
    protected $_importRepo;
    public function __construct(){
        $this->_importRepo = new ImportRepository();
    }

    abstract public function import($file, $history_id);

    protected function checkImportCachedStatus($id, $status): bool{
       return CacheService::checkStatus('import', $id, $status);
    }
}