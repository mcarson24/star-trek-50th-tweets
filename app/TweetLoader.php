<?php

namespace App;

use App\Tweet;
use Illuminate\Support\Collection;

class TweetLoader
{
	protected $tweets;

	/**
	 * Loads the csv file and converts all items to Tweet Objects.
	 * 
	 * @param  $file 
	 * @return Illuminate\Support\Collection
	 */
	public function load($file)
	{
		$this->tweets = collect(fgetcsv(fopen($file, 'r'), 1050000, '^'));

		return $this->toTweets();
	}

	/**
	 * Convert each tweet into a Tweet Object.
	 * 
	 * @return Illuminate\Support\Collection
	 */
	private function toTweets()
	{
		return $this->tweets->map(function($tweet) {
			return new Tweet($tweet);
		});
	}
}
