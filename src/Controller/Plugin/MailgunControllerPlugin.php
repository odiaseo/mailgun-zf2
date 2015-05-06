<?php
namespace MailgunZf2\Controller\Plugin;

use MailgunZf2\View\Model\MessageViewModel;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Mvc\Exception;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\InjectApplicationEventInterface;
use MailgunZf2\Mvc\MailgunFinishListener;

class MailgunControllerPlugin extends AbstractPlugin
{

    /**
     *
     * @var MvcEvent
     */
    private $event;

    public function __invoke(MessageViewModel $model)
    {
        $event = $this->getEvent();
        $messages = $event->getParam(MailgunFinishListener::PARAM_MAILGUN, array());

        $messages[] = $model;

        $event->setParam(MailgunFinishListener::PARAM_MAILGUN, $messages);

        return $this->getController();
    }

    /**
     * Get the event
     *
     * @return MvcEvent
     * @throws Exception\DomainException if unable to find event
     */
    protected function getEvent()
    {
        if ($this->event) {
            return $this->event;
        }

        $controller = $this->getController();
        if (! $controller instanceof InjectApplicationEventInterface) {
            throw new Exception\DomainException('Mailgun plugin requires a controller that implements InjectApplicationEventInterface');
        }

        $event = $controller->getEvent();
        if (! $event instanceof MvcEvent) {
            $params = $event->getParams();
            $event = new MvcEvent();
            $event->setParams($params);
        }
        $this->event = $event;

        return $this->event;
    }
}
