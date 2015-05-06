<?php
namespace MailgunZf2\Controller\Plugin;

use MailgunZf2\View\Model\MessageViewModel;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class MailgunControllerPlugin extends AbstractPlugin
{
    public function __invoke(MessageViewModel $model)
    {

    }
}
