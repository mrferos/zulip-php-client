<?php

namespace Zulip\Resource;

class Events extends AbstractResource
{
    public function retrieve(array $params = [])
    {
        return $this->get('/events', $params);
    }
}
