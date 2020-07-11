<?php

namespace App\Repositories;

use App\Models\Weather;

class WeatherRepository {
     /**
     * Model instance.
     */
    protected $model;
    /**
     * load default class dependencies.
     * 
     * @param Model $model 
     */
    public function __construct(Weather $model)
    {
        $this->model = $model;
    }
        
    /**
     * Store a new resource
     * 
     * @param string $data
     * @return void
     */
    public function store(string $data): string
    {
        $this->model::$data = $data;
        
        return $data;
    }
    
    /**
     * Retrieve temperature in Celsius
     * 
     * @return int
     */
    public function getTemperatureInCelsius(): int
    {
        $data = json_decode($this->model::$data);
        
        try {
            return (int) $data->main->temp;
        } catch(\Exception $e) {
            return 0;
        }
    }
    
     /**
     * Retrieve temperature in Kelvin
     * 
     * @return int
     */
    public function getTemperatureInKelvin(): int
    {
        return $this->getTemperatureInCelsius() + 273.15;
    }
    
     /**
     * Retrieve temperature in Fahrenheit
     * 
     * @return int
     */
    public function getTemperatureInFahrenheit(): int
    {
        return $this->getTemperatureInCelsius() * 1.8 + 32;
    }
    
     /**
     * Retrieve temperature in all available formats
     * 
     * @return int
     */
    public function getTemperatureInAllFormats(): array
    {
        return array(
            'celsius' => $this->getTemperatureInCelsius(), 
            'kelvin' => $this->getTemperatureInKelvin(),
            'fahrenheit' => $this->getTemperatureInFahrenheit()
            );
    }
    
    /**
     * City Name
     * 
     * @return string
     */
    public function getCityName(): string
    {
        $data = json_decode($this->model::$data);
        
        try {
            return $data->name;
        } catch(\Exception $e) {
            return '';
        }
    }
    
    /**
     * Country name
     * 
     * @return string
     */
    public function getCountryName(): string
    {
        $data = json_decode($this->model::$data);
        
        try {
            return $data->sys->country;
        } catch(\Exception $e) {
            return '';
        }
    }
}
