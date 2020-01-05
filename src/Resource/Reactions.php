<?php

namespace Zulip\Resource;

class Reactions extends AbstractResource
{
    public function add(array $params = [])
    {
        $endpoint = "/messages/${params['message_id']}/reactions";
        unset($params['message_id']);
        return $this->post($endpoint, $params);
    }

    public function remove(array $params = [])
    {
        $endpoint = "/messages/${params['message_id']}/reactions";
        unset($params['message_id']);
        return $this->delete($endpoint, $params);
    }
}
