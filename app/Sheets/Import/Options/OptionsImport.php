<?php

namespace App\Sheets\Import\Options;

use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Models\Products\Option;
use App\Models\Products\OptionValue;
use App\Models\Products\Tag;
use App\Services\ImportFiles\ImportConstants;
use App\Services\ImportFiles\ImportFiles;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;

class OptionsImport extends ImportFiles implements ToCollection, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    protected $history_id;
    public $reportData;
    public $status;
    public $statusCode;
    public $errorMessage;

    public function __construct($history_id)
    {
        parent::__construct();
        $this->history_id = $history_id;
    }

    public function collection(Collection $rows)
    {

        try {
            if (!empty($rows)) {
                $optionData = null;
                $index = 0;
                foreach ($rows as $row) {
                    if (!$this->checkImportCachedStatus($this->history_id, ImportConstants::STATE_CANCEL)) {
                        $type = 1;
                        if (isset($row['type'])) {
                            if ($row['type'] == 'text') {
                                $type = 1;
                            } elseif ($row['type'] == 'color code') {
                                $type = 2;
                            } elseif ($row['type'] == 'image') {
                                $type = 3;
                            } elseif ($row['type'] == 'variant image') {
                                $type = 4;
                            } elseif ($row['type'] == 'input') {
                                $type = 5;
                            }
                        }

                        $color_code = isset($row['hex_code']) ? $row['hex_code'] : '';
                        $image = isset($row['image']) ? $row['image'] : '';
                        $data = [];
                        $valData = [];
                        $data = [
                            "name_en" => isset($row['option']) ? $row['option'] : '',
                            "name_ar" => isset($row['option_ar']) ? $row['option_ar'] : '',
                            "type" => $type,
                        ];
                        $valData = [
                            "name_en" => isset($row['values']) ? $row['values'] : '',
                            "name_ar" => isset($row['values_ar']) ? $row['values_ar'] : '',
                        ];
                        if ($row['option'] != null || $row['option_ar'] != null) {
                            $option = Option::where("name_en", $row['option'])->first();
                            if ($option) {
                                $option->update($data);
                                if ($row['values'] != null || $row['values_ar'] != null) {
                                    $optionValue = OptionValue::where("name_en", $row['values'])->where('option_id', $option->id)->first();
                                    if ($optionValue) {
                                        ($option->type == 2 || $option->type == 4) ? $valData['color_code'] = $color_code : $valData['color_code'] = '';
                                        $option->type == 3 ? $valData['image'] = $image : $valData['image'] = '';
                                        $optionValue->update($valData);
                                    } else {
                                        ($option->type == 2 || $option->type == 4) ? $valData['color_code'] = $color_code : $valData['color_code'] = '';
                                        $option->type == 3 ? $valData['image'] = $image : $valData['image'] = '';
                                        $valData['option_id'] = $option->id;
                                        OptionValue::create($valData);
                                    }
                                }
                            } else {
                                if ($row['values'] != null || $row['values_ar'] != null) {
                                    $item = Option::where("name_en", $row['option'])->first();
                                    if ($item) {
                                        ($optionData->type == 2 || $optionData->type == 4) ? $valData['color_code'] = $color_code : $valData['color_code'] = '';
                                        $optionData->type == 3 ? $valData['image'] = $image : $valData['image'] = '';
                                        $valData['option_id'] = $option->id;
                                        OptionValue::create($valData);
                                    } else {
                                        $option = Option::create($data);
                                    }
                                    ($optionData->type == 2 || $optionData->type == 4) ? $valData['color_code'] = $color_code : $valData['color_code'] = '';
                                    $optionData->type == 3 ? $valData['image'] = $image : $valData['image'] = '';
                                    $valData['option_id'] = $option->id;
                                    OptionValue::create($valData);
                                } else {
                                    $option = Option::create($data);
                                }
                            }
                            $optionData = $option;
                        } else {
                            if ($optionData) {
                                $optionValue = OptionValue::where("name_en", $row['values'])->where('option_id', $optionData->id)->first();
                                if ($optionValue) {
                                    ($optionData->type == 2 || $optionData->type == 4) ? $valData['color_code'] = $color_code : $valData['color_code'] = '';
                                    $optionData->type == 3 ? $valData['image'] = $image : $valData['image'] = '';
                                    $optionValue->update($valData);
                                } else {
                                    ($optionData->type == 2 || $optionData->type == 4) ? $valData['color_code'] = $color_code : $valData['color_code'] = '';
                                    $optionData->type == 3 ? $valData['image'] = $image : $valData['image'] = '';
                                    $valData['option_id'] = $optionData->id;
                                    OptionValue::create($valData);
                                }
                            }
                        }
                        // update progress
                        $index++;
                        $progress = ceil(($index / count($rows)) * 100);
                        $this->_importRepo->updateHistoryProgress($progress, $this->history_id);
                        $this->status = 'success';
                    } else {
                        $this->status = 'cancelled';
                        Log::channel('imports')->info("Import canceled, history id is $this->history_id");
                        break;
                    }
                }
                $this->_importRepo->changeState(ImportConstants::STATE_COMPLETE, $this->history_id);
                $this->statusCode = '200';
                $this->reportData = $data;
                $this->errorMessage = null;
            }
        } catch (\Exception $e) {
            $this->status = 'error';
            $this->statusCode = '422';
            $this->reportData = $data;
            $this->errorMessage = $e->getMessage();
            Log::channel('imports')->error($e->getMessage());
            $this->_importRepo->changeState(ImportConstants::STATE_ERROR, $this->history_id);
        }
    }

    public function onError(\Throwable $e)
    {
    }

    public function onFailure(Failure ...$failures)
    {
    }

    public function import($file, $history_id)
    {
        // TODO: Implement import() method.
    }
}
