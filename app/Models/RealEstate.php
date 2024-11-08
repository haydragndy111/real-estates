<?php

namespace App\Models;

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
        'title',
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
    ];

    public function getEstateTypeAttribute()
    {
        return RealEstateConstants::getTypes()[$this->type];
    }

    public function getPriceTypeAttribute()
    {
        return 'aed';
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
