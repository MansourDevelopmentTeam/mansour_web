<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Model;


class Page extends Model
{
    static public $undeletablePages = [];

    protected $fillable = [
        'slug',
        'title_en',
        'title_ar',
        'content_en',
        'content_ar',
        'order',
        'active',
        'in_footer',
    ];

    protected $casts = [
        'active'    => 'boolean',
        'in_footer' => 'boolean',
    ];

    public function scopeActive($query)
    {
        $query->where('active', 1);
    }

    public function scopeInFooter($query)
    {
        $query->where('in_footer', 1);
    }

    public function getDeletableAttribute()
    {
        return !in_array($this->id, self::$undeletablePages);
    }
}
