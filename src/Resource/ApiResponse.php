<?php

namespace Zulip\Resource;

use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\ResponseInterface;

class ApiResponse
{
    private $rawResponse;

    public function __construct(ResponseInterface $response)
    {
        $this->rawResponse = $response;
    }

    public function isSuccessful()
    {
        return substr($this->rawResponse->getStatusCode(), 0, 1) == 2;
    }

    public function getData()
    {
        $body = $this->rawResponse->getBody();
        if ($body instanceof Stream) {
            return json_decode($body->getContents());
        }

        return $this->rawResponse->getBody();
    }

    /**
     * @return ResponseInterface
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }
}
