<?php
namespace Zulip\Request;

use GuzzleHttp\ClientInterface;
use Zulip\Authentication;

interface RequestInterface
{
    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client);

    /**
     * @param string $serverUrl
     * @param ParametersInterface $params
     * @param Authentication $defaultAuthentication
     * @return mixed
     */
    public function initialize($serverUrl, ParametersInterface $params, Authentication $defaultAuthentication);
}