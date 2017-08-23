<?php

namespace CristianPontes\ZohoCRMClient\Tests\Client;

use CristianPontes\ZohoCRMClient\Client\AbstractZohoClient;
use CristianPontes\ZohoCRMClient\Transport\MockLoggerAwareTransport;

/**
 * Class AbstractZohoClientTest
 * @package CristianPontes\ZohoCRMClient\Tests\Client
 */
class AbstractZohoClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockLoggerAwareTransport */
    private $transport;

    /** @var mockZohoCRMClient */
    private $client;

    public function testSetModule()
    {
        $this->client->setModule('Contacts');
        $this->assertEquals('Contacts', $this->client->publicRequest()->getModule());
    }

    protected function setUp()
    {
        $this->transport = new MockLoggerAwareTransport();
        $this->client = new mockZohoClient(array(
            'module' => 'Requests',
            'transport' => $this->transport
        ));
    }
}

/**
 * Class mockZohoCRMClient
 * @package CristianPontes\ZohoCRMClient\Tests
 */
class mockZohoClient extends AbstractZohoClient {
    public function publicRequest()
    {
        return $this->request();
    }

    /**
     * @param string $domain
     * @return string
     */
    public function apiUrl($domain = 'com')
    {
        return 'http://whatever.tld/';
    }
}
