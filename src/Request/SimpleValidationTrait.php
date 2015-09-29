<?php
namespace Zulip\Request;

trait SimpleValidationTrait {
    /**
     * @param ParametersInterface $params
     * @return mixed
     */
    protected function validate(ParametersInterface $params, array $requiredKeys)
    {
        $paramData = $params->getData();
        foreach (array_keys($paramData) as $key) {
            $rKey = array_search($key, $requiredKeys);
            if (false !== $rKey && !empty($paramData[$key])) {
                unset($requiredKeys[$rKey]);
            }
        }

        $missing = array_values($requiredKeys);
        if (!empty($missing)) {
            MissingFieldsValidationException::throwException($missing);
        }

        return true;
    }
}