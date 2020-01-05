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
 * @property-read Filters $filters
 * @property-read Queues $queues
 * @property-read Reactions $reactions
 * @property-read Server $server
 * @property-read Streams $streams
 * @property-read Typing $typing
 * @property-read Users $users
 */
class Client
{
    const RESOURCE_TYPE_MESSAGES  = 'messages';
    const RESOURCE_TYPE_ACCOUNTS  = 'accounts';
    const RESOURCE_TYPE_EMOJIS    = 'emojis';
    const RESOURCE_TYPE_EVENTS    = 'events';
    const RESOURCE_TYPE_FILTERS   = 'filters';
    const RESOURCE_TYPE_QUEUES    = 'queues';
    const RESOURCE_TYPE_REACTIONS = 'reactions';
    const RESOURCE_TYPE_SERVER    = 'server';
    const RESOURCE_TYPE_TYPING    = 'typing';
    const RESOURCE_TYPE_USERS     = 'users';
    const RESOURCE_TYPE_STREAMS   = 'streams';

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

    /**
     * Client constructor.
     * @param Config|null $config
     * @param LoggerInterface|null $logger
     * @throws Exception
     */
    public function __construct(Config $config = null, LoggerInterface $logger = null)
    {
        if (!is_null($config)) {
            $this->config = $config;
        }

        $this->logger = $logger ? $logger : new NullLogger();

        $client = $this->getClient();

        // @TODO: might consider changing this into a lazy load
        $this->resources = [
            self::RESOURCE_TYPE_MESSAGES  => new Messages($client, $this->logger),
            self::RESOURCE_TYPE_ACCOUNTS  => new Accounts($client, $this->logger),
            self::RESOURCE_TYPE_EMOJIS    => new Emojis($client, $this->logger),
            self::RESOURCE_TYPE_EVENTS    => new Events($client, $this->logger),
            self::RESOURCE_TYPE_FILTERS   => new Filters($client, $this->logger),
            self::RESOURCE_TYPE_QUEUES    => new Queues($client, $this->logger),
            self::RESOURCE_TYPE_REACTIONS => new Reactions($client, $this->logger),
            self::RESOURCE_TYPE_SERVER    => new Server($client, $this->logger),
            self::RESOURCE_TYPE_STREAMS   => new Streams($client, $this->logger),
            self::RESOURCE_TYPE_TYPING    => new Typing($client, $this->logger),
            self::RESOURCE_TYPE_USERS     => new Users($client, $this->logger),

        ];
    }

    public static function setGlobalConfig(Config $config)
    {
        self::$defaultConfig = $config;
    }

    /**
     * @param $resource
     * @return AbstractResource
     * @throws Exception
     */
    public function getResource($resource)
    {
        if (!array_key_exists($resource, $this->resources)) {
            throw new Exception("Could not find exception of type ${resource}");
        }

        return $this->resources[$resource];
    }

    /**
     * @param $resource
     * @return AbstractResource
     * @throws Exception
     */
    public function __get($resource)
    {
        return $this->getResource($resource);
    }

    /**
     * @return HttpClient
     * @throws Exception
     */
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
