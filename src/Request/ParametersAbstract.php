<?php
namespace Zulip\Request;

use Zulip\Authentication;

abstract class ParametersAbstract implements ParametersInterface
{
    /**
     * @var Authentication;
     */
    protected $authentication;

    /**
     * @inheritDoc
     */
    public function setAuthentication(Authentication $authentication)
    {
       $this->authentication = $authentication;
    }

    /**
     * @inheritDoc
     */
    public function getAuthentication()
    {
        return $this->authentication;
    }
}