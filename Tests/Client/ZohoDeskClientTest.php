<?php
namespace CristianPontes\ZohoCRMClient\Tests\Client;

use CristianPontes\ZohoCRMClient\Client\ZohoDeskClient;
use CristianPontes\ZohoCRMClient\Tests\SingleMessageLogger;
use CristianPontes\ZohoCRMClient\Transport\MockLoggerAwareTransport;

/**
 * Class ZohoDeskClientTest
 * @package CristianPontes\ZohoCRMClient\Tests\Client
 */
class ZohoDeskClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockLoggerAwareTransport */
    private $transport;

    /** @var mockZohoCRMClient */
    private $client;

    public function testRequest()
    {
        $request = $this->client->publicRequest();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Transport\TransportRequest', $request);
    }

    public function testGetRecords()
    {
        $request = $this->client->getRecords();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\GetRecords', $request);
    }

    public function testGetRecordById()
    {
        $request = $this->client->getRecordById();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\GetRecordById', $request);
    }

    public function testUpdateRecords()
    {
        $request = $this->client->updateRecords();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\UpdateRecords', $request);
    }

    public function testDeleteRecords()
    {
        $request = $this->client->deleteRecords();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\DeleteRecords', $request);
    }

    public function testSearchRecords()
    {
        $request = $this->client->searchRecords();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\SearchRecords', $request);
    }

    public function testSetLogger()
    {
        $logger = new SingleMessageLogger();
        $this->client->setLogger($logger);

        $this->client->getRecords()->request();

        $logs = $logger->getLogs();
        $this->assertEquals('Requests/getRecords', $logs);
    }

    protected function setUp()
    {
        $this->transport = new MockLoggerAwareTransport();
        $this->client = new mockZohoDeskClient(array(
            'module' => 'Requests',
            'transport' => $this->transport,
            'portalName' => 'someportal',
            'departmentName' => 'somedepartment',
        ));
    }
}

/**
 * Class mockZohoCRMClient
 * @package CristianPontes\ZohoCRMClient\Tests
 */
class mockZohoDeskClient extends ZohoDeskClient {
    public function publicRequest()
    {
        return $this->request();
    }
}
