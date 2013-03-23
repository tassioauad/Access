<?php

return array(
    'db' => array(
        'driver' => 'Pdo',
        'dsn' => 'pgsql:dbname=access;host=127.0.0.1',
        'username' => 'postgres',
        'password' => 'root',
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
);