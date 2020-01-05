<?php

namespace Zulip\Resource;

class Messages extends AbstractResource
{
    public function retrieve(array $initialParams)
    {
        $params = $initialParams;
        if (array_key_exists('narrow', $params)) {
            $params['narrow'] = json_encode($params['narrow']);
        }

        return $this->get('/messages', $params);
    }

    public function send(array $params)
    {
        return $this->post('/messages', $params);
    }

    public function render($initialParams)
    {
        $params = is_string($initialParams) ? ['content' => $initialParams] : $initialParams;
        return $this->post('/messages', $params);
    }

    public function update($params)
    {
        $endpoint = "/messages/${params['message_id']}";
        return $this->post($endpoint, $params);
    }

    public function addFlags($initialParams)
    {
        $params = $initialParams;
        $params['op'] = 'add';
        if ($params['messages']) {
            $params['messages'] = json_encode($params['messages']);
        }

        return $this->post('/messages/flags', $params);
    }

    public function removeFlags($initialParams)
    {
        $params = $initialParams;
        $params['op'] = 'remove';
        if ($params['messages']) {
            $params['messages'] = json_encode($params['messages']);
        }

        return $this->post('/messages/flags', $params);
    }

    public function getById($params)
    {
        $endpoint = "/messages/${params['message_id']}";
        return $this->get($endpoint, $params);
    }

    public function getHistoryById($params)
    {
        $endpoint = "/messages/${params['message_id']}/history";
        return $this->get($endpoint, $params);
    }

    public function deleteReactionById($params)
    {
        $endpoint = "/messages/${params['message_id']}/reactions";
        return $this->delete($endpoint, $params);
    }

    public function deleteById($params)
    {
        $endpoint = "/messages/${params['message_id']}";
        return $this->delete($endpoint, $params);
    }
}
