<?php

namespace App\Services\Weather;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

/**
 * HttpClient is a class for communication with OpenWeather API
 */
class HttpClient {
    protected $client;
    
    /* The endpoint of the URL (server URL) */
    public $api_endpoint;
    
    /* The api key to authorize requests */
    public $api_key;
    
    /* The resource path of the API */
    public $resource = '';

    /**
     * Constructor
     */
    public function __construct() {
        $this->client = new Client();
    }

    /**
     * Generic GET request
     * 
     * @param array $query_params
     * @param array $payload
     * 
     * @return Response
     */
    public function getRequest(array $query_params = [], array $payload = []): Response
    {
        $request_uri = $this->api_endpoint;
        $request_uri .= $this->resource;
        $request_uri .= '?appid=' .$this->api_key;
        
        foreach ($query_params as $query_key => $query) {
            $request_uri .= '&' . $query_key . '=' . $query;
        }

        try {
            return $this->client
                ->request('GET', $request_uri, $payload);
        } catch (\GuzzleHttp\Exception\RequestException $e){
                $response = $e->getResponse();
                $responseBodyAsString = $response->getBody()->getContents();
                
                return $response;
        }
    }
}
