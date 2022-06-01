<?php

namespace App\Models\Export;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    protected $fillable = [
        'action', 'state', 'progress', 'type', 'finish_date','user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
