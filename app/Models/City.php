<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'label',
    ];

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function realEstates()
    {
        return $this->hasManyThrough(RealEstate::class, District::class);
    }
}
