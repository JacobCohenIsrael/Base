<?php
return [
    'servicemanager' => [
        'factory' => [
        ],
        'invokable' => [
            'HttpSession' => 'JCI\\Base\\Http\\HttpSession'
        ]
    ],

    'routes' => [
        '/' => [
            'controller'    => 'JCI\\Example\\Main\\MainController',
            'action'        => 'main',
            'di'            => [],
        ],
    ],

    'dbs' => [
    ]
];