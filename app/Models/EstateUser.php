<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstateUser extends Model
{
    use HasFactory;

    protected $table = 'estate_user';

    protected $fillable = [
        'user_id',
        'real_estate_id',
        'is_favourite',
    ];

}
