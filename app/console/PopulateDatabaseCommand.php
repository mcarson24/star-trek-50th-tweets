<?php

namespace App\Console;

use App\CsvTweetLoader;
use App\Database\Connection;
use App\Database\QueryBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateDatabaseCommand extends Command
{
	protected $query;
	protected $database;

	public function configure()
	{
		$this->setName('populate')
			 ->addOption('driver', 'd', InputOption::VALUE_OPTIONAL, 'The database driver')
			 ->setDescription('Populate the database with the tweets.');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		require __DIR__ . '/../bootstrap.php';

		$this->chooseDatabaseType();
		
		if ($input->getOption('driver')) {
			$this->database = $input->getOption('driver');
		}

		if ($this->database == 'sqlite' && !file_exists($this->databasePath())) {
			$this->createDatabase($this->databasePath(), $output);
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
		$csvFile = project_root() . 'tweets.csv';
		
		return collect(
			(new CsvTweetLoader($csvFile))->load()->toTweets()
		)->reverse();
	}

	private function databaseIsAlreadyPopulated()
	{
		return $this->amountOfTweetsInDatabase() >= 4551;
	}

	private function createDatabase($database, OutputInterface $output)
	{
		$output->writeln('<info>Creating database...</info>');
		fopen($database, 'w');
		$output->writeln("<info>Database created!");
	}

	private function populateDatabase(OutputInterface $output)
	{
		$tweets = $this->getTweets();
		
		$output->writeln("<info>Populating database with {$tweets->count()} tweets...</info>");

		$tweets->each(function($tweet) {
			$this->query->insertIntoTweets([
				'body' => $tweet->text,
				'time' => $tweet->time
			]);
		});

		$output->writeln("<info>Database populated successfully!</info>");
	}

	private function chooseDatabaseType()
	{
		$this->database = getenv('DB_CONNECTION');
	}

	private function prepareDatabase()
	{
		$this->query = new QueryBuilder(Connection::make($this->database), $this->database);

		$this->query->createTweetsTable();		
	}

	private function amountOfTweetsInDatabase()
	{
		return $this->query->selectCount()[0]->amount;
	}

	private function databasePath()
	{
		if ($this->database == 'sqlite') return __DIR__ . '/../database/database.sqlite';

		return 'st_tweets';
	}
}
