<?php 

namespace App\Models\Products\Sort;

class ZaSorter extends AbstractSorter
{
	
	public function sort($builder, $key)
	{
		if(!in_array($key, self::SORTS))
			throw new \Exception("Invalid sort key", 1);
			
		if(strtolower($key) == "z-a") {
			if(request()->header("lang") == 2){
				return $builder->orderBy("name_ar", "DESC");
			}else{
				return $builder->orderBy("name", "DESC");
			}
		}

		return $this->nextSorter->sort($builder, $key); 
	}
}
