<?php
namespace Zulip\Request;

abstract class RequestAbstract implements RequestInterface
{
    /**
     * @param ParametersInterface $params
     * @param array $requiredFields
     * @return mixed
     */
    abstract protected function validate(ParametersInterface $params, array $requiredFields);
}