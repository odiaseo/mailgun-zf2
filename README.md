# Mailgun ZF2 Module
[![Build Status](https://travis-ci.org/ebittleman/mailgun-zf2.svg?branch=master)](https://travis-ci.org/ebittleman/mailgun-zf2)
[![Build Status](https://img.shields.io/packagist/v/ebittleman/mailgun-zf2.svg)](https://packagist.org/packages/ebittleman/mailgun-zf2)

This is a super new library and no guarantees are made on anything. 
It pretty much just hooks 
[mailgun/mailgun-php](https://github.com/mailgun/mailgun-php) 
directly into Zend Framework 2 Have fun.

## Installation

    composer require ebittleman/mailgun-zf2

## Module Config

This module is pretty config light, just need to know your api key and
domain for Mailgun. BEWARE: do not commit your creds unencrypted to 
public repos!!!!

    return array(
        'mailgun' => array(
            'apiKey' => 'YOUR_MAILGUN_APIKEY',
            'domain' => 'YOUR_MAILGUN_DOMAIN',
        ),
    );

## Application Config

You will need to enable the module by adding it to your application config

    return array(
        'modules' => array(
            ...YOUR MODULES...,
            'MailgunZf2'
        ),
        'module_listener_options' => array(
            'config_glob_paths' => array(
                ...YOUR CONFIG PATHS...
            ),
            'module_paths' => array(
                ...YOUR MODULES PATHS...
            )
        )
    );

## Super Basic Usage

So the basic idea here is that the MessageViewModel is pretty much just an
view adapter wrapped around `Mailgun\MessagesMessageBuilder` and it gets passed
to a controller plugin that will prepare that message to be sent at ZF2's MvcEvent::EVENT_FINSH
event

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
            
            $message->addToRecipient('someemail@example.com');
            $message->setFromAddress('fromsomeone@example.com');
    
            $this->mailgun($message);
    
            return new ViewModel();
        }
    }

