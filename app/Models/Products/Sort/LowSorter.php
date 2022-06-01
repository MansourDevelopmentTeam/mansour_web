<?php

namespace App\Models\Products\Sort;

class LowSorter extends AbstractSorter
{

	public function sort($builder, $key)
	{
		if(!in_array($key, self::SORTS))
			throw new \Exception("Invalid sort key", 1);

		if(strtolower($key) == "low") {
            return   $builder->whereHas('productVariants', function ($q){
                      $q->orderBy("price", "ASC");
            });
		}

		return $this->nextSorter->sort($builder, $key);
	}
}
