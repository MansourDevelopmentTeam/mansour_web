<?php 

namespace App\Models\Services;

use App\Models\Locations\Area;
use App\Models\Locations\City;
use App\Models\Shipping\DeliveryFees;
use App\Models\Users\Address;

class LocationService
{
	public function getAddressDeliveryFees(Address $address)
	{
		if ($address->district && $address->district->delivery_fees != 0) {
			return $address->district->delivery_fees;
		} elseif ($address->area && $address->area->delivery_fees != 0) {
			return $address->area->delivery_fees;
		} else {
			return $address->city->delivery_fees ?? 0;
		}
	}

	public function getAddressDeliveryFeesv2(Address $address, $weight)
	{
		if ($address->district) {
			$fees = DeliveryFees::getFees('district', $address->district->id, $weight);
			if($fees || $fees === 0) {
				return $fees;
			}
		}

		if ($address->area) {
			$fees = DeliveryFees::getFees('area', $address->area->id, $weight);
			if($fees || $fees === 0) {
				return $fees;
			}
		}
		
		if ($address->city) {
			$fees = DeliveryFees::getFees('city', $address->city->id, $weight);
			if($fees || $fees === 0) {
				return $fees;
			}
		}

		return 0;
	}

	public function isLastNode($city_id, $area_id = null, $district_id = null)
	{
		$city = City::with("areas.districts")->findOrFail($city_id);

		if ($city->areas->count() && !$area_id) {
			return false;
		}

		if ($area_id && $district_id) {
			$area = Area::findOrFail($area_id);
			if ($area->districts->count() && !$district_id) {
				return false;
			}
		}

		return true;
	}
}
