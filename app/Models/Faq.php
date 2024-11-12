<?php

namespace App\Models;

use App\Models\Scopes\ActiveFaqScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'active',
    ];

    protected static function booted()
    {
        if (Auth::guard('web_admin')->user() == null) {
            static::addGlobalScope(new ActiveFaqScope);
        }
    }

}
