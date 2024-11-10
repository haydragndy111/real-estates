<?php

namespace App\Models;

use App\Constants\CurrencyConstants;
use App\Constants\RealEstateConstants;
use App\Models\Scopes\ActiveEstateScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class RealEstate extends Model
{
    use HasFactory;

    protected $fillable = [
        'district_id',
        'title_en',
        // 'title_ar',
        'description',
        'status',
        'aed_price',
        'usd_price',
        'type',
        'size',
        'rooms',
        'handover',
    ];

    protected static function booted()
    {
        if (Auth::guard('web_admin')->user() == null) {
            static::addGlobalScope(new ActiveEstateScope);
        }
    }

    protected $appends = [
        'estateType',
        'priceType',
        'priceByUser',
        'titleByUser',
    ];

    public function getEstateTypeAttribute()
    {
        return RealEstateConstants::getTypes()[$this->type];
    }
    
    public function getPriceByUserAttribute()
    {
        $user = Auth::guard('sanctum')->user();
        if($user){
            $currency = $user->profile->currency;
            if($currency == CurrencyConstants::CURRENCY_AED){
                return $this->aed_price;                
            }elseif($currency == CurrencyConstants::CURRENCY_USD){
                return $this->usd_price;
            }
        }

        return $this->aed_price;
    }
    
    public function getTitleByUserAttribute()
    {
        $user = Auth::guard('sanctum')->user();
        if($user){
            $locale = $user->profile->locale;
            if($locale == 'en'){
                return $this->title_en;                
            }elseif($locale == 'ar'){
                return $this->title_ar;
            }
        }

        return $this->title_en;
    }

    public function getPriceTypeAttribute()
    {
        $user = Auth::guard('sanctum')->user();
        if($user){
            $currency = $user->profile->currency;
            return CurrencyConstants::getCurrenciesTypes()[$currency];
        }

        return CurrencyConstants::getCurrenciesTypes()[CurrencyConstants::CURRENCY_AED];
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

}
