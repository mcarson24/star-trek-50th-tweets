<?php

namespace App;

use App\Tweet;
use Illuminate\Support\Collection;

class TweetLoader
{
	protected $file;
	protected $tweets;

	public function __construct()
	{
		$this->file = fopen('./app/holly-tweets.csv', 'a+');
		$this->tweets = fgetcsv($this->file, 1050000, '^');
	}

	public function load()
	{
		return $this->toTweets();
	}

	private function toTweets()
	{
		$allTweets = collect();
		foreach ($this->tweets as $tweet)
		{	
			$allTweets[] = new Tweet($tweet);
		}
		return $allTweets;
	}
}