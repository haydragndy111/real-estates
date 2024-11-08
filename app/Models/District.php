<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'name',
        'label',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function realEstates()
    {
        return $this->hasMany(RealEstate::class);
    }
}