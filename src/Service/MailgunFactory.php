<?php
namespace MailgunZf2\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Mailgun\Mailgun;
use MailgunZf2\Options\MailgunOptions;

class MailgunFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if (! $serviceLocator->has('MailgunOptions')) {
            return;
        }

        $options = $serviceLocator->get('MailgunOptions');

        $options instanceof MailgunOptions;

        return new Mailgun(
            $options->getApiKey(),
            $options->getApiEndpoint(),
            $options->getApiVersion(),
            $options->getSsl()
        );
    }
}
