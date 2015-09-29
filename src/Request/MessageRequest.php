<?php
namespace Zulip\Request;

use GuzzleHttp\ClientInterface;
use Zulip\Authentication;

class MessageRequest extends RequestAbstract
{
    use SimpleValidationTrait;

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
        $this->validate($params, ['type', 'to', 'subject', 'content']);
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

        return MessageResponse::fromHttpResponse($response);
    }
}