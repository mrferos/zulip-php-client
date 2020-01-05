<?php

namespace Zulip\Resource;

class Filters extends AbstractResource
{
    public function retrieve($params)
    {
        return $this->get('/realm/filters', $params);
    }
}
