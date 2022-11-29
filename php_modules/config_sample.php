<?php  defined('APP_PATH') or die('Invalid config');

return [ 
    'sitepath' => '',
    'plugins' => ['user'],
    'theme' => 'sdm',
    'secrect' => 'sid',
    'endpoints' => [
    ],
    'defaultEndpoint' => [
        'fnc' => 'user.home.home'
    ],
    'db' => [
        'host' => '192.168.56.10',
        'username' => 'root',
        'passwd' => '123123',
        'database' => 'sdm',
        'prefix' => '',
        'options' => '',
        'debug' => true
    ],
];
