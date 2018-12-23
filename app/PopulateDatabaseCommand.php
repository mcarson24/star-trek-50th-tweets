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
	public function configure()
	{
		$this->setName('populate-database')
			 ->setDescription('Populate the database with the tweets.');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$database = __DIR__ . '/database/database.sqlite';
		
		if (!file_exists($database)) {
			$this->createDatabase($database, $output);
		}

		$query = new QueryBuilder(Connection::make('sqlite:' . $database));
		$query->createTweetsTable();

		if ($this->databaseIsAlreadyPopulated($query)) {
			$output->writeln('<error>Database already populated with tweets!</error>');
			exit();
		}

		$tweets = $this->getTweets();
		$output->writeln("<info>Populating database with {$tweets->count()} tweets...</info>");

		$tweets->each(function($tweet) use ($query) {
			$query->insertIntoTweets([
				'body' => $tweet->text,
				'time' => $tweet->time->timestamp
			]);
		});

		$output->writeln("<info>Database populated successfully!</info>");
	}

	private function getTweets()
	{
		$csvFile = __DIR__ . '/../tweets.csv';
		
		return collect(
			(new CsvTweetLoader($csvFile))->load()->toTweets()
		)->reverse();
	}

	private function databaseIsAlreadyPopulated($query)
	{
		return sizeof($query->selectAll(0, 10000)) == 4551;
	}

	private function createDatabase($database, OutputInterface $output)
	{
		$output->writeln('<info>Creating database...</info>');
		fopen($database, 'w');
		$output->writeln('<info>Database created!</info>');
	}
}
