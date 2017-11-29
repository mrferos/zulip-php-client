<?php
namespace Zulip\Request;

use GuzzleHttp\ClientInterface;
use Zulip\Authentication;

class GetEventsRequest extends RequestAbstract
{
    use SimpleValidationTrait;

    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @inheritDoc
     */
    public function __construct(ClientInterface $client)
    {
        $this->httpClient = $client;
    }

    /**
     * @inheritDoc
     */
    public function initialize($serverUrl, ParametersInterface $params, Authentication $defaultAuthentication)
    {
        $this->validate($params, ['queue_id', 'last_event_id']);
        $auth = $params->getAuthentication();
        if (empty($auth)) {
            $auth = $defaultAuthentication;
        }


        $response = $this->httpClient->request('POST',
            $serverUrl . '/api/v1/events',
            [
                'auth' => [
                    $auth->getUsername(),
                    $auth->getApiKey(),
                ],
                'form_params' => $params->getData()
            ]
        );

        return GetEventsResponse::fromHttpResponse($response);
    }
}
