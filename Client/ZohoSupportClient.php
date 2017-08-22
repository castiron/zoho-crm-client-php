<?php

namespace CristianPontes\ZohoCRMClient\Client;

use CristianPontes\ZohoCRMClient\Request;

/**
 * Class ZohoSupportClient
 * @package CristianPontes\ZohoCRMClient\Client
 */
class ZohoSupportClient extends AbstractZohoClient
{
    /**
     * @param $domain
     * @return string
     */
    protected function apiUrl($domain = 'com')
    {
        return 'https://crm.zoho.' . $domain . '/crm/private/xml/';
    }
}
