<?php

namespace Zulip\Resource;

class Server extends AbstractResource
{
    public function settings(array $params = [])
    {
        return $this->get('/server_settings', $params);
    }
}
