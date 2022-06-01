<?php

namespace App\Models\Users;

use App\Models\ACL\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Customer extends User
{
    
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('role', function (Builder $builder) {
            $builder->whereHas('roles', function ($q)
            {
            	$q->where("id", Role::CUSTOMER);
            });
        });
    }

    public function calculateRate()
    {
    	$avg = $this->deliveries()->whereNotNull("customer_rate")->avg("customer_rate");

    	$this->rating = $avg;
    	$this->save();

    	return $this->rating;
    }
}
