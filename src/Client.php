<?php

namespace Zulip;

use GuzzleHttp\Client as HttpClient;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Zulip\Resource\AbstractResource;
use Zulip\Resource\Accounts;
use Zulip\Resource\Emojis;
use Zulip\Resource\Events;
use Zulip\Resource\Filters;
use Zulip\Resource\Messages;
use Zulip\Resource\Queues;
use Zulip\Resource\Reactions;
use Zulip\Resource\Server;
use Zulip\Resource\Streams;
use Zulip\Resource\Typing;
use Zulip\Resource\Users;

/**
 * Class Client
 * @package Zulip
 * @property-read Messages $messages
 * @property-read Accounts $accounts
 * @property-read Emojis $emojis
 * @property-read Events $events
 */
class Client
{
    /**
     * @var  Config
     */
    private static $defaultConfig;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var HttpClient
     */
    private $client;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var AbstractResource[]
     */
    private $resources;

    public function __construct(Config $config = null, LoggerInterface $logger = null)
    {
        if (!is_null($config)) {
            $this->config = $config;
        }

        $this->logger = $logger ? $logger : new NullLogger();

        $client = $this->getClient();
        $this->resources = [
            'messages' => new Messages($client, $this->logger),
            'accounts' => new Accounts($client, $this->logger),
            'emojis'   => new Emojis($client, $this->logger),
            'events'   => new Events($client, $this->logger),
            'filters'  => new Filters($client, $this->logger),
            'queues'   => new Queues($client, $this->logger),
            'reactions' => new Reactions($client, $this->logger),
            'server' => new Server($client, $this->logger),
            'streams' => new Streams($client, $this->logger),
            'typing' => new Typing($client, $this->logger),
            'users' => new Users($client, $this->logger),

        ];
    }

    public static function setGlobalConfig(Config $config)
    {
        self::$defaultConfig = $config;
    }

    public function __get($resource)
    {
        if (!array_key_exists($resource, $this->resources)) {
            throw new Exception("Could not find exception of type ${resource}");
        }

        return $this->resources[$resource];
    }

    private function getClient()
    {
        if (empty($this->client)) {
            $config = $this->getConfig();
            $this->client = new HttpClient([
                'base_uri' => rtrim($config->getSiteUri(), '/'),
                'auth' => [$config->getEmail(), $config->getApiKey()]
            ]);
        }

        return $this->client;
    }

    /**
     * @return Config
     * @throws Exception
     */
    private function getConfig()
    {
        if (empty($this->config)) {
            if (empty(self::$defaultConfig)) {
                throw new Exception(
                    'Configuration has not been set, pass one in the constructor or setConfig()'
                );
            }

            return self::$defaultConfig;
        }

        return $this->config;
    }
}
