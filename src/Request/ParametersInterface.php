<?php
namespace Zulip\Request;

use Zulip\Authentication;

interface ParametersInterface {
    /**
     * @return array
     */
    public function getData();

    /**
     * Set auth creds to use for specific request
     *
     * @param Authentication $authentication
     * @return void
     */
    public function setAuthentication(Authentication $authentication);

    /**
     * Return the authentication params to use
     *
     * @return Authentication
     */
    public function getAuthentication();
}