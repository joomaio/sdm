<?php 

return [
    'notes' => [
        'fnc' => [
            'get' => 'note.note.list',
            'post' => 'note.note.list',
            'put' => 'note.note.update',
            'delete' => 'note.note.delete'
        ]
    ],
    'attachment' => [
        'fnc' => [
            'delete' => 'note.attachment.delete'
        ],
        'parameters' => ['id'],
    ],
    'download/attachment' => [
        'fnc' => [
            'delete' => 'note.attachment.download'
        ],
        'parameters' => ['id'],
    ],
    'note' => [
        'fnc' => [
            'get' => 'note.note.detail',
            'post' => 'note.note.add',
            'put' => 'note.note.update',
            'delete' => 'note.note.delete'
        ],
        'parameters' => ['id'],
    ],
    'tag' => [
        'fnc' => [
            'get' => 'note.tag.list',
            'post' => 'note.tag.add',
        ]
    ],
];
