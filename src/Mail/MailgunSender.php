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

    public function __construct(MailgunOptions $options)
    {
        $this->options = $options;
        $this->mg = new Mailgun($this->options->getApiKey());
    }

    public function send(MessageViewModel $message)
    {
        $domain = $this->options->getDomain();

        return $this->mg->post("{$domain}/messages", $message->getMessage(), $message->getFiles());
    }
}
