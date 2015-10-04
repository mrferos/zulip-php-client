<?php
namespace Zulip\Request;

use Psr\Http\Message\ResponseInterface as PsrHttpResponseInterface;

class MessageResponse implements ResponseInterface
{
    /**
     * @var string
     */
    protected $msg;
    /**
     * @var string
     */
    protected $result;
    /**
     * @var string
     */
    protected $id;

    /**
     * @param string $msg
     * @param string $result
     * @param string $id
     */
    public function __construct($msg, $result, $id)
    {
        $this->setMsg($msg);
        $this->setId($id);
        $this->setResult($result);
    }

    public function isSuccessful()
    {
        return $this->getMsg() == 'success';
    }

    /**
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param string $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
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

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public static function fromHttpResponse(PsrHttpResponseInterface $response)
    {
        $body = (string)$response->getBody();
        $data = json_decode($body, true);
        return new static($data['msg'], $data['result'], $data['id']);
    }
}