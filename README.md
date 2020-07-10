
# OpenWeather Proxy
Simple REST API for retrieving the temperature of a city/country in Celsius, Kelvin and Fahrenheit.

## Installation

Install laravel dependencies via composer:
```bash
composer install
```

Create environment file:
```bash
cp .env.example .env
```
Finally, add an OpenWeather API key ([https://openweathermap.org/api](https://openweathermap.org/api)) on the .env file

## Usage

GET request:
http://laravel.test/api/weather?city=London
or
http://laravel.test/api/weather?city=London&country=CA