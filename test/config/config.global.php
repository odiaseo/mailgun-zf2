<?php
require_once __DIR__ . '/../Controller/IndexController.php';

$config = array(
    'view_manager' => array(
        'template_map' => array(
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),

    'mailgun' => array(
        'apiKey' => getenv('TEST_MAILGUNZF2_APIKEY'),
        'domain' => getenv('TEST_MAILGUNZF2_DOMAIN'),
    ),

    'controllers' => array(
        'invokables' => array(
            'MailgunZf2\Controller\Index' => 'MailgunZf2\Controller\IndexController'
        ),
    ),
);

return $config;
