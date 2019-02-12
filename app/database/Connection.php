<?php

namespace App\Database;

use PDO;
use App\Container;

class Connection 
{
	public static function make($driver = NULL)
	{
		$config = static::buildConfig($driver);
		
		try {
			return new PDO($config['dsn'], 
						   $config['user'] ?? '', 
						   $config['password'] ?? '', 
						   $config['options'] ?? []
			);
		} catch (PDOException $e) {
			throw new PDOException("ERROR: { $e->getCode() : { $e->getMessage()");
		}
	}

	private static function buildConfig($driver)
	{
		$connectionType = $driver ?? getEnv('DB_CONNECTION');
		$database = Container::get('database')[$connectionType];
		
		$config = [];

		switch($connectionType)
		{
			case 'sqlite':
				$config['dsn'] = 'sqlite:' . $database['database'];
				break;
			case 'mysql':
				$config['dsn'] = 'mysql:host=' . $database['host'] . ';dbname=' . $database['database'];
				$config['user'] = $database['username'];
				$config['password'] = $database['password'];
				$config['options'] = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
			    break;
		    case 'pgsql':
		    	$config['dsn'] = 'pgsql:host=' . $database['host'] . ';port=' . $database['port'] . ';dbname=' . $database['database'] . ';';
		    	$config['user'] = $database['username'];
		    	$config['password'] = $database['password'];
		    	break;
		}

		return $config;
	}
}

