<?php


namespace App\Services\ExportFiles;


use App\Models\Repositories\ExportRepository;
use App\Services\Cache\CacheService;
use App\Services\ImportFiles\ImportConstants;
use App\Services\ImportFiles\ImportTemplate\Template;
use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

abstract class ExportFiles
{
    private $_ExportRepo;
    protected $_count;
    protected $_reportName = 'report_';

    public function __construct()
    {
        $this->_ExportRepo = new ExportRepository();
    }

    public abstract function prepareExportDataArray($filterData);

    public function export($type, $id, $filterData = null)
    {
        Log::channel('export')->info('Export , history id is ' . $id);
        try {
            Excel::create($this->_reportName . date("Ymd"), function ($excel) use ($type, $id, $filterData) {
                $excel->sheet('report', function ($sheet) use ($type, $id, $filterData) {
                    $sheet->row(1, (new Template($type))->getTemplate()->getTableColumns());
                    $index = 0;
                    foreach ($this->prepareExportDataArray($filterData) as $key => $item) {
                        if (!CacheService::checkStatus('export', $id, ExportConstants::STATE_CANCEL)) {
                            if (in_array($type, [ImportConstants::BRAND_TYPE, ImportConstants::PRODUCT_TYPE, ImportConstants::LISTS_TYPE])) {
                                $sheet->row($key + 2, $item);
                            } else {
                                $sheet->rows($item);
                            }
                            $index++;
                            $this->_ExportRepo->updateHistoryProgress(ceil($index / $this->_count) * 100, $id);
                        } else {
                            Log::channel('export')->info('Export canceled');
                            break;
                        }
                    }
                });
            })->download('csv');
        } catch (Exception $exception) {
            Log::channel('export')->error("Export error, history id is $id error is " . $exception->getMessage());
        }
    }
}
