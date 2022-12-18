<?php 

return [
    // Endpoint Milestones
    'milestones'=>[
        'fnc' => [
            'get' => 'milestone.milestone.list',
            'post' => 'milestone.milestone.list',
            'put' => 'milestone.milestone.update',
            'delete' => 'milestone.milestone.delete'
        ],
    ],
    'requests' => [
        'fnc' => [
            'get' => 'milestone.request.list',
            'post' => 'milestone.request.list',
            'put' => 'milestone.request.update',
            'delete' => 'milestone.request.delete'
        ],
        'parameters' => ['milestone_id'],
    ],
    'request' => [
        'fnc' => [
            'get' => 'milestone.request.detail',
            'post' => 'milestone.request.add',
            'put' => 'milestone.request.update',
            'delete' => 'milestone.request.delete'
        ],
        'parameters' => ['milestone_id','id'],
    ],
    'tasks' => [
        'fnc' => [
            'put' => 'milestone.task.update',
            'delete' => 'milestone.task.delete'
        ],
        'parameters' => ['request_id'],
    ],
    'task' => [
        'fnc' => [
            'get' => 'milestone.task.detail',
            'post' => 'milestone.task.add',
            'put' => 'milestone.task.update',
            'delete' => 'milestone.task.delete'
        ],
        'parameters' => ['request_id', 'id'],
    ],
    'relate-notes' => [
        'fnc' => [
            'put' => 'milestone.note.update',
            'delete' => 'milestone.note.delete'
        ],
        'parameters' => ['request_id'],
    ],
    'detail-request' => [
        'fnc' => [
            'get' => 'milestone.request.detail_request',
        ],
        'parameters' => ['request_id'],
    ],
    'document' => [
        'fnc' => [
            'post' => 'milestone.document.add',
            'put' => 'milestone.document.update',
        ],
        'parameters' => ['request_id'],
    ],
    'discussion' => [
        'fnc' => [
            'post' => 'milestone.discussion.add',
        ],
        'parameters' => ['request_id'],
    ],
    'relate-note' => [
        'fnc' => [
            'get' => 'milestone.note.detail',
            'post' => 'milestone.note.add',
            'put' => 'milestone.note.update',
            'delete' => 'milestone.note.delete'
        ],
        'parameters' => ['request_id', 'id'],
    ],
    'milestone' => [
        'fnc' => [
            'get' => 'milestone.milestone.detail',
            'post' => 'milestone.milestone.add',
            'put' => 'milestone.milestone.update',
            'delete' => 'milestone.milestone.delete'
        ],
        'parameters' => ['id'],
    ],
    'request-version' => [
        'fnc' => [
            'post' => 'milestone.version.add',
            'put' => 'milestone.version.update',
            'delete' => 'milestone.version.delete',
        ],
        'parameters' => ['request_id', 'id'],
    ],
];
