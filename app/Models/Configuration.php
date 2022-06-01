<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @method static self scope(string $scope): self
 * @method static self key(string $key): self
 * @method static self editable(): self
 */
class Configuration extends Model
{
    protected $fillable = ['value'];

    /**
     * Get Default Lang Value String Coreesponding To Key
     *
     * @param $key
     * @param null $lang
     * @return string
     */
    public static function getValueByKey($key)
    {
        return
            DB::table('configurations')
                ->where('key', $key)
                ->orWhere('alias', $key)
                ->first()->value;
    }

    public static function setValueByKey($key, $value): bool
    {
        return
            DB::table('configurations')
                ->where('key', $key)
                ->update(['value' => $value]);
    }

    /**
     *  Apply Model Global Scope To Always Sort Record
     */
    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
        });
    }

    /**
     * Scope a query to only include settings of given scope
     *
     * @param $query
     * @param $scope
     * @return mixed
     */
    public function scopeScope($query, $scope)
    {
        return $query->where(function (Builder $query) use ($scope) {
            $query->where('scope', $scope)->orWhere('scope', 'global');
        });
    }

    /**
     * Scope a query to get only records of a given key
     *
     * @param $query
     * @param $key
     * @return mixed
     */
    public function scopeKey($query, $key)
    {
        return $query->where('key', $key)->orWhere('alias', $key);
    }

    /**
     * Scope a query to only include editable configs.
     *
     * @param $query
     * @return mixed
     */
    public function scopeEditable($query)
    {
        return $query->where('editable', 1);
    }

    /**
     * Encode Options Field To Return An Array Instead Of Json Decoded String
     *
     * @return mixed
     */
    public function getOptionsAttribute()
    {
        return json_decode($this->attributes['options'], true);
    }

    /**
     * Cast some values
     *
     * @return mixed
     */
    public function getValueAttribute()
    {
      if($this->type == 'switch') {
        return (boolean) $this->attributes['value'];
      } elseif ($this->type == 'float') {
        return floatval($this->attributes['value']);
      }
      return $this->attributes['value'];
    }
}
