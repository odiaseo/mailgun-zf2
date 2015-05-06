<?php
namespace MailgunZf2Test\Mvc;

use MailgunZf2Test\UnitTest;
use MailgunZf2\Mvc\MailgunFinishListener;
use MailgunZf2\View\Model\MessageViewModel;
use Zend\Mvc\MvcEvent;

class MailgunFinishListenerTest extends UnitTest
{

    /**
     *
     * @var MailgunFinishListener
     */
    private $listener;

    const HTMLTEMPLATE = 'emails/html.phtml';

    const TEXTTEMPLATE = 'emails/text.phtml';

    const FIRSTNAME = 'Chump';

    const SUBJECT = 'Welcome to spam town';

    protected function setUp()
    {
        parent::setUp();

        $this->listener = $this->sm->get('MailgunFinishListener');
    }

    public function testExists()
    {
        $this->assertInstanceOf('MailgunZf2\Mvc\MailgunFinishListener', $this->listener);
        $this->assertInstanceOf('Zend\ServiceManager\ServiceLocatorInterface', $this->listener->getServiceLocator());
    }

    public function testRender()
    {
        $views = $this->views();

        $event = new MvcEvent();

        $event->setParam(MailgunFinishListener::PARAM_MAILGUN, $views);

        $this->listener->render($event);

        $this->messageAssertions($views[0]->getMessage());
        $this->messageAssertions($views[1]->getMessage());
    }

    public function testSend()
    {
        $email = getenv('TEST_MAILGUNZF2_EMAIL');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        $views = $this->views();

        foreach($views as $message) {
            $message->addToRecipient($email);
            $message->setFromAddress($email);
        }

        $event = new MvcEvent();

        $event->setParam(MailgunFinishListener::PARAM_MAILGUN, $views);

        $this->listener->render($event);
        $reponses = $this->listener->send($event);

        $this->messageAssertions($views[0]->getMessage());
        $this->messageAssertions($views[1]->getMessage());

        $this->assertCount(2, $reponses);
        foreach($reponses as $reponse) {
            $this->responseAssertions($reponse);
        }

    }

    protected function responseAssertions($reponse)
    {
        $this->assertNotInstanceOf('Exception', $reponse);
        $this->assertInstanceOf('stdClass', $reponse);

        $this->assertObjectHasAttribute('http_response_code', $reponse);
        $this->assertEquals(200, $reponse->http_response_code);

    }

    protected function messageAssertions($message)
    {
        $this->assertArrayHasKey('subject', $message);
        $this->assertArrayHasKey('html', $message);
        $this->assertArrayHasKey('text', $message);

        $this->assertNotEmpty($message['subject']);
        $this->assertNotEmpty($message['html']);
        $this->assertNotEmpty($message['text']);
    }

    private function views()
    {
        return array(
            new MessageViewModel(
                static::HTMLTEMPLATE,
                static::TEXTTEMPLATE,
                array(
                    'firstName' => 'Bob',
                    'subject' => 'Howdy There Bob'
                )
            ),
            new MessageViewModel(
                static::HTMLTEMPLATE,
                static::TEXTTEMPLATE,
                array(
                    'firstName' => 'Joe',
                    'subject' => 'Howdy There Joe'
                )
            )
        );
    }
}
