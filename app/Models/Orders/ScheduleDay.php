<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class ScheduleDay extends Model
{
    
    protected $fillable = ["day"];
    protected $appends = ["day_name"];

    public function getDayNameAttribute()
    {
        switch ($this->day) {
            case 0:
                return "Sunday";
                break;
            case 1:
                return "Monday";
                break;
            case 2:
                return "Tuesday";
                break;
            case 3:
                return "Wednesday";
                break;
            case 4:
                return "Thursday";
                break;
            case 5:
                return "Friday";
                break;
            case 6:
                return "Saturday";
                break;
            
            default:
                
                break;
        }
    }
}
