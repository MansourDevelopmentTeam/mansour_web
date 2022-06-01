<?php


namespace App\Services\ImportFiles;


use App\Jobs\StockNotifications;
use App\Models\Products\Product;
use App\Utils\ExcelValueBinder;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportStock extends ImportFiles
{

    public function import($file, $history_id)
    {
        Log::channel('imports')->info('Import Stocks, history id is ' . $history_id);

        $totalCount = 0;
        $totalUpdatedCount = 0;
        $totalMissedCount = 0;
        $missedDetails = [];
        try {
            $binder = new ExcelValueBinder;
            $rows = Excel::setValueBinder($binder)->load($file)->get()->toArray();
            if (!empty($rows)) {
                $index = 0;
                foreach ($rows as $row) {
                    if (!$this->checkImportCachedStatus($history_id, ImportConstants::STATE_CANCEL)) {
                        // $MainSku = isset($row['sku']) && !empty($row['sku']) ? $row['sku'] : '';
                        $productStock = isset($row['stock']) && !empty($row['stock']) && ($row['stock']) > 0 ? $row['stock'] : 0;
                        $productPrice = isset($row['price']) && !empty($row['price']) && ($row['price']) > 0 ? $row['price'] : 0;
                        $productActive = $row['active'] ?? null;
                        $productDiscountPrice = isset($row['discount_price']) && !empty($row['discount_price']) && ($row['discount_price']) > 0 ? $row['discount_price'] : null;
                        if (is_float($row['sku'])) {
                            $MainSku = (int)$row["sku"];
                        } else {
                            $MainSku = $row["sku"];
                        }

                        if (isset($row['sku']) && $row['sku'] != null) {
                            $product = Product::where('sku', $MainSku)->first();
                            $totalCount++;
                            if ($product) {
                                $data = [];
                                if (isset($row['stock']) && $row['stock'] !== null) {
                                    $data['stock'] = $productStock;
                                }
                                if (isset($row['price']) && $row['price'] != null) {
                                    $data['price'] = $productPrice;
                                    if (isset($row['discount_price']) && $row['discount_price'] != null) {
                                        $data['discount_price'] = $productDiscountPrice;
                                    } else {
                                        $data["discount_price"] = null;
                                    }
                                }

                                if (isset($row['active'])) {
                                    $data['active'] = (int)$productActive;
                                }

                                $totalUpdatedCount++;
                                $product->update($data);
                                if ($product->stock > 0) {
                                    dispatch(new StockNotifications($product));
                                }
                            } else {
                                $totalMissedCount++;
                                $missedDetails[] = 'Product with sku ' . $MainSku . '( Not Found )';
                            }
                        }
                        $index++;
                        $progress = ceil(($index / count($rows)) * 100);
                        $this->_importRepo->updateHistoryProgress($progress, $history_id);
                    } else {
                        Log::channel('imports')->info('Import Canceled');
                        break;
                    }
                }
            }

        } catch (\Exception $e) {
            Log::channel('imports')->error($e->getMessage());
            $this->_importRepo->changeState(ImportConstants::STATE_ERROR, $history_id);
        }
    }
}
