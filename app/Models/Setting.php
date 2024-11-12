<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'header_title',
        'header_text',
        'content',
        'contact_header_title',
        'contact_header_text',
        'toll_free_number',
        'email',
        'whatsapp',
        'location',
    ];

    protected $casts = [
        'content' => 'array',
    ];
}
