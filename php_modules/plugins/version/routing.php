<?php 

return [
    'versions'=>[
        'fnc' => [
            'get' => 'version.version.list',
            'post' => 'version.version.list',
            'put' => 'version.version.update',
            'delete' => 'version.version.delete'
        ],
    ],
    'version' => [
        'fnc' => [
            'get' => 'version.version.detail',
            'post' => 'version.version.add',
            'put' => 'version.version.update',
            'delete' => 'version.version.delete'
        ],
        'parameters' => ['id'],
    ],
    'version-notes' => [
        'fnc' => [
            'get' => 'version.note.list',
        ],
        'parameters' => ['version_id'],
    ],
    'version-feedback' => [
        'fnc' => [
            'get' => 'version.feedback.list',
            'post' => 'version.feedback.list',
        ],
        'parameters' => ['version_id'],
    ],
    'version-note' => [
        'fnc' => [
            'post' => 'version.note.add',
            'put' => 'version.note.update',
            'delete' => 'version.note.delete'
        ],
        'parameters' => ['version_id','id'],
    ],
];
