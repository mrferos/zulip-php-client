<?php
namespace Zulip\Request;

abstract class RequestAbstract implements RequestInterface
{
    /**
     * @param ParametersInterface $params
     * @return mixed
     */
    abstract protected function validate(ParametersInterface $params);
}