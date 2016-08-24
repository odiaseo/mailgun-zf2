<?php
namespace MailgunZf2\Mvc;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class MailgunFinishListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $serviceLocator, $requestedName, array $options = null)
    {
        return new MailgunFinishListener($serviceLocator);
    }
}
