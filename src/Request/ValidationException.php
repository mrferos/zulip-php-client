<?php
namespace Zulip\Request;

use Exception;

class ValidationException extends \Exception
{
    /**
     * @var array
     */
    protected $errors;

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    public static function throwException(array $errors)
    {
        $exception = new static("There are validation errors in your request");
        $exception->setErrors($errors);

        throw $exception;
    }
}