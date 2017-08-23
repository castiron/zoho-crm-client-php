<?php
namespace CristianPontes\ZohoCRMClient\Tests\Client;

use CristianPontes\ZohoCRMClient\Client\ZohoCRMClient;
use CristianPontes\ZohoCRMClient\Tests\SingleMessageLogger;
use CristianPontes\ZohoCRMClient\Transport\MockLoggerAwareTransport;

/**
 * Class ZohoCRMClientTest
 * @package CristianPontes\ZohoCRMClient\Tests
 */
class ZohoCRMClientTest extends \PHPUnit_Framework_TestCase
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

    public function testInsertRecords()
    {
        $request = $this->client->insertRecords();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\InsertRecords', $request);
    }

    public function testUpdateRecords()
    {
        $request = $this->client->updateRecords();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\UpdateRecords', $request);
    }

    public function testUpdateRelatedRecords()
    {
        $request = $this->client->updateRelatedRecords();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\UpdateRelatedRecords', $request);
    }

    public function testSearchRecords()
    {
        $request = $this->client->searchRecords();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\SearchRecords', $request);
    }

    public function testGetSearchRecordsByPDC()
    {
        $request = $this->client->getSearchRecordsByPDC();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\GetSearchRecordsByPDC', $request);
    }

    public function testConvertLead()
    {
        $request = $this->client->ConvertLead();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\ConvertLead', $request);
    }

    public function testGetFields()
    {
        $request = $this->client->getFields();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\GetFields', $request);
    }

    public function testDeleteRecords()
    {
        $request = $this->client->deleteRecords();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\DeleteRecords', $request);
    }

    public function testGetDeletedRecordIds()
    {
        $request = $this->client->getDeletedRecordIds();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\GetDeletedRecordIds', $request);
    }

    public function testUploadFile()
    {
        $request = $this->client->uploadFile();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\UploadFile', $request);
    }

    public function testDownloadFile()
    {
        $request = $this->client->downloadFile();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\DownloadFile', $request);
    }

    public function testDeleteFile()
    {
        $request = $this->client->deleteFile();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Request\DeleteFile', $request);
    }

    public function testRequest()
    {
        $request = $this->client->publicRequest();

        $this->assertInstanceOf('CristianPontes\ZohoCRMClient\Transport\TransportRequest', $request);
    }

    public function testSetLogger()
    {
        $logger = new SingleMessageLogger();
        $this->client->setLogger($logger);

        $this->client->getRecords()->request();

        $logs = $logger->getLogs();
        $this->assertEquals('Leads/getRecords', $logs);
    }

    protected function setUp()
    {
        $this->transport = new MockLoggerAwareTransport();
        $this->client = new mockZohoCRMClient(array(
            'module' => 'Leads',
            'transport' => $this->transport
        ));
    }
}

/**
 * Class mockZohoCRMClient
 * @package CristianPontes\ZohoCRMClient\Tests
 */
class mockZohoCRMClient extends ZohoCRMClient {
    /**
     * @return \CristianPontes\ZohoCRMClient\Transport\TransportRequest
     */
    public function publicRequest()
    {
        return $this->request();
    }
}
