<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeatherForecast extends Model
{
    use HasFactory;

    protected $fillable = [
        'lat',
        'lon',
        'timezone',
        'timezone_offset',
        'current',
        'dt',
        'sunrise',
        'sunset',
        'temp',
        'feels_like',
        'wind_speed',
        'wind_gust',
        'wind_deg',
        'dew_point',
        'uvi',
        'clouds',
        'visibility',
        'humidity',
        'weather_main',
        'weather_desc'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function current(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
}
