<?php

namespace CristianPontes\ZohoCRMClient\Client;

use Buzz\Browser;
use Buzz\Client\Curl;
use CristianPontes\ZohoCRMClient\Transport;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

/**
 * Main Class of the ZohoCRMClient library
 * Only use this class directly
 */
abstract class AbstractZohoClient implements LoggerAwareInterface
{
    /** @var string */
    protected $module;
    /** @var Transport\Transport */
    protected $transport;
    /** @var LoggerInterface */
    protected $logger;

    /**
     * ZohoCRMClient constructor.
     * @param $module
     * @param $authToken
     * @param string $domain
     * @param int $timeout
     */
    public function __construct($module, $authToken, $domain = 'com', $timeout = 5)
    {
        $this->module = $module;

        if ($authToken instanceof Transport\Transport) {
            $this->transport = $authToken;
        } else {
            $curl_client = new Curl();
            $curl_client->setTimeout($timeout);
            $this->transport = new Transport\XmlDataTransportDecorator(
                new Transport\AuthenticationTokenTransportDecorator(
                    $authToken,
                    new Transport\BuzzTransport(
                        new Browser($curl_client),
                        $this->apiUrl($domain)
                    )
                )
            );
        }
    }

    /**
     * Override this in your child classes.
     *
     * @param string $domain
     */
    abstract protected function apiUrl($domain = 'com');

    /**
     * Sets a logger instance on the object
     *
     * @param LoggerInterface $logger
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        if ($this->transport instanceof LoggerAwareInterface) {
            $this->transport->setLogger($logger);
        }
    }

    /**
     * @return \CristianPontes\ZohoCRMClient\Transport\TransportRequest
     */
    protected function request()
    {
        $request = new Transport\TransportRequest($this->module);
        $request->setTransport($this->transport);
        return $request;
    }
}
