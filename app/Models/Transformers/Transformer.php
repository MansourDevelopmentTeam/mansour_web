<?php 

namespace App\Models\Transformers;

/**
* 
*/
abstract class Transformer
{
	
	public function transformCollection($items)
	{
		if(is_array($items)){
			return array_map( [$this , 'transform'] , $items);
		}

		return array_map( [$this , 'transform'] , $items->all());
	}

	public abstract function transform($item);
}