<?php

namespace App\Models\Medical;

use Illuminate\Database\Eloquent\Model;

class PrescriptionCancellationReason extends Model
{
    protected $fillable = ["text", "text_ar", "user_type"];
}
