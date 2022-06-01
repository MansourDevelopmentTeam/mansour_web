<?php 

namespace App\Models\Products\Sort;

abstract class AbstractSorter
{

	const SORTS = ["a-z", "z-a", "high", "low", "offers", "offers_only", "popular", "recent"];
	
	protected $nextSorter;

	public function setNextSorter($sorter)
	{
		$this->nextSorter = $sorter;
	}

	abstract function sort($builder, $key);
}