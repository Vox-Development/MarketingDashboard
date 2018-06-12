<?php

namespace App\Components\RainForecast;

use App\Events\RainForecast\ForecastFetched;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchRainForecast extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dashboard:rain';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the rain forecast.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lat = '-26.2';
        $lng = '28.04';
        $appKey = '81d8829698200fc85ac580da5b2e16d4';
        //http://gps.buienradar.nl/getrr.php?
        $responseBody = (string) (new Client())
                ->get("http://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lng}&appid={$appKey}")
                ->getBody();

        $forecast = $this->getForecastFromResponseBody($responseBody);
        event(new ForecastFetched($forecast));
    }

    public function getForecastFromResponseBody(string $responseBody) : array
    {
        $forecastItemsAgain = array();
        $forecastItems = json_decode($responseBody);

        $time = '';
        $weather = $forecastItems->weather;
        $temperature = $forecastItems->main;

        foreach ($weather as $key => $value) {
           $forecastItemsAgain['description'] = $value->description;
        }

        $forecastItemsAgain['chanceOfRain'] = $this->k_to_c($temperature->temp);

        // dd($forecastItemsAgain);
        // exit;

        return $forecastItemsAgain;
    }

    public function k_to_c($temp) {
        if ( !is_numeric($temp) ) { return false; }
        return round(($temp - 273.15));
    }
}
