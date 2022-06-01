<?php

namespace App\Models\Payment;

use App\Models\Users\User;
use App\Models\Products\Lists;
use Illuminate\Database\Eloquent\Model;

class UserPromo extends Model
{

    public $timestamps = false;
    protected $table ='user_promo';
    protected $fillable = ["user_id", "promo_id", "use_date", "phone"];

    // public $active;

    public static $validation = [
        "user_id" => "required|exists:users,id",
        "promo_id" => "required|exists:promos,id",
        "use_date" => "required|date",
        "phone" => "nullable|numeric",
    ];

    public function promo()
    {
        return $this->belongsTo(Promo::class, "promo_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
