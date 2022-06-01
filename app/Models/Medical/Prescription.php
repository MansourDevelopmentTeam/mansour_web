<?php

namespace App\Models\Medical;

use App\Models\Orders\OrderCancellationReason;
use App\Models\Users\Address;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Prescription extends Model
{

    public static $validation = [
    	// "name" => "required",
        "address_id" => "required|exists:addresses,id",
    	"images" => "required|array"
    ];

    const CREATED_STATUS = 1;
    const PROCESS_STATUS = 2;
    const DELIVERED_STATUS = 3;
    const CANCELED_STATUS = 4;


    protected $hidden = ["updated_at"];
    protected $attributes = [ 'status' => 1 ];

    protected $fillable = ["name", "note", "image", 'address_id', 'user_id', 'invoice_id', 'amount', 'comment', 'cancellation_id', 'cancellation_text', 'status', 'admin_id', 'assigned_at'];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function getStatusWordAttribute()
    {
        return[
            Prescription::CREATED_STATUS => "Created",
            Prescription::PROCESS_STATUS => "Process",
            Prescription::DELIVERED_STATUS => "Delivered",
            Prescription::CANCELED_STATUS => "Canceled",
        ][$this->status];
    }

    public function address()
    {
        return $this->belongsTo(Address::class, "address_id")->withTrashed();
    }

    public function admin()
    {
        return $this->belongsTo(User::class, "admin_id");
    }

    public function cancellationReason()
    {
        return $this->belongsTo(OrderCancellationReason::class, "cancellation_id");
    }

    public function images()
    {
        return $this->hasMany(PrescriptionImage::class, "prescription_id");
    }

    public function getImageAttribute()
    {
        if(isset($this->attributes["image"])){
            $image = explode("/", $this->attributes["image"]);
            $name = array_pop($image);
            $image = implode("/", $image) . "/" . rawurlencode($name);

            if(preg_match("/https?:\/\//", $this->attributes["image"])) {
                return $image;
            }

            return URL::to('') . "/" . $image;
        }
    }
}
