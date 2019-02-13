<?php

return [
	'sqlite' => [
		'driver' 	=> 'sqlite',
		'database'	=> __DIR__ . '/' . 'database.sqlite',
		'dsn'		=> 'sqlite:' . __DIR__ . '/' . 'database.sqlite'
	],
	'mysql' => [
		'driver' 	=> 'mysql',
		'host' 		=> getenv('DB_HOST'),
        'port' 		=> getenv('DB_PORT'),
        'database' 	=> getenv('DB_DATABASE'),
        'username' 	=> getenv('DB_USERNAME'),
        'password' 	=> getenv('DB_PASSWORD'),
        'dsn'		=> 'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_DATABASE')
	],
	'pgsql' => [
		'driver'	=> 'pgsql',
		'host'		=> getenv('DB_HOST'),
		'port'		=> getenv('DB_PORT'),
		'database'	=> getenv('DB_DATABASE'),
		'username'	=> getenv('DB_USERNAME'),
		'password'	=> getenv('DB_PASSWORD'),
		'dsn'		=> 'pgsql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE') . ';'
	]
];
