<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace MailgunZf2;

use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $serviceManager = $e->getApplication()->getServiceManager();

        // lookup the listener
        $mgListener = $serviceManager->get('MailgunFinishListener');
        $mgListener->attach($eventManager);
    }

    public function getConfig()
    {
        return require __DIR__ . '/../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array();
    }
}
