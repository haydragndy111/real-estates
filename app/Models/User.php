<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Constants\CurrencyConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function getPriceByUser()
    {
        $user = Auth::guard('sanctum')->user();
        if($user){
            $currency = $user->profile->currency;
            if($currency == CurrencyConstants::CURRENCY_AED){
                return 'aed_price';
            }elseif($currency == CurrencyConstants::CURRENCY_USD){
                return 'usd_price';
            }
        }

        return 'aed_price';
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function estates()
    {
        return $this->belongsToMany(RealEstate::class, 'estate_user')
            ->withPivot([
                'user_id',
                'real_estate_id',
                'is_favourite',
            ]);
    }

    // public function favouriteEstates()
    // {
    //     return $this->estates()
    //         ->wherePivot('is_favourite', 1);
    // }

}
