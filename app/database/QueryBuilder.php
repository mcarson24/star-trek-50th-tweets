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

	public function selectAll($offset = 1, $limit = 100)
	{
		$query = $this->pdo->prepare("SELECT * FROM tweets LIMIT :limit OFFSET :offset;");

		$query->execute([$limit, $offset]);

		return $query->fetchAll(\PDO::FETCH_CLASS);
	}

	public function insertIntoTweets($parameters)
	{
		$query = $this->pdo->prepare('INSERT INTO tweets (body, time) VALUES (:body, :time)');
		
		$query->execute([
			':body' => $parameters['body'],
			':time' => $parameters['time']
		]);
	}

	public function createTweetsTable() {
		$query = $this->pdo->prepare("
			CREATE TABLE IF NOT EXISTS 'tweets' (
				'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
				'body'	TEXT,
				'time'	INTEGER NOT NULL
			)"
		);

		$query->execute();
	}


}
