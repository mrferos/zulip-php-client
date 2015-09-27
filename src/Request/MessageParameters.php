<?php
namespace Zulip\Request;

/**
 * Class MessageParameters
 * @package Zulip\Request
 * @method string setType() set message type
 * @method string setContent() set content for message
 * @method string setTo() set to
 * @method string setSubject() set message subject
 */
class MessageParameters extends ParametersAbstract
{
    const TYPE_PRIVATE = 'private';
    const TYPE_STREAM  = 'stream';

    use SimpleParamTrait;

    /**
     * @inheritDoc
     */
    public function __construct(array $params = [])
    {
        $this->params = [
            'type'    => '',
            'content' => '',
            'to'      => '',
            'subject' => ''
        ];

        foreach ($params as $key => $param) {
            if (array_key_exists($key, $this->params)) {
                $this->params[$key] = $param;
            }
        }
    }
}