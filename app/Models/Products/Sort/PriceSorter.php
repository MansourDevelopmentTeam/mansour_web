<?php

namespace App\Models\Products\Sort;

class PriceSorter extends AbstractSorter
{
    public function sort($builder, $key)
    {
        if (!in_array($key, self::SORTS))
            throw new \Exception("Invalid sort key", 1);

        if (strtolower($key) == "high" || strtolower($key) == "low") {
            $sortDirection = strtolower($key) == "high" ? 'DESC' : 'ASC';
            // return $builder->whereHas('productVariants', function ($q) use ($sortDirection){
            //     $q->orderBy("price", $sortDirection);
            // });
            
            return $builder->orderBy('in_stock', 'DESC')->orderByRaw("IFNULL(discount_price, price) {$sortDirection}");
            // return $builder->orderBy("price", $sortDirection);
            // return $builder->join('products', 'products.parent_id', '=', 'products.id')->orderBy('productVariants.price', $sortDirection)->select("products.*");
        }
        return $this->nextSorter->sort($builder, $key);
    }
}
