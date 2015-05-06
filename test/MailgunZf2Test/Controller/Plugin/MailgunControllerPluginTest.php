<?php
namespace MailgunZf2Test\Controller\Plugin;

use MailgunZf2\Controller\IndexController;
use MailgunZf2Test\UnitTest;
use Zend\Stdlib\Request;
use Zend\Mvc\Router\RouteMatch;
use MailgunZf2\Mvc\MailgunFinishListener;

class MailgunControllerPluginTest extends UnitTest
{
    /**
     *
     * @var IndexController
     */
    private $controller;

    protected function setUp()
    {
        parent::setUp();

        $cm = $this->sm->get('ControllerManager');
        $this->controller = $cm->get('MailgunZf2\Controller\Index');

        $event = $this->controller->getEvent();

        $matches = new RouteMatch(array(
            'action' => 'index',
        ));
        $event->setRouteMatch($matches);
    }

    public function testExists()
    {
        $this->assertInstanceOf('MailgunZf2\Controller\IndexController', $this->controller);
    }

    public function testDispatch()
    {
        $request = new Request();
        $this->controller->dispatch($request);

        $event = $this->controller->getEvent();

        $params = $event->getParams();

        $this->assertArrayHasKey(MailgunFinishListener::PARAM_MAILGUN, $params);
        $this->assertCount(1, $params[MailgunFinishListener::PARAM_MAILGUN]);

        $message = $params[MailgunFinishListener::PARAM_MAILGUN][0];

        $this->assertInstanceOf('MailgunZf2\View\Model\MessageViewModel', $message);
    }
}
