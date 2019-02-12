<?php

return [
	'sqlite' => [
		'driver' 	=> 'sqlite',
		'database'	=> __DIR__ . '/' . 'database.sqlite'
	],
	'mysql' => [
		'driver' 	=> 'mysql',
		'host' 		=> getenv('DB_HOST'),
        'port' 		=> getenv('DB_PORT'),
        'database' 	=> getenv('DB_DATABASE'),
        'username' 	=> getenv('DB_USERNAME'),
        'password' 	=> getenv('DB_PASSWORD'),
	],
	'pgsql' => [
		'driver'	=> 'pgsql',
		'host'		=> getenv('DB_HOST'),
		'port'		=> getenv('DB_PORT'),
		'database'	=> getenv('DB_DATABASE'),
		'username'	=> getenv('DB_USERNAME'),
		'password'	=> getenv('DB_PASSWORD')
	]
];
