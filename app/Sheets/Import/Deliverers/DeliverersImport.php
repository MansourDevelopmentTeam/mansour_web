<?php

namespace App\Sheets\Import\Deliverers;

use App\Models\Deliverers\Deliverer;
use App\Models\Locations\Area;
use App\Models\Locations\City;
use App\Models\Locations\District;
use App\Models\Products\Brand;
use App\Models\Users\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;

class DeliverersImport implements ToCollection, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;


    public function collection(Collection $rows)
    {
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $district = District::where("name", "LIKE", "%{$row->district}%")->first();
                if (!$district) {
                    continue;
                }
                $user = User::where("name", $row->branch)->where("type", 3)->first();
                if (!$user) {
                    $user = User::create(["name" => $row->branch, "type" => 3]);
                    $user->active = 1;
                    $user->save();

                    $user->addresses()->create(["address" => $district->name]);

                    // store deliverer profile
                    $deliverer_profile = $user->delivererProfile()->create(["city_id" => $district->area->city_id, "area_id" => $district->area_id]);
                    $deliverer_profile->status = 3;
                    $deliverer_profile->save();

                    $deliverer_profile->districts()->attach($district->id);
                } else {
                    $user->delivererProfile->districts()->attach($district->id);
                }
            }
        }
    }

    public function onError(\Throwable $e)
    {

    }

    public function onFailure(Failure ...$failures)
    {

    }
}
