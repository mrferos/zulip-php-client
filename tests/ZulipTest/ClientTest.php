<?php
namespace ZulipTest;

use Zulip\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testSendRequestWithNoAuthentication()
    {
        $this->setExpectedException('\Exception');
        $client = new Client('http://localhost:9991');
        $client->sendMessage(['params']);
    }

    public function testSetGetHttpClient()
    {
        $client = new Client('http://localhost:9991');
        $httpClient = $this->getMock('\GuzzleHttp\Http\ClientInterface');
        $hash = spl_object_hash($httpClient);
        $client->setHttpClient($httpClient);
        $this->assertEquals($hash, spl_object_hash($client->getHttpClient()));
    }

}