<?php 

namespace App\Models\Products\Sort;

class AzSorter extends AbstractSorter
{
	
	public function sort($builder, $key)
	{
		if(!in_array(strtolower($key), self::SORTS))
			throw new \Exception("Invalid sort key", 1);
			
		if(strtolower($key) == "a-z") {
			if(request()->header("lang") == 2){
				return $builder->orderBy("name_ar", "ASC");
			}else{
				return $builder->orderBy("name", "ASC");
			}
		}

		return $this->nextSorter->sort($builder, $key); 
	}
}
