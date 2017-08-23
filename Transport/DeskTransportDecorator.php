<?php

namespace CristianPontes\ZohoCRMClient\Transport;

/**
 * Class DeskTransportDecorator
 * @package CristianPontes\ZohoCRMClient\Transport
 */
class DeskTransportDecorator extends XmlDataTransportDecorator
{
    /**
     * DeskTransportDecorator constructor.
     * @param Transport $portalName
     * @param $departmentName
     * @param Transport $transport
     */
    public function __construct($portalName, $departmentName, Transport $transport)
    {

        parent::__construct($transport);
    }
}
