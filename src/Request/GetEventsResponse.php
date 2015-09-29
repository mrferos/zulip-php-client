<?php
namespace Zulip\Request;

use GuzzleHttp\Psr7\Response;

class GetEventsResponse implements  ResponseInterface
{
    /**
     * @var array
     */
    private $events;
    /**
     * @var string
     */
    private $result;

    public function __construct($events, $result)
    {
        $this->events = $events;
        $this->result = $result;
    }

    public function isSuccessful()
    {
        return $this->getResult() == self::RESULT_SUCCESSFUL;
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    public static function fromHttpResponse(Response $response)
    {
        $body = (string)$response->getBody();
        $data = json_decode($body, true);
        return new static($data['events'], $data['result']);
    }
}