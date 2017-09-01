<?php

namespace App;

use App\Tweet;
use Illuminate\Support\Collection;

class TweetLoader
{
	protected $file;
	protected $tweets;

	/**
	 * Loads the csv file and converts all items to Tweet Objects.
	 * 
	 * @param  $file 
	 * @return Illuminate\Support\Collection
	 */
	public function load($file)
	{
		$this->file = fopen($file, 'r');
		$this->tweets = fgetcsv($this->file, 1050000, '^');

		return $this->toTweets();
	}

	/**
	 * Convert each tweet into a Tweet Object.
	 * 
	 * @return Illuminate\Support\Collection
	 */
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
