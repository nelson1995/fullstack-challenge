<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\WeatherForecast;
use Illuminate\Support\Facades\Cache;

class WeatherForecastController extends Controller
{
    /* 
        Get weather forecasts for all users
     */
    public function getAllUsersWeatherForecasts()
    {
        $startTime = microtime(true);
        $cachedForecasts = Cache::remember('usersWeatherForecasts', 15, function(){
            return User::query()->with('weatherForecast')->all();
        });
        $totalTime = microtime(true) - $startTime;
        
        return response()->json([
            'status' => 200,
            'message' => 'Successful',
            'totalTime'=> $totalTime,
            'forecasts' => $cachedForecasts
        ],200);
    }
    
    /* 
        Get weather forecast details for a particular user
     */
    public function weatherForecastDetails($userId)
    {   
        $startTime = microtime(true);
        $cachedUsersWeatherForecast = Cache::remember('usersWeatherForecast', 15, function(){
            return WeatherForecast::query()->where('user_id',$userId)->first();
        });
        $totalTime = microtime(true) - $startTime;

        return response()->json([
            'status' => 200,
            'message' => 'Successful',
            'totalTime'=> $totalTime,
            'forecastDetails' => $cachedUsersWeatherForecast
        ],200);
    }
}
