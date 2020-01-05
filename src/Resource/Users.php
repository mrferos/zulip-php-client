<?php

namespace Zulip\Resource;

use GuzzleHttp\Client as HttpClient;
use Psr\Log\LoggerInterface;
use Zulip\Exception;
use Zulip\Resource\Users\Me;

/**
 * Class Users
 * @package Zulip\Resource
 * @property-read Me $me
 */
class Users extends AbstractResource
{
    protected $selfUser;

    public function __construct(HttpClient $client, LoggerInterface $logger)
    {
        parent::__construct($client, $logger);
        $this->selfUser = new Me($client, $logger);
    }

    public function __get($name)
    {
        if ($name === 'me') {
            return $this->selfUser;
        }

        throw new Exception("Unknown property ${name}");
    }

    public function retrieve(array $params = [])
    {
        return $this->get('/users', $params);
    }

    public function create(array $params = [])
    {
        return $this->post('/users', $params);
    }
}
