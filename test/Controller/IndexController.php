<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace MailgunZf2\Controller;

use MailgunZf2\View\Model\MessageViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    const HTMLTEMPLATE = 'emails/html.phtml';

    const TEXTTEMPLATE = 'emails/text.phtml';

    const FIRSTNAME = 'Chump';

    const SUBJECT = 'Welcome to spam town';

    public function indexAction()
    {
        $message = new MessageViewModel(
            static::HTMLTEMPLATE,
            static::TEXTTEMPLATE,
            array(
                'firstName' => 'Bob',
                'subject' => 'Howdy There Bob'
            )
        );

        $this->mailgun($message);

        return new ViewModel();
    }
}
