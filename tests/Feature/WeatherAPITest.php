<?php

namespace Tests\Feature;

use Tests\TestCase;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Client;
use App\Services\Weather\HttpClient;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\File;

class WeatherAPITest extends TestCase {   
    /**
     * Expected JSON structure for all API responses
     * 
     * @var type 
     */
    protected static $jsonResponseStructure = [
        'temperature' => []
        ];

    public function setUp(): void
    {
        parent::setUp();
        
        $this->withHeaders([
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ]);
    }
    
    /**
     * Test Weather API endpoint: Show temperature by city name
     *
     * @return void
     */
    public function test_api_should_return_temperature_by_city()
    {
        // city should be part of the expected Json
        self::$jsonResponseStructure[] = 'city';
        
        $mock = $this->mock(\App\Services\Weather\OpenWeather::class);
        $mock->shouldReceive('getLocaleWeather')
                ->andReturn(File::get(base_path('/stubs/openweather/success.json')));

        $response = $this->get("/api/weather?city=LND");
        
        $response->assertStatus(200)
         ->assertJsonStructure(self::$jsonResponseStructure);
    }

    /**
     * Test Weather API endpoint: Show temperature by country name
     *
     * @return void
     */
    public function test_api_should_return_temperature_by_country() {
        // country should be part of the expected Json
        self::$jsonResponseStructure[] = 'country';

        $mock = $this->mock(\App\Services\Weather\OpenWeather::class);
        $mock->shouldReceive('getLocaleWeather')
                ->andReturn(File::get(base_path('/stubs/openweather/success.json')));

        $response = $this->get("/api/weather?country=UK");
        
        $response->assertStatus(200)
         ->assertJsonStructure(self::$jsonResponseStructure);
    }
    
     /**
     * Test Weather API endpoint: Show error message if missed fields
     *
     * @return void
     */
    public function test_api_should_show_error_if_missing_query_fields() {
        $this->get("/api/weather")
            ->assertStatus(422);
    }

}
