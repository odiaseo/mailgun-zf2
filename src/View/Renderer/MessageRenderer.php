<?php
namespace MailgunZf2\View\Renderer;

use MailgunZf2\View\Model\MessageViewModel;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Stdlib\Response;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Strategy\PhpRendererStrategy;
use Zend\View\View;

class MessageRenderer implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     *
     * @var View
     */
    private $view;

    public function render(MessageViewModel $message)
    {
        $view = $this->getView();
        $view->setResponse(new Response());

        $view->render($message);

        return $message->getMessage();
    }

    /**
     *
     * @return \Zend\View\View
     */
    public function getView()
    {
        if ($this->view) {
            return $this->view;
        }

        $helperManager = $this->serviceLocator->get('ViewHelperManager');
        $resolver = $this->serviceLocator->get('ViewResolver');

        $renderer = new PhpRenderer();
        $renderer->setHelperPluginManager($helperManager);
        $renderer->setResolver($resolver);

        $rendererStrategy = new PhpRendererStrategy($renderer);

        $this->view = new View();
        $this->view->setEventManager($this->serviceLocator->get('EventManager'));
        $this->view->getEventManager()->attach($rendererStrategy);

        return $this->view;
    }
}
