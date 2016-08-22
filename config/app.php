<?php

return [
    'env' => [
        'local'      => [
            'database' => [
                'driver'    => 'mysql',
                'host'      => 'localhost',
                'port'      => '3306',
                'database'  => null,
                'username'  => null,
                'password'  => null,
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
                'strict'    => false,
                'engine'    => null,
            ],

        ],
        'production' => [
            'database' => [
                'driver'    => 'mysql',
                'host'      => 'localhost',
                'port'      => '3306',
                'database'  => null,
                'username'  => null,
                'password'  => null,
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
                'strict'    => false,
                'engine'    => null,
            ],
        ]
    ]
];