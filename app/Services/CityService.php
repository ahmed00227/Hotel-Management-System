<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CityService
{

    public function __construct()
    {
    }

    public function cities($country)
    {
        $response = Http::post('https://countriesnow.space/api/v0.1/countries/cities', [
            'country' => $country
        ]);

        if ($response->successful()) {
            $cities = $response['data'];
            return $cities;
        } else {
            return null;
        }
    }
}
