<?php 

namespace App\Models\Products\Sort;

/**
* 
*/
class SorterBuilder
{
	
	public static function build()
	{
		$azSorter = new AzSorter;
		$zaSorter = new ZaSorter;
//		$highSorter = new HighSorter;
//		$lowSorter = new LowSorter;
        $priceSorter = new PriceSorter;
		$popularSorter = new PopularSorter;
		$recentSorter = new RecentSorter;
		$offersSorter = new OffersSorter;

        $azSorter->setNextSorter($zaSorter);
        $zaSorter->setNextSorter($priceSorter);
//        $highSorter->setNextSorter($lowSorter);
//        $lowSorter->setNextSorter($popularSorter);
        $priceSorter->setNextSorter($popularSorter);
        $popularSorter->setNextSorter($recentSorter);
        $recentSorter->setNextSorter($offersSorter);

		return $azSorter;
	}
}
