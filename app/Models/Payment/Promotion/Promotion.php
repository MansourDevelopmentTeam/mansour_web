<?php

namespace App\Models\Payment\Promotion;

use Carbon\Carbon;
use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Promotion extends Model
{
    use SoftDeletes;

    const TYPES = [
        'discount' => 1,
        'gift' => 2,
        'both' => 3,
        'direct_discount' => 4,
    ];

    const B2C_CATEGORY = 1;
    const B2B_CATEGORY = 2;

    protected $fillable = [
        "name",
        "name_ar",
        "start_date",
        "expiration_date",
        "active",
        "discount",
        "discount_qty",
        "different_brands",
        "different_categories",
        "different_products",
        "override_discount",
        "priority",
        "times",
        "type",
        "gift_ar",
        "gift_en",
        "check_all_conditions",
        "category", // B2C => 1, B2B => 2,
        "boost", // el 7afez
        "exclusive",
        "periodic",
        "group_id",
        'instant',
        'incentive_id',
        'description',
        'description_ar'
    ];

    public function getGift($lang = 1)
    {
        if ($lang == 2) {
            return $this->gift_ar ?: $this->gift_en;
        }

        return $this->gift_en;
    }

    public function scopePrioritize($query)
    {
        return $query->active()->orderBy('priority', 'DESC')
            ->latest()
            ->get();
    }

    public function scopeActive($query)
    {
        return $query->where("active", 1)
            //->whereDate("start_date", "<=", Carbon::today())
            ->whereDate("expiration_date", ">=", Carbon::today()->subDay(1));
    }

    public function getName($lang = 1)
    {
        if ($lang == 2) {
            return $this->name_ar ?? $this->name;
        }
        return $this->name;
    }

    public function isPeriodic(): bool
    {
        if (Auth::user() !== null && $this->getOriginal('periodic')){
            $use = $this->promotionUses()->where('user_id', Auth::user()->id)->latest()->first();

            if (isset($use)){
               return now() <= $use->valid_date;
            };
        }

        return false;
    }

    public function promotionUses()
    {
        return $this->hasMany(PromotionUser::class, 'promotion_id');
    }

    public function targets()
    {
        return $this->hasMany(PromotionTargets::class)->with('product');
    }

    public function isExclusive(): bool
    {
        return (bool) $this->getOriginal('exclusive');
    }

    public function conditions()
    {
        return $this->hasMany(PromotionConditions::class)->with(['list']);
    }

    public function hasProduct($id)
    {
        $product_ids = $this->list->products->pluck('id')->toArray();

        return Product::whereIn("parent_id", $product_ids)->where("id", $id)->exists();
    }

    public function hasTargetProduct($id)
    {
        $product_ids = $this->targetList->products->pluck('id')->toArray();

        return Product::whereIn("parent_id", $product_ids)->where("id", $id)->exists();
    }

    /**
     * Scope a query active now.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActiveNow($query)
    {
        return $query->where("active", 1)->whereDate('expiration_date', '>=', now());
    }

    public function segments(): HasMany
    {
        return $this->hasMany(PromotionB2B_Segments::class, 'promotion_id');
    }

}
