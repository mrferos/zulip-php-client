<?php

namespace Zulip\Resource;

class Typing extends AbstractResource
{
    public function send(array $initialParams)
    {
        $params = $initialParams;
        if (array_key_exists('to', $params)) {
            $params['to'] = json_encode($params['to']);
        }

        return $this->post('/typing', $params);
    }
}
