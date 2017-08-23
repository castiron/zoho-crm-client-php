<?php

namespace CristianPontes\ZohoCRMClient\Client;

use Buzz\Browser;
use CristianPontes\ZohoCRMClient\Exception\Exception;
use CristianPontes\ZohoCRMClient\Request;
use CristianPontes\ZohoCRMClient\Transport;

/**
 * Class ZohoDeskClient
 * @package CristianPontes\ZohoCRMClient\Client
 */
class ZohoDeskClient extends AbstractZohoClient
{

    /**
     * @var string
     */
    protected $portalName;

    /**
     * @var arrayh
     */
    protected $allowedModules = array(
        'requests',
        'solutions',
        'accounts',
        'contacts',
        'contracts',
        'products',
        'tasks',
    );

    /**
     * @var string
     */
    protected $departmentName;

    /**
     * ZohoDeskClient constructor.
     * @param array $options
     * @option string $module
     * @option string $authToken
     * @option string $portalName
     * @option string $departmentName
     * @option string $domain Must be 'com' for now
     * @option int $timeout
     * @throws Exception
     */
    public function __construct($options = [])
    {
        $this->validateOptions($options);

        $this->portalName = $options['portalName'];
        $this->departmentName = $options['departmentName'];

        parent::__construct($options);
    }

    /**
     * @param $domain
     * @return string
     */
    protected function apiUrl($domain = 'com')
    {
        return 'https://desk.zoho.' . $domain . '/api/xml/';
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
        return new Transport\DeskTransportDecorator($this->portalName, $this->departmentName, $transport);
    }

    /**
     * Constructor parameters required by this subclass (you don't need to specify the ones needed by the parent class)
     * @return array
     */
    protected function requiredOptions() {
        return array(
            'portalName',
            'departmentName',
        );
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
     * @return Request\SearchRecords
     */
    public function searchRecords()
    {
        return new Request\SearchRecords($this->request());
    }

    /**
     * TODO: Implement addRecords
     */
    public function addRecords() {

    }

    /**
     * TODO: Implement updateRecords
     * NB: This needs to be different than the CRM analogue, because the API interface is different; it assumes
     *     you are updating only a single record at a time.
     */
    public function updateRecords()
    {

    }

    /**
     * @return Request\DeleteRecords
     */
    public function deleteRecords()
    {
        return new Request\DeleteRecords($this->request());
    }
}
