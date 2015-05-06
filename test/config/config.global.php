<?php
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
);

return $config;
