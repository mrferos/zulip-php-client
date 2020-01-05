<?php

namespace Zulip\Resource;

class Emojis extends AbstractResource
{
    public function retrieve(array $params = [])
    {
        return $this->get('/realm/emoji', $params);
    }
}
