<?php

namespace App\Models\Payment\Promotion;

use App\Models\Products\Lists;
use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PromotionConditions extends Model
{
    const ITEM_TYPES = [
        'lists' => 1,
        'products' => 2, // custom list
    ];

    protected $fillable = [
        'item_id',
        'item_type',
        'amount',
        'quantity',
        'operator',
    ];

    const OPERATOR = [
        'AND' => 1,
        'OR'  => 0,
    ];


    protected $with = [
        'customLists'
    ];

    public function isList()
    {
        if ($this->item_type == self::ITEM_TYPES['lists'])
            return true;

        return false;
    }

    public function isProduct()
    {
        if ($this->item_type == self::ITEM_TYPES['products'])
            return true;

        return false;
    }

    public static function hasLists($collection): bool
    {
        return $collection->where('item_type', self::ITEM_TYPES['lists'])->count() >= 1;
    }

    public function list()
    {
        return $this->belongsTo(Lists::class, 'item_id')
            ->joinWhere('promotion_conditions', 'item_type', '=', self::ITEM_TYPES['lists']);
    }

    public function productList()
    {
        return $this->belongsToMany(Product::class, 'promotion_conditions_custom_lists', 'id',
            'item_id');
    }

    public static function hasProducts($collection): bool
    {
        return $collection->where('item_type', self::ITEM_TYPES['products'])->count() >= 1;
    }

    public static function getLists($collection)
    {
        return $collection->where('item_type', self::ITEM_TYPES['lists'])
            ->map(function ($item, $key) {
                return [
                    'id' => $item->item_id,
                    'amount' => $item->amount,
                    'quantity' => $item->quantity
                ];

            });
    }

    public static function getProducts($collection)
    {
        return $collection->where('item_type', self::ITEM_TYPES['products'])
            ->map(function ($item, $key) {
                return [
                    'id' => $item->item_id,
                    'amount' => $item->amount,
                    'quantity' => $item->quantity
                ];

            });
    }

    public function customLists()
    {
        return $this->hasMany(PromotionConditionsCustomList::class, 'condition_id')
            ->with('product');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}
