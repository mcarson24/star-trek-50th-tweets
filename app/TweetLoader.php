<?php

namespace App;

use App\Tweet;
use Illuminate\Support\Collection;

class TweetLoader
{
	protected $file;
	protected $tweets;

	public function load($file)
	{
		$this->file = fopen($file, 'r');
		$this->tweets = fgetcsv($this->file, 1050000, '^');

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