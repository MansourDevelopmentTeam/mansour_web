<?php 

namespace App\Models\Products\Sort;

class PopularSorter extends AbstractSorter
{
	
	public function sort($builder, $key)
	{
		if(!in_array($key, self::SORTS))
			throw new \Exception("Invalid sort key", 1);
			
		if(strtolower($key) == "popular") {
			return $builder->orderBy("orders_count", "DESC");
		}

        return $this->nextSorter->sort($builder, $key);
	}
}
