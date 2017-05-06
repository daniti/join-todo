<?php

require_once 'db/db-config.php';
return [
    'paths' => [
        'migrations' => 'db/migrations',
        'seeds' => 'db/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_database' => 'dev',
        'production' => [
            'adapter' => DB_DRIV,
            'host' => DB_HOST,
            'name' => DB_NAME,
            'user' => DB_USER,
            'pass' => DB_PASS,
            'port' => DB_PORT,
            'charset' => DB_CHAR,
        ],
        'dev' => [
            'adapter' => DB_DRIV,
            'host' => DB_HOST,
            'name' => DB_NAME,
            'user' => DB_USER,
            'pass' => DB_PASS,
            'port' => DB_PORT,
            'charset' => DB_CHAR,
        ],
        'version_order' => 'creation',
    ],
];
