<?php

//activa el report de errores
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
return[
    'db' => [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'name' => 'mercado_central',
        'options' => [
            PDO::ATTR_ERRMODE =>
            PDO::ERRMODE_EXCEPTION
        ]
    ]      
];
