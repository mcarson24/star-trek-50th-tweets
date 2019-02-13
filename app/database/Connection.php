<?php

namespace App\Database;

use PDO;
use App\Container;

class Connection 
{
	/**
	 * Create a database connection.
	 * 
	 * @return PDO
	 */
	public static function make()
	{
		$config = static::buildConfig();
		
		try {
			return new PDO($config['dsn'], 
						   $config['user'] ?? '', 
						   $config['password'] ?? '', 
						   $config['options'] ?? []
			);
		} catch (PDOException $e) {
			echo "ERROR: { $e->getCode() } : { $e->getMessage() }";
		}
	}

	/**
	 * Build up a configuration array for the
	 * desired connection type. 
	 * 
	 * @param  string $driver
	 * @return array
	 */
	private static function buildConfig()
	{
		return Container::get('database')[getenv('DB_CONNECTION')];
	}
}
