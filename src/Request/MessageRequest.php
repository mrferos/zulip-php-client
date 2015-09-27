<?php
namespace Zulip\Request;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Zulip\Authentication;
use Zulip\Response;

class MessageRequest extends RequestAbstract
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function initialize($serverUrl, ParametersInterface $params, Authentication $defaultAuthentication)
    {
        $this->validate($params);
        $auth = $params->getAuthentication();
        if (empty($auth)) {
            $auth = $defaultAuthentication;
        }


        $response = $this->client->request('POST',
            $serverUrl . '/api/v1/messages',
            [
                'auth' => [
                    $auth->getUsername(),
                    $auth->getApiKey(),
                ],
                'form_params' => $params->getData()
            ]
        );

        return Response::fromHttpResponse($response);
    }

    /**
     * @param ParametersInterface $params
     * @return mixed
     */
    protected function validate(ParametersInterface $params)
    {
        $requiredKeys = ['type', 'to', 'subject', 'content'];
        $paramData = $params->getData();
        foreach (array_keys($paramData) as $key) {
            $rKey = array_search($key, $requiredKeys);
            if (false !== $rKey && !empty($paramData[$key])) {
                unset($requiredKeys[$rKey]);
            }
        }

        $missing = array_values($requiredKeys);
        if (!empty($missing)) {
            MissingFieldsValidationException::throwException($missing);
        }

        return true;
    }
}