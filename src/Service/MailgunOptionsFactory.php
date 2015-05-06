<?php
namespace MailgunZf2\Service;

use MailgunZf2\Options\MailgunOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;

class MailgunOptionsFactory implements FactoryInterface
{
    private $default_options = array(
        'api_key' => '',
        'domain' => 'example.com'
    );

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $globalConfig = $serviceLocator->get('config');

        $options = $this->default_options;

        if (isset($globalConfig['mailgun']))
        {
            $options = ArrayUtils::merge($options, $globalConfig['mailgun']);
        }

        return new MailgunOptions($options);
    }
}
