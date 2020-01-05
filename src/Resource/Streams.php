<?php

namespace Zulip\Resource;

class Streams extends AbstractResource
{
    public function retrieve(array $params)
    {
        return $this->get('/streams', $params);
    }

    public function getStreamId(array $initialParams)
    {
        $endpoint = '/get_stream_id';
        $params = is_string($initialParams) ? ['stream' => $initialParams] : $initialParams;
        return $this->get($endpoint, $params);
    }

    public function retrieveSubscriptions($params)
    {
        return $this->get('/users/me/subscriptions', $params);
    }

    public function retrieveTopics($params)
    {
        $endpoint = "users/me/${params['stream_id']}/topics";
        unset($params['stream_id']);
        return $this->get($endpoint, $params);
    }
}
