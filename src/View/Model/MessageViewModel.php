<?php
namespace MailgunZf2\View\Model;

use Mailgun\Messages\MessageBuilder;
use Mailgun\Mailgun;
use Zend\View\Model\ViewModel;
use Zend\View\Model\ModelInterface;

/**
 * ViewModel Adapter for Mailgun\Messages\MessageBuilder
 *
 * @method mixed addToRecipient(string $address, array $variables = null)
 * @method mixed addCcRecipient(string $address, array $variables = null)
 * @method mixed addBccRecipient(string $address, array $variables = null)
 * @method string setFromAddress(string $address, array $variables = null)
 * @method string setReplyToAddress(string $address, array $variables = null)
 * @method string setSubject(string $subject = null)
 * @method string addCustomHeader(string $headerName, string $headerData)
 * @method string setTextBody(string $textBody)
 * @method string setHtmlBody(string $htmlBody)
 * @method boolean addAttachment(string $attachmentPath, string $attachmentName = null)
 * @method addInlineImage(string $inlineImagePath, string $inlineImageName = null)
 * @method string setTestMode(boolean $testMode)
 * @method string addCampaignId(string $campaignId)
 * @method string addTag(string $tag)
 * @method string setDkim(boolean $enabled)
 * @method string setOpenTracking(boolean $enabled)
 * @method string setClickTracking(boolean $enabled)
 * @method string setDeliveryTime($timeDate, $timeZone = null)
 * @method string addCustomData(string $customName, mixed $data)
 * @method string addCustomParameter(string $parameterName, mixed $data)
 * @method setMessage(string $message)
 * @method array getFiles()
 */
class MessageViewModel extends ViewModel
{

    const CAPTURETO_HTML = '__HTML__';

    const CAPTURETO_TEXT = '__TEXT__';

    const VAR_SUBJECT = 'subject';

    /**
     *
     * @var string
     */
    private $domain;

    /**
     *
     * @var MessageBuilder
     */
    private $mb;

    /**
     *
     * @var ModelInterface
     */
    private $htmlViewModel = null;

    /**
     *
     * @var ModelInterface
     */
    private $textViewModel = null;

    protected $template = 'blank';

    protected $errorMessage = '';

    /**
     *
     * @param null|array|\Traversable $variables
     * @param string $htmlTemplate
     * @param string $textTemplate
     */
    public function __construct($htmlTemplate = '', $textTemplate = '', $variables = array())
    {
        parent::__construct($variables);

        $this->mb = (new Mailgun())->MessageBuilder();

        if ($htmlTemplate !== '') {
            $htmlViewModel = new ViewModel($variables);
            $htmlViewModel->setTemplate($htmlTemplate);
            $this->setHtmlViewModel($htmlViewModel);
        }

        if ($textTemplate !== '') {
            $textViewModel = new ViewModel($variables);
            $textViewModel->setTemplate($textTemplate);
            $this->setTextViewModel($textViewModel);
        }

        $this->initFrom();
        $this->initTo();
        $this->initSubject();
        $this->initInlineFiles();
    }

    private function initFrom()
    {
        $email = $this->getVariable('fromEmail', '');

        if ($email === '') {
            return;
        }

        $this->setFromAddress(
            $email,
            array(
                'first' => $this->getVariable('fromFirst', ''),
                'last' => $this->getVariable('fromLast', '')
            )
        );
    }

    private function initTo()
    {
        $email = $this->getVariable('toEmail', '');

        if ($email === '') {
            return;
        }

        $this->addToRecipient(
            $email,
            array(
                'first' => $this->getVariable('toFirst', ''),
                'last' => $this->getVariable('toLast', '')
            )
        );
    }

    private function initSubject()
    {
        $subject = $this->getVariable(static::VAR_SUBJECT, '');

        if ($subject === '') {
            return;
        }

        if (is_array($subject)) {
            $args = array($subject['format']);
            foreach($subject['args'] as $name) {
                $args[] = $this->getVariable($name, '');
            }

            $subject = call_user_func_array('sprintf', $args);
        }

        $this->setSubject($subject);
    }

    private function initInlineFiles()
    {
        $files = $this->getVariable('inline', array());
        foreach ($files as $file) {
            $this->addInlineImage($file);
        }
    }

    public function isValid()
    {
        $this->errorMessage = '';

        $missing = array();

        if (empty($this->getVariable('fromEmail'))) {
            $missing[] = 'fromEmail';
        }

        if (empty($this->getVariable('toEmail'))) {
            $missing[] = 'toEmail';
        }

        if (empty($this->getVariable(static::VAR_SUBJECT))) {
            $missing[] = static::VAR_SUBJECT;
        }

        if (empty($missing)) {
            return true;
        }

        $this->errorMessage =
            'Missing Required Field(s): ' . implode(', ', $missing);

        return false;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function __call($method, $arguments)
    {
        $callback = array($this->mb, $method);

        if (! is_callable($callback)) {
            return;
        }

        return call_user_func_array($callback, $arguments);
    }

    public function getMessage()
    {
        return $this->getMessageBuilder()->getMessage();
    }

    /**
     *
     * @return \Zend\View\Model\ModelInterface
     */
    public function getHtmlViewModel()
    {
        return $this->htmlViewModel;
    }

    /**
     *
     * @param ModelInterface $htmlViewModel
     * @return \Zend\View\Model\ViewModel self
     */
    public function setHtmlViewModel(ModelInterface $htmlViewModel)
    {
        $this->htmlViewModel = $htmlViewModel;

        return $this->addChild($htmlViewModel, static::CAPTURETO_HTML);
    }

    /**
     *
     * @return \Zend\View\Model\ModelInterface
     */
    public function getTextViewModel()
    {
        return $this->textViewModel;
    }

    /**
     *
     * @param ModelInterface $textViewModel
     * @return \Zend\View\Model\ViewModel
     */
    public function setTextViewModel(ModelInterface $textViewModel)
    {
        $this->textViewModel = $textViewModel;

        return $this->addChild($textViewModel, static::CAPTURETO_TEXT);
    }

    /**
     *
     * @return \Mailgun\Messages\MessageBuilder
     */
    protected function getMessageBuilder()
    {
        $htmlBody = $this->getVariable(static::CAPTURETO_HTML, false);
        $textBody = $this->getVariable(static::CAPTURETO_TEXT, false);

        if ($htmlBody !== false) {
            $this->mb->setHtmlBody($htmlBody);
        }

        if ($textBody !== false) {
            $this->mb->setTextBody($textBody);
        }

        return $this->mb;
    }
}
