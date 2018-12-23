<?php

return [
	'sqlite' => [
		'driver' 	=> 'sqlite',
		'database'	=> __DIR__ . '/' . 'database.sqlite'
	],
	'mysql' => [
		'driver' 	=> 'mysql',
		'host' 		=> getenv('DB_HOST', '127.0.0.1'),
        'port' 		=> getenv('DB_PORT', '3306'),
        'database' 	=> getenv('DB_DATABASE', 'tweets'),
        'username' 	=> getenv('DB_USERNAME', 'user'),
        'password' 	=> getenv('DB_PASSWORD', ''),
	]
];
