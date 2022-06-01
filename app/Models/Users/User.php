<?php

namespace App\Models\Users;

use App\Models\ACL\Role;
use App\Models\Export\Export;
use App\Models\Import\ImportHistory;
use App\Models\Orders\Cart;
use App\Models\Orders\Order;
use App\Models\Payment\Promo;
use App\Models\Users\Affiliates\AffiliateLinks;
use App\Models\Users\Affiliates\WalletHistory;
use App\Models\Products\Product;
use App\Models\Loyality\UserPoint;
use App\Models\Loyality\UserRedeem;
use Illuminate\Support\Facades\URL;
use App\Models\Medical\Prescription;
use App\Models\Payment\PaymentMethod;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Models\Notifications\Notification;
use App\Models\Payment\ClosedPaymentMethod;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Products\TotalSpentPerCategory;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    const TYPE_CUSTOMER=1;
    const TYPE_ADMIN=2;
    const TYPE_DELIVERER=3;
    const TYPE_AFFILIATE=4;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', "last_name", 'email', 'password', "phone", "birthdate", "image", 'refered', 'first_order', "type", "admin_first_order", "phone_verified","active", "verification_code","link_id", "erp_id", "code"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', "verification_code", "verified"
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function walletHistory()
    {
        return $this->hasMany(WalletHistory::class,"affiliate_id","id");
    }
    public function link()
    {
        return $this->belongsTo(AffiliateLinks::class, "link_id");
    }
    public function affiliateLinks()
    {
        return $this->hasMany(AffiliateLinks::class,"affiliate_id","id");
    }
    public function affiliateOrders()
    {
        return $this->hasMany(Order::class, "affiliate_id");
    }
    protected static function boot()
    {
        parent::boot();
    }

    public function favourites()
    {
        return $this->belongsToMany(Product::class, "user_favourites", "user_id", "product_id");
    }

    public function comparisons()
    {
        return $this->belongsToMany(Product::class, "compare_products", "user_id", "product_id");
    }

    public function delivererProfile()
    {
        return $this->hasOne(DelivererProfile::class, "user_id", "id");
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function primaryAddress()
    {
        return $this->hasOne(Address::class)->where('primary', 1);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, "user_id");
    }

    public function deliveries()
    {
        return $this->hasMany(Order::class, "deliverer_id");
    }

    public function getRole()
    {
        return $this->roles->first();
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function getRoles()
    {
        return $this->roles->pluck('id')->toArray();
    }

    public function getNumberOfRates()
    {
        return $this->deliveries()->whereNotNull("customer_rate")->get()->count();
    }

    public function tokens()
    {
        return $this->hasMany(DeviceToken::class, "user_id");
    }

    public function userPromos()
    {
        return $this->belongsToMany(Promo::class, "user_promo", "user_id", "promo_id");
    }

    public function targetPromos()
    {
        return $this->belongsToMany(Promo::class, "promo_targets", "user_id", "promo_id");
    }

    public function points()
    {
        return $this->hasMany(UserPoint::class);
    }

    public function redeems()
    {
        return $this->hasMany(UserRedeem::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function stock_notifications()
    {
        return $this->belongsToMany(Product::class, "stock_notifications", "user_id", "product_id");
    }

    public function settings()
    {
        return $this->hasOne(UserSetting::class);
    }

    public function getCurrentPoints()
    {
        return (int)$this->points()->where('expiration_date', ">=", now())->where("activation_date", "<=", now())->sum('remaining_points');
    }

    public function getLang()
    {
        return $this->settings ? $this->settings->language : "en";
    }

    public function isGold()
    {
        return $this->spent >= config('constants.egp_gold');
    }

    public function closedPaymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class, 'closed_payment_methods', 'user_id', 'payment_method_id');
    }

    public function pointsToGold()
    {
        if (config('constants.egp_gold') <= $this->spent) {
            return 0;
        }

        return config('constants.egp_gold') - $this->spent;
    }

    public function pointsToExpire()
    {
        if (now() < now()->setDate(date("Y"), 6, 30)) {
            $next_expiry_date = now()->setDate(date("Y"), 12, 31);
        } else {
            $next_expiry_date = now()->setDate(date("Y"), 6, 30)->addYear();
        }

        return (int)$this->points()->where('expiration_date', "<=", $next_expiry_date)->where("activation_date", "<=", now())->sum('remaining_points');
    }

    public function changeStatus($status)
    {
        $this->last_active = date("Y-m-d H:i");
        $this->save();
        $profile = $this->delivererProfile;
        $profile->status = $status;
        return $profile->save();
    }

    public function isCovered()
    {
        $addresses = $this->addresses;

        $areas = $addresses->map(function ($item)
        {
            return $item->area;
        });
        $uncovered_areas = $areas->filter(function ($item)
        {
            return $item->active == 0;
        });

        return !(bool)$uncovered_areas->count();
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

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->last_name}";
    }

    public function generateReferal()
    {
        $first_name = explode(" ", $this->name)[0];

        $rand = str_random(4);

        return strtoupper($first_name . "-" . $rand);
    }

    /**
     * Set the user's phone verified.
     *
     * @param  string  $value
     * @return void
     */
   public function setPhoneVerifiedAttribute($value)
   {
       if(config('integrations.sms.default') == ""){
           $value = 1;
       }
       $this->attributes['phone_verified'] = $value;
   }

    public function ImportHistories(){
        return $this->hasMany(ImportHistory::class);
    }

    public function ExportHistories(){
        return $this->hasMany(Export::class);
    }

    public function getTypeNameAttribute()
    {
          switch ($this->type) {
            case 1: return 'customer';
            case 2: return 'admin';
            case 3: return 'branch';
            case 4: return 'affiliate';
          }
    }

    public function totalSpentPerCategory()
    {
        return $this->hasMany(TotalSpentPerCategory::class);
    }

    public function wallet()
    {
        return $this->hasMany(Wallet::class, 'user_id', 'id')->where('delivered', '=', true);
    }
}
