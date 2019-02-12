<?php

namespace App\Database;

use Illuminate\Support\Str;
use App\Database\Connection;

class QueryBuilder
{
	protected $pdo;
	protected $driver;

	public function __construct(\PDO $pdo = NULL, $driver = NULL)
	{
		$this->pdo =  $pdo ?? Connection::make();
		$this->driver = $driver;
	}

	public function selectCount()
	{
		$query = $this->pdo->prepare('SELECT COUNT(id) AS amount FROM tweets;');

		$query->execute();

		return $query->fetchAll(\PDO::FETCH_CLASS);
	}

	public function selectAll($offset = 1, $limit = 100)
	{
		$query = $this->pdo->prepare("SELECT * FROM tweets LIMIT 100 OFFSET " . $offset . ';');

		$query->execute();

		return $query->fetchAll(\PDO::FETCH_CLASS);
	}

	public function insertIntoTweets($parameters)
	{
		$query = $this->pdo->prepare('INSERT INTO tweets(body, time) VALUES(:body, :time)');
		
		// die(var_dump($parameters['time']));
		$query->execute([
			':body' => $parameters['body'],
			':time' => $parameters['time']
		]);
	}

	public function createTweetsTable() {
		$query = $this->pdo->prepare($this->sqlCreateStatementFor($this->driver ?? getenv('DB_CONNECTION')));

		$query->execute();
	}

	public function sqlCreateStatementFor($driver)
	{
		$statements = [
			'sqlite' => "CREATE TABLE IF NOT EXISTS 'tweets' (
							'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
							'body'	TEXT NOT NULL,
							'time'	INTEGER NOT NULL
						)",
			'mysql' => "CREATE TABLE `tweets` (
							`id` int(11) NOT NULL AUTO_INCREMENT,
						    `body` text NOT NULL,
						    `time` timestamp NOT NULL,
						    PRIMARY KEY (`id`)
						)",
			'pgsql' => "CREATE TABLE tweets (
						   id SERIAL PRIMARY KEY NOT NULL,
						   body TEXT NOT NULL,
						   time TEXT NOT NULL
						)"
		];

		return $statements[$driver];
	}
}
