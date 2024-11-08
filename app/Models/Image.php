<?php

namespace App\Models;

use App\Models\Scopes\ActiveImageScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'real_estate_id',
        'url',
        'sort_order',
        'main_image',
        'status',
    ];


    protected static function booted()
    {
        if (Auth::guard('web_admin')->user() == null) {
            static::addGlobalScope(new ActiveImageScope);
        }
    }

    public function realEstate()
    {
        return $this->belongsTo(RealEstate::class);
    }

    public function scopeMain(Builder $query): void
    {
        $query->where('main_image', true);
    }

}
