<?php
namespace ZulipTest\Request;

use Zulip\Request\MessageRequest;

class MessageRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testInitializeInvalidParams()
    {
        $this->setExpectedException('\Zulip\Request\MissingFieldsValidationException');

        $params = $this->getMock('\Zulip\Request\ParametersInterface');
        $httpClient = $this->getMock('\GuzzleHttp\ClientInterface');
        $authentication = $this->getMockBuilder('\Zulip\Authentication')
            ->disableOriginalConstructor()
            ->getMock();

        $params->expects($this->any())
            ->method('getData')
            ->willReturn([
                'subject' => 'test',
                'content' => 'test'
            ]);

        $messageRequest = new MessageRequest($httpClient);
        $messageRequest->initialize('test', $params, $authentication);
    }

    public function testInitializeFallsBackOnProvidedAuthentication()
    {
        $httpClient = $this->getMock('\GuzzleHttp\ClientInterface');

        $httpClient->expects($this->once())
                    ->method('request')
                    ->willReturnCallback(function($type, $url, $options) {
                        $this->assertEquals('POST', $type);
                        $this->assertContains('test', $url);
                        $this->assertArrayHasKey('auth', $options);
                        $this->assertArrayHasKey('form_params', $options);
                        $this->assertEquals('test', $options['auth'][0]);
                        $this->assertEquals('test123', $options['auth'][1]);

                        return $this->getMock('\GuzzleHttp\Psr7\Response');
                    });

        $params = $this->getMock('\Zulip\Request\ParametersInterface');
        $params->expects($this->once())
                ->method('getAuthentication')
                ->willReturn(null);

        $params->expects($this->any())
                ->method('getData')
                ->willReturn([
                    'to' => 'test',
                    'type' => 'stream',
                    'subject' => 'test',
                    'content' => 'test'
                ]);

        $authentication = $this->getMockBuilder('\Zulip\Authentication')
                                    ->disableOriginalConstructor()
                                    ->getMock();
        $authentication->expects($this->once())
                        ->method('getUsername')
                        ->willReturn('test');
        $authentication->expects($this->once())
                        ->method('getApiKey')
                        ->willReturn('test123');

        $messageRequest = new MessageRequest($httpClient);
        $messageRequest->initialize('test', $params, $authentication);

    }
}