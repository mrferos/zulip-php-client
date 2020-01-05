<?php

namespace Zulip\Resource;

use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\ResponseInterface;
use Zulip\Exception;

class ApiResponse implements \ArrayAccess
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
            return json_decode($body->getContents(), true);
        }

        return $this->rawResponse->getBody();
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        $data = $this->getData();
        return array_key_exists($offset, $data);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        $data = $this->getData();
        return $data[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @throws Exception
     */
    public function offsetSet($offset, $value)
    {
        throw new Exception('Cannot set values on a response');
    }

    /**
     * @param mixed $offset
     * @throws Exception
     */
    public function offsetUnset($offset)
    {
        throw new Exception('Cannot unset values on a response');
    }

    /**
     * @return ResponseInterface
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }
}
