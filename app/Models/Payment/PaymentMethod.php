<?php
namespace App\Models\Payment;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PaymentMethod extends Model
{
    /**
     * Payment Methods
     */
    const METHOD_CASH = 1;
	const METHOD_VISA = 2;
	const METHOD_VALU = 3;
	const METHOD_FAWRY = 4;
	const METHOD_PREMIUM = 5;
    const METHOD_VISA_INSTALLMENT = 6;
	const METHOD_QNB = 7;
	const METHOD_MEZA = 8;
	const METHOD_SOUHOOLA = 9;
	const METHOD_GET_GO = 10;
	const METHOD_SHAHRY = 11;
	const METHOD_VODAFONE_CASH = 12;
	const METHOD_QNB_INSTALLMENT = 13;
	const METHOD_NBE_INSTALLMENT = 13;
	const METHOD_NBE = 14;
	const METHOD_QNB_SIMPLIFY = 16;

    /**
     * Payment providers
     */
    const PROVIDER_COD = 'cod';
    const PROVIDER_WEACCEPT = 'weaccept';
    const PROVIDER_BANK = 'bank';
    const PROVIDER_PAYTABS = 'paytabs';

    /**
     * Payment types
     */
    const TYPE_CARD = 0;
    const TYPE_CASH = 1;
    const TYPE_INSTALLMENT = 2;

    /**
     * Type labels
     */
    const TYPE_LABEL = [
        self::TYPE_CARD => 'Card',
        self::TYPE_CASH => 'Cash',
        self::TYPE_INSTALLMENT => 'Installment'
    ];


    protected $hidden = ['updated_at', 'created_at'];
    protected $fillable = ['name', 'name_ar', 'is_online', 'icon', 'active', 'deactivation_notes', 'order', 'type', 'provider', 'is_installment'];

    public function getName($lang = 1)
    {
        if ($lang == 2) {
            return $this->name_ar ?: $this->name;
        }

        return $this->name;
    }

    public function closed()
    {
        return $this->belongsToMany(User::class, 'closed_payment_methods');
    }

    public function scopeNotClosedMethods($query)
    {
        return $query->whereDoesntHave('closed', function ($qu) {
            return $qu->where('user_id', Auth::id());
        })->where('active', 1);
    }

    public function getIconAttribute($value)
    {
        return url($value);
    }

    public static function isMethodOnline($method_id)
    {
        $methods = config('payment.stores');
        return $methods[$method_id]['isOnline'];
    }

    /**
     * Get all of the plans for the PaymentMethod
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plans()
    {
        return $this->hasMany(PaymentInstallment::class);
    }

    /**
     * Get all of the credentials for the PaymentMethod
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function credentials()
    {
        return $this->hasMany(PaymentCredential::class, "method_id");
    }

    public function setProviderAttribute($value)
    {
        if($value == self::PROVIDER_COD) {
            $this->attributes['is_online'] = false;
        }else {
            $this->attributes['is_online'] = true;
        }
        $this->attributes['provider'] = $value;
    }
}
