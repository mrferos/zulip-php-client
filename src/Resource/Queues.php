<?php

namespace Zulip\Resource;

class Queues extends AbstractResource
{
    public function register($initialParams)
    {
        $params = $initialParams;
        if (array_key_exists('event_types', $params)) {
            $params['event_types'] = json_encode($params['event_types']);
        }

        return $this->post('/register', $params);
    }

    public function deregister($params)
    {
        return $this->delete('/events', $params);
    }
}
