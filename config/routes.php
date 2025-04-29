<?php

return [
    '' => [
        'controller' => 'PostController',
        'action' => 'index',
        'params' => [],
        'middleware' => ['Guest'],
    ],

    '/post' => [
        'controller' => 'PostController',
        'action' => 'index',
        'params' => [],
        'middleware' => ['Guest']
    ],

    '/post/create' => [
        'controller' => 'PostController',
        'action' => 'create',
        'params' => [],
        'middleware' => ['Auth']
    ],

    '/post/edit/(\d+)' => [
        'controller' => 'PostController',
        'action' => 'edit',
        'params' => [
            0 => 1
        ],
        'middleware' => ['Auth']
    ],

    '/post/delete/(\d+)' => [
        'controller' => 'PostController',
        'action' => 'delete',
        'params' => [
            0 => 1
        ],
        'middleware' => ['Auth']
    ],

    '/post/(\d+)' => [
        'controller' => 'PostController',
        'action' => 'index',
        'params' => [
            0 => null, 
            1 => 1     
        ],
        'middleware' => ['Guest']
    ],

    '/post/module/(\d+)' => [
        'controller' => 'PostController',
        'action' => 'index',
        'params' => [
            0 => 1,   
            1 => null 
        ],
        'middleware' => ['Guest']
    ],

    '/vote' => [
        'controller' => 'VoteController',
        'action' => 'index',
        'params' => [],
        'middleware' => ['Auth']
    ],

    '/vote/status/(\d+)' => [
        'controller' => 'VoteController',
        'action' => 'status',
        'params' => [
            0 => 1
        ],
        'middleware' => ['Guest']
    ],

    '/contact' => [
        'controller' => 'ContactController',
        'action' => 'index',
        'params' => [],
        'middleware' => ['Auth', 'Student']
    ],

    '/logout' => [
        'controller' => 'AuthController',
        'action' => 'logout',
        'params' => [],
        'middleware' => ['Auth']
    ],

    '/login' => [
        'controller' => 'AuthController',
        'action' => 'login',
        'params' => [],
        'middleware' => ['Guest']
    ],

    '/signup' => [
        'controller' => 'AuthController',
        'action' => 'signup',
        'params' => [],
        'middleware' => ['Guest']
    ],

    '/module' => [
        'controller' => 'ModuleController',
        'action' => 'index',
        'params' => [],
        'middleware' => ['Auth', 'Admin']
    ],

    '/module/add' => [
        'controller' => 'ModuleController',
        'action' => 'add',
        'params' => [],
        'middleware' => ['Auth', 'Admin']
    ],

    '/module/edit/(\d+)' => [
        'controller' => 'ModuleController',
        'action' => 'edit',
        'params' => [
            0 => 1
        ],
        'middleware' => ['Auth', 'Admin']
    ],

    '/module/delete/(\d+)' => [
        'controller' => 'ModuleController',
        'action' => 'delete',
        'params' => [
            0 => 1
        ],
        'middleware' => ['Auth', 'Admin']
    ],

    '/user' => [
        'controller' => 'UserController',
        'action' => 'index',
        'params' => [],
        'middleware' => ['Auth', 'Admin']
    ],

    '/user/add' => [
        'controller' => 'UserController',
        'action' => 'add',
        'params' => [],
        'middleware' => ['Auth', 'Admin']
    ],

    '/user/edit/username/(\d+)' => [
        'controller' => 'UserController',
        'action' => 'editUsername',
        'params' => [
            0 => 1
        ],
        'middleware' => ['Auth', 'Admin']
    ],

    '/user/edit/email/(\d+)' => [
        'controller' => 'UserController',
        'action' => 'editEmail',
        'params' => [
            0 => 1
        ],
        'middleware' => ['Auth', 'Admin']
    ],

    'user/delete/(\d+)' => [
        'controller' => 'UserController',
        'action' => 'delete',
        'params' => [
            0 => 1
        ],
        'middleware' => ['Auth', 'Admin']
    ],

    '/comment' => [
        'controller' => 'CommentController',
        'action' => 'add',
        'params' => [],
        'middleware' => ['Auth']
    ],

    '/comment/edit' => [
        'controller' => 'CommentController',
        'action' => 'edit',
        'params' => [
            0 => 1
        ],
        'middleware' => ['Auth']
    ],

    '/comment/delete/(\d+)' => [
        'controller' => 'CommentController',
        'action' => 'delete',
        'params' => [
            0 => 1
        ],
        'middleware' => ['Auth']
    ],

    '/profile' => [
        'controller' => 'ProfileController',
        'action' => 'index',
        'params' => [],
        'middleware' => ['Auth']
    ],
];