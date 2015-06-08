<?php
namespace MailgunZf2\Mail;

use Mailgun\Mailgun;
use MailgunZf2\Options\MailgunOptions;
use MailgunZf2\View\Model\MessageViewModel;

class MailgunSender
{
    /**
     *
     * @var MailgunOptions
     */
    private $options;

    /**
     *
     * @var Mailgun
     */
    private $mg;

    public function __construct(Mailgun $mg, MailgunOptions $options)
    {
        $this->mg = $mg;
        $this->options = $options;
    }

    public function send(MessageViewModel $message)
    {
        $domain = $this->options->getDomain();

        return $this->mg->post("{$domain}/messages", $message->getMessage(), $message->getFiles());
    }
}
