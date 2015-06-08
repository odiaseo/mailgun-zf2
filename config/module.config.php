<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'mailgun' => array(
        'apiKey' => 'YOUR_API_KEY',
        'publicApiKey' => 'YOUR_API_KEY',
        'domain' => 'YOUR_DOMAIN',

        // optional, defaults
        'apiEndpoint' => 'api.mailgun.net',
        'apiVersion' => 'v2',
        'ssl' => true,
    ),

    'service_manager' => array(
        'invokables' => array(
            'MailgunZf2\View\Renderer\MessageRenderer' => 'MailgunZf2\View\Renderer\MessageRenderer',
            'MailgunZf2\Mvc\MailgunFinishListener'     => 'MailgunZf2\Mvc\MailgunFinishListener',
        ),
        'factories' => array(
            'MailgunZf2\Options\MailgunOptions' => 'MailgunZf2\Service\MailgunOptionsFactory',
            'MailgunZf2\Mail\MailgunSender'     => 'MailgunZf2\Service\MailgunSenderFactory',
            'Mailgun\Mailgun'                   => 'MailgunZf2\Service\MailgunFactory',
        ),
        'aliases' => array(
            'MailgunRenderer'       => 'MailgunZf2\View\Renderer\MessageRenderer',
            'MailgunFinishListener' => 'MailgunZf2\Mvc\MailgunFinishListener',
            'MailgunOptions'        => 'MailgunZf2\Options\MailgunOptions',
            'MailgunSender'         => 'MailgunZf2\Mail\MailgunSender',
        ),
    ),

    'controller_plugins' => array(
        'invokables' => array(
            'mailgun' => 'MailgunZf2\Controller\Plugin\MailgunControllerPlugin',
        )
    ),

    'view_manager' => array(
        'template_map' => array(
            'mailgun/blank'           => __DIR__ . '/../view/blank.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
