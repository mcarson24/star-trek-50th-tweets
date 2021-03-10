<?php

use ST50Tweets\Container;
use Dotenv\Dotenv;

$dotenv = new Dotenv(__DIR__ . '/..');
$dotenv->load();


Container::bind('database', require __DIR__ . '/database/config.php');
