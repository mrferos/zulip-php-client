<?php

namespace Zulip\Resource;

class Accounts extends AbstractResource
{
    public function retrieve(array $params = [])
    {
        return $this->post('/fetch_api_key', $params);
    }
}
