<?php
namespace Zulip\Request;

class RegisterQueueParameters extends ParametersAbstract
{
    protected $params = [
        'event_types'    => [],
        'apply_markdown' => false,
    ];

    const EVENT_TYPE_MESSAGE       = 'message';
    const EVENT_TYPE_SUBSCRIPTIONS = 'subscriptions';
    const EVENT_TYPE_REALM_USER    = 'ream_user';
    const EVENT_TYPE_POINTER       = 'pointer';

    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        foreach ($params as $key => $val) {
            $this->params[$key] = $params;
        }
    }

    /**
     * @param string $eventType
     */
    public function addEventType($eventType)
    {
        $this->params['event_types'][] = $eventType;
    }

    /**
     * @param bool $apply
     */
    public function applyMarkdown($apply)
    {
        $this->params['apply_markdown'] = (bool)$apply;
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        return $this->params;
    }
}