<?php

namespace App\Sheets\Import\Customers;

use App\Models\Locations\Area;
use App\Models\Locations\City;
use App\Models\Locations\District;
use App\Services\ImportFiles\ImportConstants;
use App\Services\ImportFiles\ImportFiles;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;
use App\Models\Users\User;

class CustomersImport extends ImportFiles implements ToCollection, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    private $listID;
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
        Log::channel('imports')->info('Import customers, history id is ' . $this->history_id);
        $data = [];
        $missedDetails = [];
        $errorDetails = [];

        try {
            $index = 0;
            foreach ($rows as $key => $row) {
                $rowNumber = $key + 2;
                if (!$this->checkImportCachedStatus($this->history_id, ImportConstants::STATE_CANCEL)) {
                    $firstName = isset($row['first_name']) ? trim($row['first_name']) : null;
                    $lastName = isset($row['last_name']) ? trim($row['last_name']) : null;
                    $email = isset($row['email']) ? trim($row['email']) : null;
                    $phone = isset($row['phone']) ? trim($row['phone']) : null;
                    if ($phone && $phone[0] != '0') {
                        $phone = '0' . strval($phone);
                    }
                    $birthdate = isset($row['birthdate']) ? trim($row['birthdate']) : null;
                    $image = isset($row['image']) ? trim($row['image']) : null;

                    $city = isset($row['city']) ? trim($row['city']) : null;
                    $area = isset($row['area']) ? trim($row['area']) : null;
                    $district = isset($row['district']) ? trim($row['district']) : null;
                    $addressName = isset($row['address_name']) ? trim($row['address_name']) : null;
                    $street = isset($row['street']) ? trim($row['street']) : null;
                    $apartment = isset($row['apartment']) ? trim($row['apartment']) : null;
                    $landmark = isset($row['landmark']) ? trim($row['landmark']) : null;
                    
                    if (empty($firstName)) {
                        $missedDetails[] = 'Missed first name in row ' . $rowNumber . ' for phone ' . $phone;
                        continue;
                    }
                    if (empty($phone)) {
                        $missedDetails[] = 'Missed phone in row ' . $rowNumber . ' for phone ' . $phone;
                        continue;
                    }
                    if (filter_var($image, FILTER_VALIDATE_URL) === FALSE) {
                        $image = str_replace(' ', '-', $image);
                        $image = url("storage/uploads/" . $image);
                    }
                    try {
                        $user = User::updateOrCreate(
                            [
                                'phone' => $phone,
                                'type' => 1
                            ],
                            [
                                'name' => $firstName,
                                'last_name' => $lastName,
                                'email' => $email,
                                'birthdate' => $birthdate,
                                'image' => $image,
                                'email' => $phone . '@gmail.com',
                                'phone_verified' => 1
                            ]
                        );
                        $index++;
                    } catch (\Exception $exception) {
                        $errorDetails[] = 'Can not update or create row ' . $rowNumber . ' for phone ' . $phone;
                        continue;
                    }
                    $city = City::where('name', $city)->orWhere('name_ar', $city)->first();
                    if (!$city) {
                        $missedDetails[] = 'Missed city in row ' . $rowNumber . ' for phone ' . $phone;
                    }

                    $area = Area::where('name', $area)->orWhere('name_ar', $area)->first();
                    if (!$area) {
                        $missedDetails[] = 'Missed area in row ' . $rowNumber . ' for phone ' . $phone;
                    }
                    
                    $district = District::where('name', $district)->orWhere('name_ar', $district)->first();
                    if (!$district) {
                        $missedDetails[] = 'Missed district in row ' . $rowNumber . ' for phone ' . $phone;
                    }
                    if ($city) {
                        try {
                            $userAddress = $user->addresses()->create(
                                [
                                    'city_id' => $city ? $city->id : null,
                                    'area_id' => $area ? $area->id : null,
                                    'district_id' => $district ? $district->id : null,
                                    'name' => $addressName,
                                    'address' => $street,
                                    'apartment' => $apartment,
                                    'landmark' => $landmark
                                ]
                            );
                        } catch (\Exception $exception) {
                            $errorDetails[] = 'Can not create address in row ' . $rowNumber . ' for phone ' . $phone;
                        }
                    }
                } else {
                    $this->status = 'cancelled';
                    Log::channel('imports')->info('Import Canceled');
                    break;
                }
            }
            $progress = floor(($index / count($rows)) * 100);
            $this->_importRepo->updateHistoryProgress($progress, $this->history_id);
            $this->status = 'success';
            $data = [
                'total_counts' => count($rows),
                'total_imported' => $index,
                'missed_details' => $missedDetails,
                'error_details' => $errorDetails
            ];
            $this->_importRepo->changeState(ImportConstants::STATE_COMPLETE, $this->history_id);
            $this->statusCode = '200';
            $this->reportData = $data;
            $this->errorMessage = null;
            Log::info("IMPORT FINISHED");
            
        } catch (\Exception $exception) {
            $this->status = 'error';
            $this->statusCode = '422';
            $this->reportData = $data;
            $this->errorMessage = $exception->getMessage();
            Log::channel('imports')->error($exception->getMessage());
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
