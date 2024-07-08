<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function weather($city, $country )
    {
        $data = Http::get('api.weatherapi.com/v1/current.json?key=c5c14d078ec8435197541349242706&q=' . $city . '-' . $country . '&aqi=no');
        return $data['current'];
    }
}
