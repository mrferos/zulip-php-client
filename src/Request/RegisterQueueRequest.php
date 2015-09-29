<?php
namespace Zulip\Request;

use GuzzleHttp\ClientInterface;
use Zulip\Authentication;

class RegisterQueueRequest extends RequestAbstract
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
        $this->validate($params, ['event_types','apply_markdown']);
        $auth = $params->getAuthentication();
        if (empty($auth)) {
            $auth = $defaultAuthentication;
        }

        $formData = $params->getData();
        if (empty($formData['event_types'])) {
            unset($formData['event_types']);
        } else {
            $formData['event_types'] = json_encode($formData['event_types']);
        }

        $formData['apply_markdown'] = $formData['apply_markdown'] === true ? 'true' : 'false';

        $response = $this->httpClient->request('POST',
            $serverUrl . '/api/v1/register',
            [
                'auth' => [
                    $auth->getUsername(),
                    $auth->getApiKey(),
                ],
                'form_params' => $formData
            ]
        );

        return RegisterQueueResponse::fromHttpResponse($response);
    }
}