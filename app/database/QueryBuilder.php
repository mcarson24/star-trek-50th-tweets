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

	public function selectAll($table, $offset)
	{
		$query = $this->pdo->prepare("SELECT * FROM {$table} LIMIT 100 OFFSET :offset;");

		$query->execute([$offset]);

		return $query->fetchAll(\PDO::FETCH_CLASS);
	}

	public function insert($table, $parameters)
	{
		$query = $this->pdo->prepare('INSERT INTO tweets (body, time) VALUES (:body, :time)');
		
		$query->execute([
			':body' => $parameters['body'],
			':time' => $parameters['time']
		]);
	}


}
