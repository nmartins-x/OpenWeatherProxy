<?php

namespace App\Services\Weather;

use App\Services\Weather\HttpClient;

/**
 * OpenWeather is a class responsible for retrieving weather data from the API.
 */
class OpenWeather implements WeatherService{
    protected $client;
    
    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct() {
        $this->client = new HttpClient();
        $this->client->api_endpoint = env('OPENWEATHER_API_ENDPOINT');
        $this->client->api_key = env('OPENWEATHER_API_KEY');
    }
    
    /**
     * Uses a http client to obtain the locale weather data from OpenWeather API.
     * 
     * @param array $query_parameters
     * @return string
     * @throws \Exception
     */
    public function getLocaleWeather(array $query_parameters = []): string {
        $this->client->resource = '/data/2.5/weather';
        
        $response = $this->client->getRequest($query_parameters); 
                
        if($response->getStatusCode() !== 200) {
            throw new \Exception('Error: Not possible to retrieve data');
        }
        
    	return $response->getBody();
    }
    
}



