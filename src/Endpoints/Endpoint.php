<?php

namespace Nanuc\Nextcloud\Endpoints;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Nanuc\Nextcloud\ResponseParsers\ResponseParser;
use Nanuc\Nextcloud\ResponseParsers\UserListParser;

class Endpoint
{
    protected function get($uri, $parserClass = ResponseParser::class)
    {
        return $this->request('get', $uri, null, $parserClass);
    }

    protected function post($uri, $data = [], $parserClass = ResponseParser::class)
    {
        return $this->request('post', $uri, $data, $parserClass);
    }

    protected function put($uri, $data = [], $parserClass = ResponseParser::class)
    {
        return $this->request('put', $uri, $data, $parserClass);
    }

    protected function delete($uri, $data = [], $parserClass = ResponseParser::class)
    {
        return $this->request('delete', $uri, $data, $parserClass);
    }

    protected function request($method, $uri, $data, $parserClass)
    {
        $time = microtime(true);
        $response = $this->getClient()->$method($this->getUrl($uri), $data);
        $time = microtime(true) - $time;

        if(config('laravel-nextcloud.logging')) {
            Log::channel(config('laravel-nextcloud.logging-channel'))
                ->info(PHP_EOL.
                    'Method:   ' . $method . PHP_EOL .
                    'URI:      ' . $this->getUrl($uri) . PHP_EOL .
                    'Data:     ' . json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL .
                    'Runtime:  ' . $time . PHP_EOL .
                    'Response: ' . PHP_EOL . $response->body()
                );
        }

        return $this->parseResponse($response, $parserClass);
    }
    
    private function getUrl($uri)
    {
        return config('laravel-nextcloud.endpoint') . '/ocs/v1.php/cloud/' . $uri;
    }

    private function parseResponse(Response $response, $parserClass = ResponseParser::class)
    {
        $parser = new $parserClass($response->body());

        return $parser->parse();
    }

    private function getClient()
    {
        return Http::withBasicAuth(config('laravel-nextcloud.username'), config('laravel-nextcloud.password'))
            ->withHeaders([
                'OCS-APIRequest' => 'true',
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])
            ->asForm();
    }
}
