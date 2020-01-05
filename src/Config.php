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

    /**
     * Config constructor.
     * @param string $siteUri
     * @param string $email
     * @param string $apiKey
     */
    public function __construct($siteUri, $email, $apiKey)
    {
        $this->siteUri = $siteUri;
        $this->email = $email;
        $this->apiKey = $apiKey;
    }

    /**
     * @param null $filePath
     * @return Config
     * @throws Exception
     */
    public static function fromFile($filePath = null)
    {
        if (is_null($filePath)) {
            if (!array_key_exists('HOME', $_SERVER)) {
                throw new Exception('Could not find HOME in $_SERVER, please supply a file path for config');
            }

            $filePath = $_SERVER['HOME'] . DIRECTORY_SEPARATOR . 'zuliprc';
            if (!file_exists($filePath)) {
                throw new Exception("Could not find zuliprc in user home dir, please supply a file path");
            }
        }

        $config = parse_ini_file($filePath);
        return new self($config['site'], $config['email'], $config['key']);
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
