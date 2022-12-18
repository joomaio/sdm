<?php 

return [
    'admin' => [
        // '' => 'setting.home.home',
        'setting'=>[
            'fnc' => [
                'get' => 'setting.setting.form',
                'post' => 'setting.setting.save',
            ],
        ],
        'setting/mail-test'=>[
            'fnc' => [
                'post' => 'setting.setting.testMail',
            ],
        ],
        'setting/set_token_google'=>[
            'fnc' => [
                'get' => 'setting.setting.setTokenGoogle',
            ],
        ],
    ],
];
