<?php

namespace App\Models\Products\Sort;

class HighSorter extends AbstractSorter
{

	public function sort($builder, $key)
	{
		if(!in_array($key, self::SORTS))
			throw new \Exception("Invalid sort key", 1);

		if(strtolower($key) == "high") {
            return   $builder->join('products as productVariants', 'productVariants.parent_id', '=', 'products.id')->orderBy('productVariants.price', 'DESC');
//                        return  $builder->join('products','products.parent_id','=','products.id')->orderBy('products.price','DESC');

//            return   $builder->whereHas('productVariants', function ($q){
//                $q->orderBy("price", "ASC");
//            });
		}

		return $this->nextSorter->sort($builder, $key);
	}
}
