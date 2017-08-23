<?php

namespace CristianPontes\ZohoCRMClient\Client;

use Buzz\Browser;
use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport;

/**
 * Class ZohoCRMClient
 * @package CristianPontes\ZohoCRMClient\Client
 */
class ZohoCRMClient extends AbstractZohoClient
{
    /**
     * @param $domain
     * @return string
     */
    protected function apiUrl($domain = 'com')
    {
        return 'https://crm.zoho.' . $domain . '/crm/private/xml/';
    }

    /**
     * @param $authToken
     * @param $domain
     * @param Browser $browser
     * @return Transport\Transport
     */
    protected function initTransport($authToken, $domain, Browser $browser)
    {
        $transport = parent::initTransport($authToken, $domain, $browser);
        return new Transport\CrmTransportDecorator($transport);
    }

    /**
     * @return Request\GetRecords
     */
    public function getRecords()
    {
        return new Request\GetRecords($this->request());
    }

    /**
     * @param int|null $id
     * @return Request\GetRecordById
     */
    public function getRecordById($id = null)
    {
        $request = new Request\GetRecordById($this->request());
        if ($id !== null) {
            $request->id($id);
        }
        return $request;
    }

    /**
     * @return Request\InsertRecords
     */
    public function insertRecords()
    {
        return new Request\InsertRecords($this->request());
    }

    /**
     * @return Request\UpdateRecords
     */
    public function updateRecords()
    {
        return new Request\UpdateRecords($this->request());
    }


    /**
     * @return Request\UpdateRelatedRecords
     */
    public function updateRelatedRecords()
    {
        return new Request\UpdateRelatedRecords($this->request());
    }

    /**
     * @return Request\ConvertLead
     */
    public function convertLead()
    {
        return new Request\ConvertLead($this->request());
    }

    /**
     * @return Request\GetFields
     */
    public function getFields()
    {
        return new Request\GetFields($this->request());
    }

    /**
     * @return Request\DeleteRecords
     */
    public function deleteRecords()
    {
        return new Request\DeleteRecords($this->request());
    }

    /**
     * @return Request\UploadFile
     */
    public function uploadFile()
    {
        return new Request\UploadFile($this->request());
    }

    /**
     * @return Request\DeleteFile
     */
    public function deleteFile()
    {
        return new Request\DeleteFile($this->request());
    }

    /**
     * @return Request\DownloadFile
     */
    public function downloadFile()
    {
        return new Request\DownloadFile($this->request());
    }

    /**
     * @return Request\SearchRecords
     */
    public function searchRecords()
    {
        return new Request\SearchRecords($this->request());
    }

    /**
     * @return Request\GetSearchRecordsByPDC
     */
    public function getSearchRecordsByPDC()
    {
        return new Request\GetSearchRecordsByPDC($this->request());
    }

    /**
     * @return Request\GetRelatedRecords
     */
    public function getRelatedRecords()
    {
        return new Request\GetRelatedRecords($this->request());
    }

    /**
     * @return Request\GetDeletedRecordIds
     */
    public function getDeletedRecordIds()
    {
        return new Request\GetDeletedRecordIds($this->request());
    }
}
