<?php

use ST50Tweets\Container;

$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();


Container::bind('database', require __DIR__ . '/Database/config.php');
