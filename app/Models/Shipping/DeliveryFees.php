<?php

namespace App\Models\Shipping;

use App\Models\Locations\Area;
use App\Models\Locations\City;
use App\Models\Locations\District;
use App\Models\Products\Vendors;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class DeliveryFees extends Model
{
    protected $table = 'delivery_fees';
    protected $fillable = ['source', 'source_id', 'type', 'fees', 'weight_from', 'weight_to', 'created_at', 'updated_at'];

    public static function setFees($source, $id, $fees, $request)
    {
        if (!in_array($source, ['city', 'area', 'district'])) {
            return false;
        }

        $updateFees['fees'] = (int) $fees;
        $updateFees['weight_from'] = 0;
        $updateFees['weight_to'] = 0;

        self::where(['source' => $source, 'source_id' => $id])->delete();

        if ($request->fees_type == 2 && isset($request->fees_range) && count($request->fees_range) > 0) {
            foreach($request->fees_range as $key => $range) {
                $createFees[$key]['source'] = $source;
                $createFees[$key]['source_id'] = $id;
                $createFees[$key]['weight_from'] = $range['weight_from'];
                $createFees[$key]['weight_to'] = $range['weight_to'];

                $updateFees[$key]['fees'] = $range['fees'];
                self::updateOrCreate($createFees[$key], $updateFees[$key]);
            }
        }

        return true;
    }

    public static function getFees($source, $id, $weight)
    {
        if (!in_array($source, ['city', 'area', 'district'])) {
            return false;
        }

        $weight = (int) $weight;

        $feesRange = self::where(['source' => $source, 'source_id' => $id])
            ->get();

        foreach($feesRange as $value) {
            if($weight >= $value->weight_from && $weight <= $value->weight_to) {
                return $value->fees;
            }
        }
          
        return count($feesRange) > 0 ? 0 : self::getFeesType1($source, $id);
    }

    public static function getFeesType1($source, $id)
    {
        switch ($source) {
            case "city":
                $dataObj = City::find($id);
                return $dataObj ? ($dataObj->delivery_fees_type == 1 ? (int) $dataObj->delivery_fees : 0) : false;
            case "area":
                $dataObj = Area::find($id);
                return $dataObj ? ($dataObj->delivery_fees_type == 1 ? (int) $dataObj->delivery_fees : 0) : false;
            case "district":
                $dataObj = District::find($id);
                return $dataObj ? ($dataObj->delivery_fees_type == 1 ? (int) $dataObj->delivery_fees : 0) : false;
            default:
                return false;
        }
    }
    
    public static function setFeesType1($source, $id, $sourceObj, $fees)
    {
        self::where(['source' => $source, 'source_id' => $id])->delete();
        $sourceObj->delivery_fees = $fees;
        $sourceObj->save();

        return true;
    }

    public static function getFeesData($source, $id)
    {
        if (!in_array($source, ['city', 'area', 'district'])) {
            return false;
        }
   
        $feesList = self::where(['source' => $source, 'source_id' => $id])
            ->get();

        $list = [];
        foreach($feesList as $key => $value) {
            $list[$key] = new stdClass();
            $list[$key]->fees = $value->fees;
            $list[$key]->weight_from = $value->weight_from;
            $list[$key]->weight_to = $value->weight_to;
        }

        return $list;
    }
}