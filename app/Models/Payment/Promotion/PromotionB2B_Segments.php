<?php

namespace App\Models\Payment\Promotion;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionB2B_Segments extends Model
{
    use HasFactory;

    protected $table = 'promotions_b2b_segments';

    protected $fillable = [
        'min',
        'max',
        'discount_type', // fixed / per-item
        'discount',
        'iterator', // in case discount type = per-x-item
        'promotion_id',
        'override_range'
    ];

    const DISCOUNT_TYPES = [
       'Fixed' => 2,
       'ValuePerItem' => 1
    ];

    protected $hidden = [
        "promotion_id",
        "created_at",
        "updated_at",
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

}
