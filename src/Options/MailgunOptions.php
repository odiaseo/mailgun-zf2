<?php
namespace MailgunZf2\Options;

use Zend\Stdlib\AbstractOptions;

class MailgunOptions extends AbstractOptions
{

    private $apiKey;

    private $domain;

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;
    }
}
