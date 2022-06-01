<?php


namespace App\Services\ImportFiles;


use App\Models\Products\Option;
use App\Models\Products\OptionValue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportOptions extends ImportFiles
{

    public function import($file, $history_id)
    {
        Log::channel('imports')->info('Import Options, history id is ' . $history_id);
        try {
            Excel::load($file, function ($reader) use($history_id) {
                // Loop through all sheets

                $results = $reader->all();
                $optionData = null;
                $index = 0;
                foreach ($results as $key => $row) {
                    if (!$this->checkImportCachedStatus($history_id, ImportConstants::STATE_CANCEL)) {
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

                        $color_code = $row['hex_code'] ?? '';
                        $image = $row['image'] ?? '';
                        $data = [];
                        $valData = [];
                        $data = [
                            "name_en" => $row['option'] ?? '',
                            "name_ar" => $row['option_ar'] ?? '',
                            "type" => $type,
                        ];
                        $valData = [
                            "name_en" => $row['values'] ?? '',
                            "name_ar" => $row['values_ar'] ?? '',
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

                        $index++;
                        $progress = ceil(($index / count($results)) * 100);
                        $this->_importRepo->updateHistoryProgress($progress, $history_id);

                    }else{
                        Log::channel('imports')->info('Import Canceled');
                        break;
                    }
                }
            });
        } catch (\Exception $e) {
            Log::channel('imports')->error("HandleFileError: " . $e->getMessage());
            $this->_importRepo->changeState(ImportConstants::STATE_ERROR, $history_id);
        }
    }
}