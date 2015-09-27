<?php
namespace Zulip\Request;

trait SimpleParamTrait {
    protected $params = [];

    public function __call($func, array $params)
    {
        if (empty($this->params)) {
            throw new \RuntimeException('Please specify parameters in class constructor');
        }

        if (preg_match('/set(\w+)/', $func, $match)) {
            $key = strtolower($match[1]);
            if (!array_key_exists($key, $this->params)) {
                throw new \RuntimeException('No such key: ' . $key);
            }

            $this->params[$key] = $params[0];
            return true;
        }

        throw new \BadMethodCallException('No such method ' . $func);
    }
    /**
     * @return array
     */
    public function getData()
    {
        return $this->params;
    }

}