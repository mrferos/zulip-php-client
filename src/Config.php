<?php

namespace Zulip;

class Config
{
    /**
     * @var string
     */
    private $siteUri;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $apiKey;

    public function __construct($siteUri, $email, $apiKey)
    {
        $this->siteUri = $siteUri;
        $this->email = $email;
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getSiteUri()
    {
        return $this->siteUri;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }
}
