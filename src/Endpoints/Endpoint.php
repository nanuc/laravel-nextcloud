<?php

namespace Nanuc\Nextcloud\Endpoints;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Nanuc\Nextcloud\ResponseParsers\ResponseParser;
use Nanuc\Nextcloud\ResponseParsers\UserListParser;

class Endpoint
{
    protected function get($uri, $parserClass = ResponseParser::class)
    {
        return $this->request('get', $uri, null, $parserClass);
        return $this->parseResponse($this->client->get($this->getUrl($uri)), $parserClass);
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
        return $this->parseResponse($this->getClient()->$method($this->getUrl($uri), $data), $parserClass);
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
