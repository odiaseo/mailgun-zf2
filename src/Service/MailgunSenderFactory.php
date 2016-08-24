<?php
namespace MailgunZf2\Service;

use Interop\Container\ContainerInterface;
use MailgunZf2\Mail\MailgunSender;
use MailgunZf2\Options\MailgunOptions;
use Zend\ServiceManager\FActory\FactoryInterface;

class MailgunSenderFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $serviceLocator, $requestedName, array $options = null)
    {
        $options = null;

        if ($serviceLocator->has('MailgunOptions')) {
            $options = $serviceLocator->get('MailgunOptions');
        }

        if (!$options instanceof MailgunOptions) {
            $options = new MailgunOptions();
        }

        $mg = $serviceLocator->get('Mailgun\Mailgun');

        return new MailgunSender($mg, $options);
    }
}
