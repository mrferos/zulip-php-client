<?php

namespace Zulip\Resource\Users;

use Zulip\Resource\AbstractResource;

class Me extends AbstractResource
{
    public function retrievePointer(array $params = [])
    {
        return $this->get('/users/me/pointer', $params);
    }

    public function updatePointer(array $params = [])
    {
        return $this->post('/users/me/pointer', $params);
    }

    public function getProfile()
    {
        return $this->get('/users/me');
    }

    public function addSubscription(array $params = [])
    {
        return $this->post('/users/me/subscriptions', $params);
    }

    public function removeSubscription(array $params = [])
    {
        return $this->delete('/users/me/subscriptions', $params);
    }

    public function retrieveAlertWords(array $params = [])
    {
        return $this->get('/users/me/alert_words', $params);
    }
}
