<?php

namespace App\Http\Controllers;

use App\Http\Request\ShowWeatherRequest;
use App\Services\Weather\WeatherService;
use App\Repositories\WeatherRepository;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller {
    protected $repository;
  
    public function __construct(WeatherRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Show weather report for a city/country in Json format
     * 
     * @param ShowWeatherRequest $request
     * @param WeatherService $weather
     * @return JsonResponse
     */
    public function show(ShowWeatherRequest $request, WeatherService $weather): JsonResponse
    {
        $this->repository->store(
                $weather->getLocaleWeather([
                    'q' => $request->city . ',' . $request->country,
                    'units' => 'metric'
                ])
        );

        return response()->json([
            'city' => $this->repository->getCityName(), 
            'country' => $this->repository->getCountryName(), 
            'temperature' => $this->repository->getTemperatureInAllFormats()
            ], 200);
    }

}
