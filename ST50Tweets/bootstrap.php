<?php

use ST50Tweets\Container;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// $dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
// $dotenv->load();

Container::bind('database', require __DIR__ . '/Database/config.php');
