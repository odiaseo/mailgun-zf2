<?php
namespace MailgunZf2\View\Renderer;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class MessageRendererFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $serviceLocator, $requestedName, array $options = null)
    {
        $messageRenderer = new MessageRenderer();
        $messageRenderer->setServiceLocator($serviceLocator);
        return $messageRenderer;
    }
}
