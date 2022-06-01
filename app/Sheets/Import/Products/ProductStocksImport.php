<?php

namespace App\Sheets\Import\Products;

use App\Jobs\StockNotifications;
use App\Models\Inventories\Inventory;
use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Models\Products\CategoryOption;
use App\Models\Products\Option;
use App\Models\Products\OptionValue;
use App\Models\Products\Product;
use App\Models\Products\ProductOptionValues;
use App\Models\Products\ProductTag;
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

class ProductStocksImport extends ImportFiles implements ToCollection, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    private $pushService;
    private $approved;
    protected $history_id;
    public $reportData;
    public $status;
    public $statusCode;
    public $errorMessage;

    public function __construct($history_id = null)
    {
        parent::__construct();
        $this->history_id = $history_id;
    }

    public function collection(Collection $rows)
    {
        Log::channel('imports')->info('Import Stocks, history id is ' . $this->history_id);
        $totalCount = 0;
        $totalUpdatedCount = 0;
        $totalMissedCount = 0;
        $index = 0;
        $missedDetails = [];
        try {
            if (!empty($rows)) {
                foreach ($rows as $row) {
                    if (!$this->checkImportCachedStatus($this->history_id, ImportConstants::STATE_CANCEL)) {
                        Log::info($row);
                        // $MainSku = isset($row['sku']) && !empty($row['sku']) ? $row['sku'] : '';
                        $productStock = isset($row['stock']) && !empty($row['stock']) && ($row['stock']) > 0 ? $row['stock'] : 0;
                        $productPrice = isset($row['price']) && !empty($row['price']) && ($row['price']) > 0 ? $row['price'] : 0;
                        $productActive = isset($row['active']) ? $row['active'] : null;
                        $productDiscountPrice = isset($row['discount_price']) && !empty($row['discount_price']) && ($row['discount_price']) > 0 ? $row['discount_price'] : null;
                        $productDiscountPriceStartDate = isset($row['discount_start_date']) && !empty($row['discount_start_date']) && ($row['discount_start_date']) > 0 ? $row['discount_start_date'] : null;
                        $productDiscountPriceEndDate = isset($row['discount_end_date']) && !empty($row['discount_end_date']) && ($row['discount_end_date']) > 0 ? $row['discount_end_date'] : null;
                        $productPaymentDiscount = isset($row['payment_methods']) && !empty($row['payment_methods']) ? explode(',', $row['payment_methods']) : null;
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
                                        $data['discount_start_date'] = $productDiscountPriceStartDate;
                                        $data['discount_end_date'] = $productDiscountPriceEndDate;
                                        $product->paymentMethods()->sync($productPaymentDiscount);
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
                        $this->_importRepo->updateHistoryProgress($progress, $this->history_id);
                        $this->status = 'success';
                    } else {
                        $this->status = 'cancelled';
                        Log::channel('imports')->info('Import Canceled');
                        break;
                    }
                }
            }
            $data = [
                'total_count' => $totalCount,
                'total_missed_count' => $totalMissedCount,
                'total_updated_count' => $totalUpdatedCount,
                'missed_details' => $missedDetails,
            ];
            $this->_importRepo->changeState(ImportConstants::STATE_COMPLETE, $this->history_id);
            $this->statusCode = '200';
            $this->reportData = $data;
            $this->errorMessage = null;
        } catch (\Exception $e) {
            $this->status = 'error';
            $this->statusCode = '422';
            $this->reportData = [];
            $this->errorMessage = $e->getMessage();
            Log::channel('imports')->error($e->getMessage());
            $this->_importRepo->changeState(ImportConstants::STATE_ERROR, $this->history_id);
        }


        // $this->data = $data;
        // $this->pushService->notifyAdmins("File Imported", "Your import has completed! You can check the result from", '', 10, json_encode($data));
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
