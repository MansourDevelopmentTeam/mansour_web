<?php

namespace App\Models\Users;

use App\Models\ACL\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Deliverer extends User
{
    

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('role', function (Builder $builder) {
    //         $builder->whereHas('roles', function ($q)
    //         {
    //         	$q->where("id", Role::DELIVERER);
    //         });
    //     });
    // }

    public function calculateRate()
    {
    	$avg = $this->deliveries()->whereNotNull("rate")->get()->avg("rate");

    	$this->rating = $avg;
    	$this->save();

    	return $this->rating;
    }
}
