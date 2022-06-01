<?php 

namespace App\Models\Products\Sort;

class OffersSorter extends AbstractSorter
{
	
	public function sort($builder, $key)
	{
		if(!in_array($key, self::SORTS))
			throw new \Exception("Invalid sort key", 1);
			
		if(strtolower($key) == "offers") {
			return $builder->where("discount_price", ">", 0)->orderBy("discount_price", "DESC");
		} elseif (strtolower($key) == "offers_only") {
			return $builder->whereNotNull("discount_price");
		}



		return $this->nextSorter->sort($builder, $key); 
	}
}
