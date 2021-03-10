<?php

namespace ST50Tweets\Console;

use ST50Tweets\CsvTweetLoader;
use ST50Tweets\Database\Connection;
use ST50Tweets\Database\QueryBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateDatabaseCommand extends Command
{
	/**
	 * Database query builder.
	 * 
	 * @var App\Database\Querybuilder
	 */
	protected $query;

	/**
	 * The type of database driver to use.
	 * 
	 * @var string
	 */
	protected $database;

	/**
	 * Command configuration.
	 * 
	 * @return void
	 */
	public function configure()
	{
		$this->setName('populate')
			 ->addOption('driver', 'd', InputOption::VALUE_OPTIONAL, 'The database driver')
			 ->setDescription('Populate the database with the tweets.');
	}

	/**
	 * Command execution.
	 * 
	 * @param  InputInterface  $input  
	 * @param  OutputInterface $output 
	 * @return void
	 */
	public function execute(InputInterface $input, OutputInterface $output)
	{
		require __DIR__ . '/../bootstrap.php';

		$this->chooseDatabaseType($input)
			 ->createDatabase($output)
			 ->prepareDatabase();

		if ($this->databaseIsAlreadyPopulated()) {
			$output->writeln('<error>Database already populated with tweets!</error>');
			exit();
		}

		$this->populateDatabase($output);
	}

	/**
	 * Determine if the database is already
	 * populated with the tweets.
	 * 
	 * @return boolean
	 */
	private function databaseIsAlreadyPopulated()
	{
		return $this->amountOfTweetsInDatabase() >= 4551;
	}

	/**
	 * Create a sqlite database.
	 * 
	 * @param  OutputInterface $output 
	 * @return self
	 */
	private function createDatabase(OutputInterface $output)
	{
		if ($this->database == 'sqlite' && !file_exists($this->databasePath())) {
			$output->writeln('<info>Creating database...</info>');
			fopen($this->databasePath(), 'w');
			$output->writeln("<info>Database created!");
		}

		return $this;
	}

	/**
	 * Populates the database with the tweets from the csv file.
	 * 
	 * @param  OutputInterface $output 
	 * @return void                  
	 */
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

	/**
	 * Determines the type of database to use.
	 * 
	 * @return self
	 */
	private function chooseDatabaseType(InputInterface $input)
	{
		$this->database = getenv('DB_CONNECTION');

		if ($input->getOption('driver')) {
			$this->database = $input->getOption('driver');
		}

		return $this;
	}

	/**
	 * Create a connection to the database.
	 * 
	 * @return self
	 */
	private function prepareDatabase()
	{
		$this->query = new QueryBuilder(Connection::make($this->database), $this->database);

		$this->query->createTweetsTable();		

		return $this;
	}

	/**
	 * Return a collection of tweets 
	 * from the csv file.
	 * 
	 * @return Illuminate\Support\Collection
	 */
	private function getTweets()
	{
		$csvFile = __DIR__ . '/../../tweets.csv';
		
		return collect(
			CsvTweetLoader::load(1, $csvFile)
		)->reverse();
	}

	/**
	 * Get the amount of tweets in the database.
	 * 
	 * @return integer
	 */
	private function amountOfTweetsInDatabase()
	{
		return $this->query->getCount()->amount;
	}

	/**
	 * The path to the database.
	 * 
	 * @return string
	 */
	private function databasePath()
	{
		if ($this->database == 'sqlite') return __DIR__ . '/../database/database.sqlite';
	}
}
