<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    //
    protected $table = 'forecast';

    protected $fillable = [
        'country',
        'city',
        'weather_data',
    ];
}
