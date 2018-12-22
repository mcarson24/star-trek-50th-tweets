<?php

namespace App\Database;

use Illuminate\Support\Str;

class QueryBuilder
{
	protected $pdo;

	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function selectAll($table)
	{
		$query = $this->pdo->prepare("SELECT * FROM {$table};");

		$query->execute();

		return $query->fetchAll(\PDO::FETCH_CLASS);
	}

	public function insert($table, $parameters)
	{
		$query = $this->pdo->prepare(
			sprintf('INSERT INTO %s (%s) VALUES (%s)', 
				$table, 
				implode(', ', array_keys($parameters)), 
				':' . implode(', :', array_keys($parameters))
			)
		);
		
		$query->execute($parameters);
	}


}
