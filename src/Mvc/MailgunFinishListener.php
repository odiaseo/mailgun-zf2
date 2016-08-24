<?php
namespace MailgunZf2\Mvc;

use Interop\Container\ContainerInterface;
use MailgunZf2\Mail\MailgunSender;
use MailgunZf2\View\Model\MessageViewModel;
use MailgunZf2\View\Renderer\MessageRenderer;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\MvcEvent;

class MailgunFinishListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    const PARAM_MAILGUN = '__MAILGUN__';

    private $serviceLocator;

    public function __construct(ContainerInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @return mixed
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @param mixed $serviceLocator
     */
    public function setServiceLocator($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
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
            if (!$message instanceof MessageViewModel) {
                continue;
            }

            $renderer->render($message);
        }
    }

    public function send(MvcEvent $event)
    {
        $messages = $event->getParam(static::PARAM_MAILGUN, false);

        if (empty($messages)) {
            return;
        }

        /**
         * @var MailgunSender $sender
         */
        $sender = $this->serviceLocator->get('MailgunSender');

        $responses = array();
        foreach ($messages as $message) {
            if (!$message instanceof MessageViewModel) {
                continue;
            }

            try {
                $responses[] = $sender->send($message);
            } catch (\Exception $e) {
                $responses[] = $e;
            }
        }

        return $responses;
    }
}
