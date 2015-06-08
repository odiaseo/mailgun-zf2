<?php
namespace MailgunZf2\Service;

use MailgunZf2\Mail\MailgunSender;
use MailgunZf2\Options\MailgunOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MailgunSenderFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = null;

        if ($serviceLocator->has('MailgunOptions')) {
            $options = $serviceLocator->get('MailgunOptions');
        }

        if (! $options instanceof MailgunOptions) {
            $options = new MailgunOptions();
        }

        $mg = $serviceLocator->get('Mailgun\Mailgun');

        return new MailgunSender($mg, $options);
    }
}
