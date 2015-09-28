<?php

class SimpleParamTraitClass {
    use \Zulip\Request\SimpleParamTrait;

    public function __construct()
    {
        $this->params = ['to' => 'val', 'from' => 'this is a test'];
    }
}