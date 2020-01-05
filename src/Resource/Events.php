<?php

namespace Zulip\Resource;

class Events extends AbstractResource
{
    public function retrieve($params)
    {
        return $this->get('/events', $params);
    }
}
