<?php 

return [
    'home' => [
        'fnc' => 'user.home.home',
    ],
    'admin' => [
        'users'=>[
            'fnc' => [
                'get' => 'user.user.list',
                'post' => 'user.user.list',
                'delete' => 'user.user.delete'
            ],
        ],
        'user' => [
            'fnc' => [
                'get' => 'user.user.detail',
                'post' => 'user.user.add',
                'put' => 'user.user.update',
                'delete' => 'user.user.delete'
            ],
            'parameters' => ['id'],
        ],
        
        'login' => [
            'fnc' => [
                'get' => 'user.admin.gate',
                'post' => 'user.admin.login',
            ]
        ],
        'logout' => 'user.admin.logout',
    ],
];
