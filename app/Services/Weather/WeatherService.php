<?php

namespace App\Services\Weather;

/**
 * Interface for a Weather service
 */
interface WeatherService {
    public function getLocaleWeather(array $query_parameters = []): string;
}
