<?php 

return [
    'admin' => [
        'login' => [
            'fnc' => [
                'get' => 'user.user.gate',
                'post' => 'user.user.login',
            ]
        ],
        'logout' =>'user.user.logout',

        // Endpoint User
        'users'=>[
            'fnc' => [
                'get' => 'user.user.list',
                'post' => 'user.user.list',
                'put' => 'user.user.update',
                'delete' => 'user.user.delete'
            ],
            'middleware' => [
                'permission' => [
                    'PermissionKey' => [
                        'get' => ['user_manager', 'user_read'],
                        'post' => ['user_manager', 'user_read'],
                        'put' => ['user_manager', 'user_update'],
                        'delete' => ['user_manager', 'user_delete'],
                    ],
                ]
            ],
        ],
        'user/0' => [
            'fnc' => [
                'get' => 'user.user.detail',
                'post' => 'user.user.add',
            ],
            'middleware' => [
                'permission' => [
                    'PermissionKey' => [
                        'get' => ['user_manager', 'user_create'],
                        'post' => ['user_manager', 'user_create'],
                    ],
                ]
            ],
            'parameters' => ['id'],
        ],
        'user' => [
            'fnc' => [
                'get' => 'user.user.detail',
                'put' => 'user.user.update',
                'delete' => 'user.user.delete'
            ],
            'parameters' => ['id'],
            'middleware' => [
                'permission' => [
                    'PermissionKey' => [
                        'get' => ['user_manager', 'user_update'],
                        'put' => ['user_manager', 'user_update'],
                        'delete' => ['user_manager', 'user_delete'],
                    ],
                ]
            ]
        ],
        'user-groups'=>[
            'fnc' => [
                'get' => 'user.usergroup.list',
                'post' => 'user.usergroup.list',
                'put' => 'user.usergroup.update',
                'delete' => 'user.usergroup.delete'
            ],
            'middleware' => [
                'permission' => [
                    'PermissionKey' => [
                        'get' => ['usergroup_manager', 'usergroup_read'],
                        'post' => ['usergroup_manager', 'usergroup_read'],
                        'put' => ['usergroup_manager', 'usergroup_update'],
                        'delete' => ['usergroup_manager', 'usergroup_delete'],
                    ],
                ]
            ],
        ],
        
        'user-group/0' => [
            'fnc' => [
                'get' => 'user.usergroup.detail',
                'post' => 'user.usergroup.add',
            ],
            'middleware' => [
                'permission' => [
                    'PermissionKey' => [
                        'get' => ['usergroup_manager', 'usergroup_create'],
                        'post' => ['usergroup_manager', 'usergroup_create'],
                    ],
                ]
            ],
            'parameters' => ['id'],
        ],
        'user-group' => [
            'fnc' => [
                'get' => 'user.usergroup.detail',
                'put' => 'user.usergroup.update',
                'delete' => 'user.usergroup.delete'
            ],
            'middleware' => [
                'permission' => [
                    'PermissionKey' => [
                        'get' => ['usergroup_manager', 'usergroup_update'],
                        'put' => ['usergroup_manager', 'usergroup_update'],
                        'delete' => ['usergroup_manager', 'usergroup_delete'],
                    ],
                ]
            ],
            'parameters' => ['id'],
        ],
    ],
];
