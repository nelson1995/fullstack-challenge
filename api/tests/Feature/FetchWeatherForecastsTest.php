<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\Console\Exception\RuntimeException;

class FetchWeatherForecastsTest extends TestCase
{
    public function test_users_table_is_not_seeded()
    {   
        $this->assertDatabaseMissing('users',[]);
    }

     
    public function test_get_weather_forecast_details_for_all_users()
    {
        $response = $this->get('/api/weather-forecast/')
                        ->assertStatus(200);
    }
    
    public function test_get_weather_forecast_details_by_user_success()
    {
        $userId = User::all()->random()->id;
        $response = $this->get('/api/weather-forecast/details/'.$userId)
                        ->assertStatus(200);
    }
}
