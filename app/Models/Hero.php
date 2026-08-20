<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    //
    protected $table = 'heros';

    protected $fillable = [
        'ar',
        'en',
        'ref',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
