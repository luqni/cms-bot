<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NodeApiService
{
    protected $baseUrl;
    protected $username;
    protected $password;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.node_api.base_url');
        $this->username = config('services.node_api.username'); // Basic Auth
        $this->password = config('services.node_api.password'); // Basic Auth
        $this->apiKey = config('services.node_api.api_key');    // x-api-key
    }

    protected function client()
    {
        return Http::withBasicAuth($this->username, $this->password)
                   ->withHeaders([
                       'x-api-key' => $this->apiKey,
                   ]);
    }

    public function get($endpoint, $params = [])
    {
        return $this->client()->get($this->url($endpoint), $params);
    }

    public function post($endpoint, $data = [])
    {
        // dd(json_encode($data));
        return $this->client()
        ->withHeaders(['Content-Type' => 'application/json'])
        ->withBody(json_encode($data), 'application/json')
        ->post($this->url($endpoint));
    }

    public function put($endpoint, $data = [])
    {
        return $this->client()->put($this->url($endpoint), $data)->json();
    }

    public function delete($endpoint)
    {
        return $this->client()->delete($this->url($endpoint))->json();
    }

    private function url($endpoint)
    {
        return rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }
}
