<?php

namespace CristianPontes\ZohoCRMClient\Transport;

use CristianPontes\ZohoCRMClient\Request\ConvertLead;
use SimpleXMLElement;

/**
 * Class CrmDataTransportDecorator
 * @package CristianPontes\ZohoCRMClient\Transport
 */
class CrmTransportDecorator extends XmlDataTransportDecorator
{
    /**
     * @param $paramList
     * @return string
     */
    protected function encodeRequest($paramList)
    {
        if ($this->method == 'convertLead') {
            return $this->encodeRequestConvertLead($paramList);
        }

        return parent::encodeRequest($paramList);
    }

    /**
     * @param array $paramList
     * @return string XML representation of the records
     */
    protected function encodeRequestConvertLead(array $paramList)
    {
        $root = new SimpleXMLElement('<Potentials></Potentials>');
        $options = array();

        // row 1 (options)
        foreach (ConvertLead::getOptionFields() as $optionName) {
            if (isset($paramList[$optionName])) {
                $options[$optionName] = $paramList[$optionName];
            }
        }
        $row = $root->addChild('row');
        $row->addAttribute('no', 1);
        $this->encodeRecord($options, 'option', $row);

        // row 2 (data)
        if (array_key_exists('xmlData', $paramList)) {
            $record = $paramList['xmlData'];
            if ($record) {
                $row = $root->addChild('row');
                $row->addAttribute('no', 2);
                $this->encodeRecord($record, 'FL', $row);
            }
        }
        return $root->asXML();
    }
}
