<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class OrderSchedule extends Model
{
    
    protected $table = "order_schedule";
    protected $fillable = ["interval", "time", "week_day", "month_day"];
    protected $appends = ["next_order"];

    const DAILY = 1;
    const WEEKLY = 2;
    const MONTHLY = 3;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function days()
    {
    	return $this->hasMany(ScheduleDay::class, "schedule_id");
    }

    public function getNextOrderAttribute()
    {
        if ($this->interval == self::DAILY) {
            return date("h:i a", strtotime($this->time));
        } elseif ($this->interval == self::WEEKLY) {
            $day_of_week = date('N');
            
            $schedule_days = $this->days->toArray();

            $filtered_days = array_filter($schedule_days, function ($item) use ($day_of_week) {
                return $item["day"] >= $day_of_week;
            });

            $filtered_days = array_values($filtered_days);

            $next_day = count($filtered_days) ? $filtered_days[0] : $schedule_days[0];

            return date('D', strtotime("Sunday +{$next_day['day']} days")) . " " . date("h:i a", strtotime($this->time));
        } elseif ($this->interval == self::MONTHLY) {
            $day_of_month = date("d");

            $schedule_days = $this->days->toArray();
            
            $filtered_days = array_filter($schedule_days, function ($item) use ($day_of_month) {
                return $item["day"] >= $day_of_month;
            });

            $filtered_days = array_values($filtered_days);

            $next_day = count($filtered_days) ? $filtered_days[0] : $schedule_days[0];

            return $next_day["day"] . " " . date("h:i a", strtotime($this->time));
        }
    }

    private function getNumberWithOrdinal($n)
    {
        $s=["th","st","nd","rd"];
        $v=$n%100;
        return $n+($s[($v-20)%10]||$s[$v]||$s[0]);
    }
}
