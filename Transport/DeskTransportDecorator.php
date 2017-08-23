<?php

namespace CristianPontes\ZohoCRMClient\Transport;
use CristianPontes\ZohoCRMClient\Exception\Exception;

/**
 * Class DeskTransportDecorator
 * @package CristianPontes\ZohoCRMClient\Transport
 */
class DeskTransportDecorator extends XmlDataTransportDecorator
{
    protected $portalName;
    protected $departmentName;

    /**
     * DeskTransportDecorator constructor.
     * @param Transport $portalName
     * @param $departmentName
     * @param Transport $transport
     * @throws Exception
     */
    public function __construct($portalName, $departmentName, Transport $transport)
    {
        if (!$portalName) {
            throw new Exception('Please provide a portal name');
        }

        if (!$departmentName) {
            throw new Exception('Please provide a department name');
        }

        $this->departmentName = $departmentName;
        $this->portalName = $portalName;

        parent::__construct($transport);
    }

    /**
     * @param string $module
     * @param string $method
     * @param array $paramList
     * @return string
     */
    public function call($module, $method, array $paramList)
    {
        $paramList['portal'] = $this->portalName;
        $paramList['department'] = $this->departmentName;
        return parent::call($module, $method, $paramList);
    }
}
