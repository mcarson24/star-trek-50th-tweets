<?php

namespace App;

use App\CsvTweetLoader;
use App\Database\Connection;
use App\Database\QueryBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateDatabaseCommand extends Command
{
	protected $query;
	protected $database;

	public function configure()
	{
		$this->setName('populate-database')
			 ->setDescription('Populate the database with the tweets.');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$this->chooseDatabaseType();
		
		if (!file_exists($this->database)) {
			$this->createDatabase($this->database, $output);
		}

		$this->prepareDatabase();

		if ($this->databaseIsAlreadyPopulated()) {
			$output->writeln('<error>Database already populated with tweets!</error>');
			exit();
		}

		$this->populateDatabase($output);
	}

	private function getTweets()
	{
		$csvFile = __DIR__ . '/../tweets.csv';
		
		return collect(
			(new CsvTweetLoader($csvFile))->load()->toTweets()
		)->reverse();
	}

	private function databaseIsAlreadyPopulated()
	{
		return sizeof($this->query->selectAll(0, 10000)) == 4551;
	}

	private function createDatabase($database, OutputInterface $output)
	{
		$output->writeln('<info>Creating database...</info>');
		fopen($this->database, 'w');
		$output->writeln('<info>Database created!</info>');
	}

	private function populateDatabase(OutputInterface $output)
	{
		$tweets = $this->getTweets();
		
		$output->writeln("<info>Populating database with {$tweets->count()} tweets...</info>");

		$tweets->each(function($tweet) {
			$this->query->insertIntoTweets([
				'body' => $tweet->text,
				'time' => $tweet->time->timestamp
			]);
		});

		$output->writeln("<info>Database populated successfully!</info>");
	}

	private function chooseDatabaseType()
	{
		$this->database = __DIR__ . '/database/database.sqlite';
	}

	private function prepareDatabase()
	{
		$this->query = new QueryBuilder(Connection::make('sqlite:' . $this->database));
		$this->query->createTweetsTable();		
	}
}
