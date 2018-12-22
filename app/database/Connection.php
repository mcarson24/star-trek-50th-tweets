<?php

namespace App\Database;

use PDO;

class Connection 
{
	public static function make()
	{
		try {
			return new PDO('mysql:host=127.0.0.1;dbname=st_tweets', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
		} catch (PDOException $e) {
			die (var_dump("ERROR: { $e->getCode() : { $e->getMessage()"));
		}
	}
}

