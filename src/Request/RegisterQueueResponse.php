<?php
namespace Zulip\Request;

use GuzzleHttp\Psr7\Response;

class RegisterQueueResponse implements ResponseInterface
{
    /**
     * @var string
     */
    protected $lastEventId;
    /**
     * @var string
     */
    protected $queueId;
    /**
     * @var string
     */
    protected $result;

    public function __construct($lastEventId, $queueId, $result)
    {

        $this->lastEventId = $lastEventId;
        $this->queueId = $queueId;
        $this->result = $result;
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        return $this->getResult() == self::RESULT_SUCCESSFUL;
    }


    /**
     * @return string
     */
    public function getLastEventId()
    {
        return $this->lastEventId;
    }

    /**
     * @param string $lastEventId
     */
    public function setLastEventId($lastEventId)
    {
        $this->lastEventId = $lastEventId;
    }

    /**
     * @return string
     */
    public function getQueueId()
    {
        return $this->queueId;
    }

    /**
     * @param string $queueId
     */
    public function setQueueId($queueId)
    {
        $this->queueId = $queueId;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param string $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    public static function fromHttpResponse(Response $response)
    {
        $body = (string)$response->getBody();
        $data = json_decode($body, true);
        return new static($data['last_event_id'], $data['queue_id'], $data['result']);
    }
}