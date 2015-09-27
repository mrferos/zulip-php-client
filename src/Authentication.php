<?php
namespace Zulip;

class Authentication {
    /**
     * Username used for authentication
     *
     * @var string
     */
    protected $username;

    /**
     * API key used for authentication
     *
     * @var string
     */
    protected $apiKey;

    public function __construct($username, $apiKey)
    {
        $this->setUsername($username);
        $this->setApiKey($apiKey);
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }
}