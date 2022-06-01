<?php

namespace App\Http\Resources\Customer;

use App\Models\Products\Option;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsOption extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $enLang = $request->header('lang') != 1 ? false : true;
        if(is_array($this['values'])) {
            $values = collect($this['values'])->toArray();
            $keys = collect($this['values'])->pluck('name_en')->toArray();
        } else {
            $values = $this['values']->toArray();
            $keys = array_column($values, 'name_en');
        }
        array_multisort($keys, SORT_NATURAL | SORT_FLAG_CASE, $values);

        return [
             "id" => $this['id'],
             "name" => $this['name_en'],
             "name_ar" => $this['name_ar'],
             "type" => $this['type'],
             "values" => collect($values)->values()->map(function ($value) use ($enLang){
                 return [
                     'id' => $value['id'],
                     'name' => $value['name_en'],
                     'name_ar' => $value['name_ar'],
                     'color_code' => $value['color_code']
                 ];
             })
        ];
    }
}
