<?php

namespace App\Models\Import;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class ImportHistory extends Model
{

    protected $fillable = [
        'action', 'state', 'progress', 'type', 'finish_date', 'file_path', 'user_id', 'report'
    ];
    protected $casts = ['report' => 'json'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
