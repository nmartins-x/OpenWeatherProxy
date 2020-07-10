<?php

namespace App\Http\Controllers;

use App\Http\Request\ShowWeatherRequest;
use App\Services\Weather\WeatherService;
use App\Models\Weather;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller {
    /**
     * Show weather report for a city/country in Json format
     * 
     * @param ShowWeatherRequest $request
     * @param WeatherService $weather
     * @return JsonResponse
     */
    public function show(ShowWeatherRequest $request, WeatherService $weather): JsonResponse
    {
        Weather::store(
                $weather->getLocaleWeather([
                    'q' => $request->city . ',' . $request->country,
                    'units' => 'metric'
                ])
        );

        return response()->json([
            'city' => Weather::getCityName(), 
            'country' => Weather::getCountryName(), 
            'temperature' => Weather::getTemperatureInAllFormats()
            ], 200);
    }

}
