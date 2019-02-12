<?php

use App\Container;

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../..');
$dotenv->load();

Container::bind('database', require __DIR__ . '/database/config.php');
