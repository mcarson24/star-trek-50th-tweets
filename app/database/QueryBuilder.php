<?php

namespace App\Database;

use \PDO;
use Illuminate\Support\Str;
use App\Database\Connection;
use Illuminate\Support\Collection;

class QueryBuilder
{
	protected $pdo;
	protected $driver;

	public function __construct(PDO $pdo = NULL, $driver = NULL)
	{
		$this->pdo = $pdo ?? Connection::make();

		$this->driver = $driver ?? getenv('DB_CONNECTION');
	}

	/**
	 * Get the amount of tweets in the tweets table.
	 * 
	 * @return string
	 */
	public function getCount()
	{
		$query = $this->pdo->prepare('SELECT COUNT(id) AS amount FROM tweets;');

		$query->execute();

		return $query->fetchAll(\PDO::FETCH_CLASS)[0];
	}

	/**
	 * Get tweets from the database.
	 * 
	 * @param  integer $offset
	 * @param  integer $limit 
	 * @return array        
	 */
	public function select($offset = 1, $limit = 100)
	{
		$query = $this->pdo->prepare("SELECT * FROM tweets LIMIT 100 OFFSET {$offset};");

		$query->execute();

		return collect($query->fetchAll(\PDO::FETCH_CLASS));
	}

	/**
	 * Insert a tweet into the tweets table.
	 * 
	 * @param  array $parameters 
	 * @return void             
	 */
	public function insertIntoTweets($parameters)
	{
		$query = $this->pdo->prepare('INSERT INTO tweets(body, time) VALUES(:body, :time)');
		
		$query->execute([
			':body' => $parameters['body'],
			':time' => $parameters['time']
		]);
	}

	/**
	 * Create a table in the database to store tweets.
	 * 
	 * @return void
	 */
	public function createTweetsTable() {
		$this->pdo->prepare(
			$this->tableCreateStatement()
		)->execute();
	}

	/**
	 * Return the tweets table create statement for
	 * the desired database driver type.
	 * 
	 * @return string
	 */
	public function tableCreateStatement()
	{
		return [
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
		][$this->driver];
	}
}
