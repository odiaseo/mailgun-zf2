<?php
namespace MailgunZf2Test\View\Renderer;

use MailgunZf2Test\UnitTest;
use MailgunZf2\View\Renderer\MessageRenderer;
use MailgunZf2\View\Model\MessageViewModel;

class MessageRendererTest extends UnitTest
{
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
        $this->assertInstanceOf('MailgunZf2\View\Renderer\MessageRenderer', $this->renderer);
        $this->assertInstanceOf('Zend\ServiceManager\ServiceLocatorInterface', $this->renderer->getServiceLocator());
    }

    public function testRender()
    {
        $message = $this->renderer->render($this->message);

        $this->assertArrayHasKey('subject', $message);
        $this->assertArrayHasKey('html', $message);
        $this->assertArrayHasKey('text', $message);

        $this->assertEquals($this->expectedHtml, $message['html']);
        $this->assertEquals($this->expectedText, $message['text']);
    }

    private $expectedHtml = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Welcome to spam town</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body style="color: #9999ff;">
    <p>
        Dear Chump,
    </p>
    <p>
        Are you interested in some super spam?
    </p>
    <p>
        Sincerely,<br/>
        Bittles.net
    </p>
</body>
</html>

EOT;

    private $expectedText = <<<EOT
Dear Chump,

Are you interested in some super spam?

Sincerely,
Bittles.net

EOT;
}
