<?php

namespace CristianPontes\ZohoCRMClient\Client;

use Buzz\Browser;
use Buzz\Client\Curl;
use CristianPontes\ZohoCRMClient\Exception\Exception;
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
     * @param $options
     * @option $module
     * @option $authToken
     * @option string $domain
     * @option int $timeout
     */
    public function __construct($options = [])
    {
        $this->validateOptions($options);

        $this->module = $options['module'];

        if ($options['transport'] instanceof Transport\Transport) {
            $this->transport = $options['transport'];
        } else {
            $browser = $this->initBrowser(
                $options['timeout'] ?: 5
            );
            $this->transport = $this->initTransport(
                $options['authToken'],
                $options['domain'] ?: 'com',
                $browser
            );
        }
    }

    /**
     * @return array
     */
    protected function requiredOptions() {
        return array(
            'module',
        );
    }

    /**
     * @param $options
     * @throws Exception
     */
    protected function validateOptions($options) {
        if (!$options['authToken'] && !$options['transport']) {
            throw new Exception('You must provide either a transport or authToken parameter');
        }
        foreach ($this->requiredOptions() as $option) {
            if (!$options[$option]) {
                throw new Exception('You must provide the ' . $option . ' parameter');
            }
        }
    }

    /**
     * Override this in your child classes.
     *
     * @param string $domain
     */
    abstract protected function apiUrl($domain = 'com');

    /**
     * @param $timeout
     * @return Browser
     */
    protected function initBrowser($timeout)
    {
        $curl_client = new Curl();
        $curl_client->setTimeout($timeout);
        return new Browser($curl_client);
    }

    /**
     * Sets the Zoho CRM module, overriding the the actual value
     * @param $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @param $authToken
     * @param $domain
     * @param Browser $browser
     * @return Transport\Transport
     */
    protected function initTransport($authToken, $domain, Browser $browser)
    {
        return new Transport\AuthenticationTokenTransportDecorator(
            $authToken,
            new Transport\BuzzTransport(
                $browser,
                $this->apiUrl($domain)
            )
        );
    }

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
