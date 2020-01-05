<?php

namespace Zulip\Resource;

class Emojis extends AbstractResource
{
    public function retrieve($params)
    {
        return $this->get('/realm/emoji', $params);
    }
}
