<?php

namespace App\Models;

use App\Services\Weather\WeatherService;

/**
 * Weather Model
 */
class Weather
{
    /* @param string $data Collects weather data in Json format */
    protected static $data = '';
    
    /**
     * Store a new resource
     * 
     * @param string $data
     * @return void
     */
    public static function store(string $data): void
    {
        self::$data = $data;
    }
    
    /**
     * Retrieve temperature in Celsius
     * 
     * @return int
     */
    public static function getTemperatureInCelsius(): int
    {
        $data = json_decode(self::$data);
        
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
    public static function getTemperatureInKelvin(): int
    {
        return self::getTemperatureInCelsius() + 273.15;
    }
    
     /**
     * Retrieve temperature in Fahrenheit
     * 
     * @return int
     */
    public static function getTemperatureInFahrenheit(): int
    {
        return self::getTemperatureInCelsius() * 1.8 + 32;
    }
    
     /**
     * Retrieve temperature in all available formats
     * 
     * @return int
     */
    public static function getTemperatureInAllFormats(): array
    {
        return array(
            'celsius' => self::getTemperatureInCelsius(), 
            'kelvin' => self::getTemperatureInKelvin(),
            'fahrenheit' => self::getTemperatureInFahrenheit()
            );
    }
    
    /**
     * City Name
     * 
     * @return string
     */
    public static function getCityName(): string
    {
        $data = json_decode(self::$data);
        
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
    public static function getCountryName(): string
    {
        $data = json_decode(self::$data);
        
        try {
            return $data->sys->country;
        } catch(\Exception $e) {
            return '';
        }
    }
    
}
