<?php
namespace MailgunZf2\Service;

use Interop\Container\ContainerInterface;
use Mailgun\Mailgun;
use MailgunZf2\Options\MailgunOptions;
use Zend\ServiceManager\Factory\FactoryInterface;

class MailgunFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $serviceLocator, $requestedName, array $options = null)
    {
        if (!$serviceLocator->has('MailgunOptions')) {
            return null;
        }

        /** @var MailgunOptions $options */

        $options = $serviceLocator->get('MailgunOptions');
        if (!$options instanceof MailgunOptions) {
            $options = new MailgunOptions();
        }

        return new Mailgun(
            $options->getApiKey(),
            $options->getApiEndpoint(),
            $options->getApiVersion(),
            $options->getSsl()
        );
    }
}
