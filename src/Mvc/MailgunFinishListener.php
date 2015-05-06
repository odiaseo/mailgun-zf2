<?php
namespace MailgunZf2\Mvc;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use MailgunZf2\View\Renderer\MessageRenderer;
use MailgunZf2\View\Model\MessageViewModel;

class MailgunFinishListener implements ListenerAggregateInterface, ServiceLocatorAwareInterface
{
    use ListenerAggregateTrait;
    use ServiceLocatorAwareTrait;

    const PARAM_MAILGUN = '__MAILGUN__';

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_FINISH, array($this, 'render'), 100);
        $this->listeners[] = $events->attach(MvcEvent::EVENT_FINISH, array($this, 'send'), 100);
    }

    public function render(MvcEvent $event)
    {
        $messages = $event->getParam(static::PARAM_MAILGUN, false);

        if (empty($messages)) {
            return;
        }

        /**
         * @var MessageRenderer $renderer
         */
        $renderer = $this->serviceLocator->get('MailgunRenderer');

        foreach ($messages as $message) {
            if (! $message instanceof MessageViewModel) {
                continue;
            }

            $renderer->render($message);
        }
    }

    public function send(MvcEvent $event)
    {}
}
