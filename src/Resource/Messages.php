<?php

namespace Zulip\Resource;

class Messages extends AbstractResource
{
    public function uploadFile(array $params)
    {
        $fileName = $params['filename'];
        $response = $this->client->post('/api/v1/user_uploads', [
            'multipart' => [
                [
                    'name' => 'FileContents',
                    'contents' => file_get_contents($fileName),
                    'filename' => $fileName
                ]
            ],
        ]);

        return new ApiResponse($response);
    }

    public function retrieve(array $initialParams = [])
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

    public function update(array $params)
    {
        $endpoint = "/messages/${params['message_id']}";
        unset($params['message_id']);
        return $this->post($endpoint, $params);
    }

    public function addFlags(array $initialParams)
    {
        $params = $initialParams;
        $params['op'] = 'add';
        if ($params['messages']) {
            $params['messages'] = json_encode($params['messages']);
        }

        return $this->post('/messages/flags', $params);
    }

    public function removeFlags(array $initialParams)
    {
        $params = $initialParams;
        $params['op'] = 'remove';
        if ($params['messages']) {
            $params['messages'] = json_encode($params['messages']);
        }

        return $this->post('/messages/flags', $params);
    }

    public function getById(array $params)
    {
        $endpoint = "/messages/${params['message_id']}";
        unset($params['message_id']);
        return $this->get($endpoint, $params);
    }

    public function getHistoryById(array $params)
    {
        $endpoint = "/messages/${params['message_id']}/history";
        unset($params['message_id']);
        return $this->get($endpoint, $params);
    }

    public function deleteReactionById(array $params)
    {
        $endpoint = "/messages/${params['message_id']}/reactions";
        unset($params['message_id']);
        return $this->delete($endpoint, $params);
    }

    public function deleteById(array $params)
    {
        $endpoint = "/messages/${params['message_id']}";
        unset($params['message_id']);
        return $this->delete($endpoint, $params);
    }
}
