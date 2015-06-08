<?php
namespace MailgunZf2\Options;

use Zend\Stdlib\AbstractOptions;

class MailgunOptions extends AbstractOptions
{

    private $apiKey;

    private $publicApiKey;

    private $domain;

    private $apiEndpoint = "api.mailgun.net";

    private $apiVersion = "v2";

    private $ssl = true;

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getPublicApiKey()
    {
        return $this->publicApiKey;
    }

    public function setPublicApiKey($pulicApiKey)
    {
        $this->publicApiKey = $pulicApiKey;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    public function getApiEndpoint()
    {
        return $this->apiEndpoint;
    }

    public function setApiEndpoint($apiEndpoint)
    {
        $this->apiEndpoint = $apiEndpoint;
    }

    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    public function setApiVersion($apiVersion)
    {
        $this->apiVersion = $apiVersion;
    }

    public function getSsl()
    {
        return $this->ssl;
    }

    public function setSsl($ssl)
    {
        $this->ssl = $ssl;
    }
}
