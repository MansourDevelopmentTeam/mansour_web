<?php 

namespace App\Models\Products\Sort;

class RecentSorter extends AbstractSorter
{
	
	public function sort($builder, $key)
	{
		if(!in_array($key, self::SORTS))
			throw new \Exception("Invalid sort key", 1);
			
		if(strtolower($key) == "recent") {
			return $builder->orderBy("created_at", "DESC");
		}

		return $this->nextSorter->sort($builder, $key); 
	}
}
