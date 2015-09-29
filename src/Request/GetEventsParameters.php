<?php
namespace Zulip\Request;

class GetEventsParameters extends ParametersAbstract
{
    use SimpleParamTrait;

    /**
     * @inheritDoc
     */
    public function __construct(array $parameters = [])
    {
        $this->params = [
            'queue_id'      => '',
            'last_event_id' => '',
            'dont_block'    => '',
        ];

        foreach ($parameters as $key => $val) {
            $this->params[$key] = $val;
        }
    }

}