<?php

namespace Zulip\Resource;

use GuzzleHttp\Client as HttpClient;
use Psr\Log\LoggerInterface;

abstract class AbstractResource
{
    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(HttpClient $client, LoggerInterface $logger)
    {
        $this->client = $client;
    }

    protected function post($endpoint, array $params)
    {
        $response = $this->client->post("/api/v1/${endpoint}", [
            'form_params' => $params
        ]);

        return new ApiResponse($response);
    }

    protected function get($endpoint, array $params = [])
    {
        $response = $this->client->get("/api/v1/${endpoint}", [
            'query' => $params
        ]);

        return new ApiResponse($response);
    }

    protected function delete($endpoint, array $params = [])
    {
        $response = $this->client->delete("/api/v1/${endpoint}", [
            'query' => $params
        ]);

        return new ApiResponse($response);
    }
}
