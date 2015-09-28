<?php
namespace ZulipTest\Request;

use Zulip\Request\MessageParameters;

class MessageParametersTest extends \PHPUnit_Framework_TestCase
{
    public function testSetParametersOnConstructor()
    {
        $messageParameters = new MessageParameters(['to' => 'test', 'subject' => 'test 123']);
        $data = $messageParameters->getData();
        $this->assertEquals('test', $data['to']);
        $this->assertEquals('test 123', $data['subject']);
    }
}