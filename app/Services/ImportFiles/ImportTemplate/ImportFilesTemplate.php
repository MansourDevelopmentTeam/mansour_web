<?php


namespace App\Services\ImportFiles\ImportTemplate;

use Maatwebsite\Excel\Facades\Excel;

abstract class ImportFilesTemplate
{
    protected $templatePath;

    public function getTableColumns(): array
    {
        return array_merge($this->mandatoryColumns(), $this->optionalColumns());
    }

    /**
     * @return mixed
     *  export template function
     */
    public function exportGeneratedTemplate(){
        return Excel::create('Template_' . date("Ymd"), function ($excel){
            $excel->sheet('report', function ($sheet){
                $sheet->row(1, $this->getTableColumns());
            });
        })->download('xlsx');
    }

    public function downloadTemplate()
    {
        $name = basename(public_path($this->templatePath));
        header('Content-Type: "application/octet-stream');
        header('Content-Disposition: attachment; filename='.$name);
        header('Pragma: no-cache');
        readfile(public_path($this->templatePath));
    }
}
