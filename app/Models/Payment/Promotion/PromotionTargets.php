<?php

namespace App\Models\Payment\Promotion;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;

class PromotionTargets extends Model
{
    const ITEM_TYPES = [
        'lists' => 1,
        'products' => 2,
    ];

    protected $with = [
        'customLists'
    ];
    const OPERATOR = [
        'AND' => 1,
        'OR'  => 0,
    ];
    protected $fillable = [
        'item_id',
        'item_type',
        'quantity',
        'operator',
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

    public function customLists()
    {
        return $this->hasMany(PromotionTargetsCustomList::class, 'target_id')
            ->with('product');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'item_id');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}
