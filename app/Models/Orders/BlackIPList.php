<?php 

namespace App\Models\Orders;


use Illuminate\Database\Eloquent\Model;

class BlackIPList extends Model
{
    protected $table = 'black_ip_list';

    protected $fillable = ['ip'];
}