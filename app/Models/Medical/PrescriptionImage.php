<?php

namespace App\Models\Medical;

use Illuminate\Database\Eloquent\Model;

class PrescriptionImage extends Model
{
    public $timestamps = false;
    protected $fillable = ['prescription_id', 'url'];
}
