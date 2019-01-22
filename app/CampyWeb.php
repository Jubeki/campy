<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampyWeb extends Model
{
    protected $fillable = [
        'route',
        'request',
    ];

    protected $casts = [
        'request' => 'array',
    ];
}
