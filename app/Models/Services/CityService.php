<?php

namespace App\Models\Services;

use App\Models\Locations\City;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CityService
{

    public $city;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function getOne($id)
    {
        return $this->getDataObj($this->city->findOrFail($id));
    }

    public function getAllWithPaginate()
    {
        $data = $this->brand->paginate(\Config::get('app.pagination'));
        return ['list' => $data->map(function ($item) {
            return $this->getDataObj($item);
        }), 'pagination' => \Helper::generatePagination($data)];
    }

    public function getDataObj($item)
    {
        $dataObj = new \stdClass();
        $dataObj->name = $item->name;
        $dataObj->name_ar = $item->name_ar;
        $dataObj->image = $item->image;
        $dataObj->status = $item->status;
        $dataObj->created_at = (string) $item->created_at;
        $dataObj->updated_at = (string) $item->updated_at;

        return $dataObj;
    }

    public function validateFields(): \Illuminate\Contracts\Validation\Validator
    {
        $inputs = Input::all();

        $fields = [
            "name" => "required",
            "name_ar" => "required",
            "image" => "required",
            "status" => 'sometimes|nullable'
        ];

        $messages = [
            'name.required' => "Sorry Name Required!",
            'name_ar.required' => "Sorry Name Ar Required!",
            'image.required' => "Sorry Image Required!",
            'status.required' => "Sorry Status Required!",
        ];

        return Validator::make($inputs, $fields, $messages);
    }
}
