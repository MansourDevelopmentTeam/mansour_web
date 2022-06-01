<?php

namespace App\Jobs\Export;

use App\Models\Export\Export;
use App\Services\ExportFiles\ExportConstants;
use App\Services\ExportFiles\ExportFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ExportFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $_exportId;
    private $_type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $exportId)
    {
        $this->_exportId = $exportId;
        $this->_type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $history = Export::find($this->_exportId);
        if ($history->state != ExportConstants::STATE_CANCEL) {
            $importFiles = (new ExportFactory($this->_type))->export();
            $importFiles->export($this->_type, $this->_exportId);
            Log::channel('export')->info("file Imported");
        }else{
            Log::channel('export')->info("import canceled");
        }
    }
}
