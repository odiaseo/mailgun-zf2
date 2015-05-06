<?php
namespace MailgunZf2Test\View\Model;

use MailgunZf2\View\Model\MessageViewModel;

class MessageViewModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var MessageViewModel
     */
    private $message;

    const HTMLTEMPLATE = 'emails/html.phtml';
    const TEXTTEMPLATE = 'emails/text.phtml';
    const FIRSTNAME = 'Chump';
    const SUBJECT = 'Welcome to spam town';
    const FROM = "'Unit Test' <test@bittles.net>";

    protected function setUp()
    {
        parent::setUp();

        $this->message = new MessageViewModel(
            static::HTMLTEMPLATE,
            static::TEXTTEMPLATE,
            array(
                'firstName' => static::FIRSTNAME,
                'subject' => static::SUBJECT,
            )
        );

        $this->message->setFromAddress('test@bittles.net', array('first' => 'Unit', 'last' => 'Test'));
        $this->message->addToRecipient('recipient1@bittles.net', array('first' => 'Recipient', 'last' => 'One'));
        $this->message->addToRecipient('recipient2@bittles.net', array('first' => 'Recipient', 'last' => 'Two'));
    }

    public function testExists()
    {
        $model = new MessageViewModel();

        $this->assertInstanceOf('MailgunZf2\View\Model\MessageViewModel', $this->message);
    }

    public function testRootView()
    {
        $message = $this->message->getMessage();

        $this->assertArrayHasKey('subject', $message);
        $this->assertArrayHasKey('from', $message);
        $this->assertArrayHasKey('to', $message);

        $this->assertEquals(static::SUBJECT, $message['subject']);
        $this->assertEquals(static::FROM, $message['from'][0]);

        $to = $message['to'];

        $this->assertCount(2, $to);
        $this->assertEquals("'Recipient One' <recipient1@bittles.net>", $message['to'][0]);
        $this->assertEquals("'Recipient Two' <recipient2@bittles.net>", $message['to'][1]);
    }

    public function testHtmlTemplate()
    {
        $htmlTemplate = $this->message->getHtmlViewModel();

        $this->assertInstanceOf('Zend\View\Model\ModelInterface', $htmlTemplate);

        $firstName = $htmlTemplate->getVariable('firstName');
        $subject = $htmlTemplate->getVariable('subject');
        $template = $htmlTemplate->getTemplate();

        $this->assertEquals(static::FIRSTNAME, $firstName);
        $this->assertEquals(static::SUBJECT, $subject);
        $this->assertEquals(static::HTMLTEMPLATE, $template);
    }

    public function testTextTemplate()
    {
        $textTemplate = $this->message->getTextViewModel();

        $this->assertInstanceOf('Zend\View\Model\ModelInterface', $textTemplate);

        $firstName = $textTemplate->getVariable('firstName');
        $subject = $textTemplate->getVariable('subject');
        $template = $textTemplate->getTemplate();

        $this->assertEquals(static::FIRSTNAME, $firstName);
        $this->assertEquals(static::SUBJECT, $subject);
        $this->assertEquals(static::TEXTTEMPLATE, $template);
    }
}
