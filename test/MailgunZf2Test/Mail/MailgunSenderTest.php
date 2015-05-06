<?php
namespace MailgunZf2Test\Mail;

use MailgunZf2\Mail\MailgunSender;
use MailgunZf2\View\Model\MessageViewModel;
use MailgunZf2\View\Renderer\MessageRenderer;
use MailgunZf2Test\UnitTest;

class MailgunSenderTest extends UnitTest
{
    /**
     *
     * @var MailgunSender
     */
    private $sender;

    /**
     *
     * @var MessageRenderer
     */
    private $renderer;

    /**
     *
     * @var MessageViewModel
     */
    private $message;

    const HTMLTEMPLATE = 'emails/html.phtml';
    const TEXTTEMPLATE = 'emails/text.phtml';
    const FIRSTNAME = 'Chump';
    const SUBJECT = 'Welcome to spam town';

    protected function setUp()
    {
        parent::setUp();
        $this->sender = $this->sm->get('MailgunSender');

        $this->renderer = $this->sm->get('MailgunRenderer');

        $this->message = new MessageViewModel(
            static::HTMLTEMPLATE,
            static::TEXTTEMPLATE,
            array(
                'firstName' => static::FIRSTNAME,
                'subject' => static::SUBJECT,
            )
        );
    }

    public function testExists()
    {
        $this->assertInstanceOf('MailgunZf2\Mail\MailgunSender', $this->sender);
    }

    public function testSend()
    {
        $email = getenv('TEST_MAILGUNZF2_EMAIL');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        $this->renderer->render($this->message);

        $this->message->addToRecipient($email);
        $this->message->setFromAddress($email);

        $this->sender->send($this->message);
    }
}
