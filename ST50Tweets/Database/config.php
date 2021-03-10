<?php

return [
	'sqlite' => [
		'driver' 	=> 'sqlite',
		'database'	=> __DIR__ . '/' . 'database.sqlite',
		'dsn'		=> 'sqlite:' . __DIR__ . '/' . 'database.sqlite'
	],
	'mysql' => [
		'driver' 	=> 'mysql',
		'host' 		=> $_ENV['DB_HOST'],
        'port' 		=> $_ENV['DB_PORT'],
        'database' 	=> $_ENV['DB_DATABASE'],
        'username' 	=> $_ENV['DB_USERNAME'],
        'password' 	=> $_ENV['DB_PASSWORD'],
        'dsn'		=> 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE']
	],
	'pgsql' => [
		'driver'	=> 'pgsql',
		'host'		=> $_ENV['DB_HOST'],
		'port'		=> $_ENV['DB_PORT'],
		'database'	=> $_ENV['DB_DATABASE'],
		'username'	=> $_ENV['DB_USERNAME'],
		'password'	=> $_ENV['DB_PASSWORD'],
		'dsn'		=> 'pgsql:host=' . $_ENV['DB_HOST'] . ';port=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_DATABASE'] . ';'
	]
];
