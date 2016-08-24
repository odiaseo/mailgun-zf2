<?php
namespace MailgunZf2\Service;

use Interop\Container\ContainerInterface;
use MailgunZf2\Options\MailgunOptions;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Stdlib\ArrayUtils;

class MailgunOptionsFactory implements FactoryInterface
{
    private $default_options = array(
        'apiKey'       => '',
        'publicApiKey' => '',
        'domain'       => 'example.com',

        // optional defaults
        'apiEndpoint'  => 'api.mailgun.net',
        'apiVersion'   => 'v2',
        'ssl'          => true,
    );

    public function __invoke(ContainerInterface $serviceLocator, $requestedName, array $options = null)
    {
        $globalConfig = $serviceLocator->get('config');

        $options = $this->default_options;

        if (isset($globalConfig['mailgun'])) {
            $options = ArrayUtils::merge($options, $globalConfig['mailgun']);
        }

        return new MailgunOptions($options);
    }
}
