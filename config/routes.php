<?php

return [
    '' => [
        'controller' => 'PostController',
        'action' => 'index',
        'params' => []
    ],

    '/post' => [
        'controller' => 'PostController',
        'action' => 'index',
        'params' => []
    ],

    '/post/create' => [
        'controller' => 'PostController',
        'action' => 'create',
        'params' => []
    ],

    '/post/edit/(\d+)' => [
        'controller' => 'PostController',
        'action' => 'edit',
        'params' => [
            0 => 1
        ]
    ],

    '/post/delete/(\d+)' => [
        'controller' => 'PostController',
        'action' => 'delete',
        'params' => [
            0 => 1
        ]
    ],

    '/post/(\d+)' => [
        'controller' => 'PostController',
        'action' => 'index',
        'params' => [
            0 => null, 
            1 => 1     
        ]
    ],

    '/post/module/(\d+)' => [
        'controller' => 'PostController',
        'action' => 'index',
        'params' => [
            0 => 1,   
            1 => null 
        ]
    ],

    '/vote' => [
        'controller' => 'VoteController',
        'action' => 'index',
        'params' => []
    ],

    '/vote/status/(\d+)' => [
        'controller' => 'VoteController',
        'action' => 'status',
        'params' => [
            0 => 1
        ]
    ],

    '/contact' => [
        'controller' => 'ContactController',
        'action' => 'index',
        'params' => []
    ],

    '/logout' => [
        'controller' => 'AuthController',
        'action' => 'logout',
        'params' => []
    ],

    '/login' => [
        'controller' => 'AuthController',
        'action' => 'login',
        'params' => []
    ],

    '/signup' => [
        'controller' => 'AuthController',
        'action' => 'signup',
        'params' => []
    ],

    '/module' => [
        'controller' => 'ModuleController',
        'action' => 'index',
        'params' => []
    ],

    '/module/add' => [
        'controller' => 'ModuleController',
        'action' => 'add',
        'params' => []
    ],

    '/module/edit/(\d+)' => [
        'controller' => 'ModuleController',
        'action' => 'edit',
        'params' => [
            0 => 1
        ]
    ],

    '/module/delete/(\d+)' => [
        'controller' => 'ModuleController',
        'action' => 'delete',
        'params' => [
            0 => 1
        ]
    ],

    '/user' => [
        'controller' => 'UserController',
        'action' => 'index',
        'params' => []
    ],

    '/user/add' => [
        'controller' => 'UserController',
        'action' => 'add',
        'params' => []
    ],

    '/user/edit/username/(\d+)' => [
        'controller' => 'UserController',
        'action' => 'editUsername',
        'params' => [
            0 => 1
        ]
    ],

    '/user/edit/email/(\d+)' => [
        'controller' => 'UserController',
        'action' => 'editEmail',
        'params' => [
            0 => 1
        ]
    ],

    'user/delete/(\d+)' => [
        'controller' => 'UserController',
        'action' => 'delete',
        'params' => [
            0 => 1
        ]
    ],

    '/comment' => [
        'controller' => 'CommentController',
        'action' => 'add',
        'params' => []
    ],

    '/comment/edit' => [
        'controller' => 'CommentController',
        'action' => 'edit',
        'params' => [
            0 => 1
        ]
    ],

    '/comment/delete/(\d+)' => [
        'controller' => 'CommentController',
        'action' => 'delete',
        'params' => [
            0 => 1
        ]
    ],

    '/profile' => [
        'controller' => 'ProfileController',
        'action' => 'index',
        'params' => []
    ],
];