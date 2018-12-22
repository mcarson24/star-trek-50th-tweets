<?php

namespace App\Database;

use PDO;

class Connection 
{
	public static function make($config)
	{
		try {
			return new PDO($config);
		} catch (PDOException $e) {
			die (var_dump("ERROR: { $e->getCode() : { $e->getMessage()"));
		}
	}
}

