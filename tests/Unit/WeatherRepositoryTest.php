<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\File;
use App\Models\Weather;
use App\Repositories\WeatherRepository;

class WeatherRepositoryTest extends TestCase {
    protected $repository;
    
    public function setUp(): void
    {
        parent::setUp();
        
        $this->repository = new WeatherRepository(new Weather);
    }
    
    public function test_can_store_weather_data()
    {
        $data = File::get(base_path('/stubs/openweather/success.json'));
        
        $response = $this->repository->store($data);
        
        $this->assertSame(Weather::$data, $data);
        $this->assertSame(Weather::$data, $response);
    }
    
    public function test_can_get_weather_temperature()
    {
        // same temperature in different units
        $temp = [
            'celsius' => 19,
            'kelvin' => 292,
            'fahrenheit' => 66
        ];

        $data = ['main' => [
            'temp' => $temp['celsius']
        ]];
        
        $this->repository->store(json_encode($data));
        
        $this->assertSame(
                $this->repository->getTemperatureInCelsius(),
                $temp['celsius']   
            );
        
        $this->assertSame(
                $this->repository->getTemperatureInKelvin(),
                $temp['kelvin']
            );
     
        $this->assertSame(
                $this->repository->getTemperatureInFahrenheit(),
                $temp['fahrenheit']
            );
        
        $this->assertSame(
                $this->repository->getTemperatureInAllFormats(),
                $temp
            );
    }
    
    public function test_can_get_city_and_coutry()
    {
        $data = File::get(base_path('/stubs/openweather/success.json'));
        
        Weather::$data = $data;
        
        $this->assertSame($this->repository->getCityName(), json_decode(Weather::$data )->name);
        $this->assertSame($this->repository->getCountryName(), json_decode(Weather::$data)->sys->country);
    }
    
}
