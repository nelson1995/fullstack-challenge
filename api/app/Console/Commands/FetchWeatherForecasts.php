<?php

namespace App\Console\Commands;

use App\Models\User;
use GuzzleHttp\Client;
use App\Models\WeatherForecast;
use Illuminate\Console\Command;

class FetchWeatherForecasts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:weatherforecast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch hourly updates of weather forecasts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = 'https://api.openweathermap.org/data/3.0/';
        
        $users = User::query()->get();
        
        if(count($users) < 1){
            $this->info('User table not seeded with data');
            return 1;
        }
        $this->info(config('services.openweather.key'));

        foreach($users as $user){
            $requestParams = [
                'query' => [
                    'lat' => $user->latitude,
                    'lon' => $user->longitude,
                    'appid' => config('services.openweather.key'),
                    'exclusive' => 'minute,hourly,alerts,daily'
                ]
            ];

            $client = new Client(['base_uri'=> $url]);
            $response = $client->request('GET','onecall',$requestParams);
            $statusCode = $response->getStatusCode();
            if($statusCode === 404){
                $this->error('Failed!');
                return 1;
            }

            $body = json_decode($response->getBody()->getContents(),TRUE);
            $weatherForecast = WeatherForecast::query()->create([
                'user_id'=> $user->id,
                'lat' => $body['lat'],
                'lon' => $body['lon'],
                'timezone' => $body['timezone'],
                'timezone_offset' => $body['timezone_offset'],
                'dt' => $body['current']['dt'],
                'sunrise' => $body['current']['sunrise'],
                'sunset' => $body['current']['sunset'],
                'temp' => $body['current']['temp'],
                'feels_like' => $body['current']['feels_like'],
                'wind_speed' => $body['current']['wind_speed'],
                'wind_gust' => $body['current']['wind_gust'],
                'wind_deg' => $body['current']['wind_deg'],
                'dew_point' => $body['current']['dew_point'],
                'uvi' => $body['current']['uvi'],
                'clouds' => $body['current']['clouds'],
                'visibility' => $body['current']['visibility'],
                'humidity' => $body['current']['humidity'],
                'weather_main' => $body['current']['weather'][0]['main'],
                'weather_desc' => $body['current']['weather'][0]['description']
            ]);        
        }

        $this->info('Successful');
        return 0;
    }
}
