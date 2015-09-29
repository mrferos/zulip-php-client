<?php
namespace Zulip\Request;

interface ResponseInterface
{
    const RESULT_SUCCESSFUL = 'success';

    /**
     * @return bool
     */
    public function isSuccessful();
}