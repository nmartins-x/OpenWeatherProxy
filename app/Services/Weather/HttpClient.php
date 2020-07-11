<?php

namespace App\Services\Weather;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

/**
 * HttpClient is a class for communication with an external API
 */
class HttpClient {
    protected $client;
    
    /* The endpoint of the URL (server URL) */
    public $api_endpoint;
    
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
        $request_uri = $this->uriBuilder($query_params);

        try {
            return $this->client
                ->request('GET', $request_uri, $payload);
        } catch (\GuzzleHttp\Exception\RequestException $e){
                $response = $e->getResponse();
                
                return $response;
        }
    }
    
    /**
     * Builds the full path of the URI resource to be called over HTTP
     * 
     * @param type $query_params
     * @return string
     */
    protected function uriBuilder($query_params): string
    {
        $request_uri = $this->api_endpoint;
        $request_uri .= $this->resource;
        $request_uri .= empty($query_params) ? '' : '?';
        
        foreach ($query_params as $query_key => $query) {
            $request_uri .= $query_key . '=' . $query . '&';
        }
        
        // remove trailing '&'
        $request_uri = rtrim($request_uri, '&');
        
        return $request_uri;
    }
}
