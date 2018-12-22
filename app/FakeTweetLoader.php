<?php

namespace App;

use App\TweetLoaderInterface;

class FakeTweetLoader implements TweetLoaderInterface
{
	protected $csvFile;

	protected $tweets;

	public function __construct($csvFile)
	{
		$this->csvFile = $csvFile;
	}

	/**
     * Loads the csv file and converts all items to Tweet Objects.
     *
     * @return Illuminate\Support\Collection
     */
	public function load()
	{
		$this->tweets = collect(fgetcsv(fopen($this->csvFile, 'r'), 1050000, '^'));

		return $this;
	}

	/**
     * Convert each tweet into a Tweet Object.
     *
     * @return Illuminate\Support\Collection
     */
    public function toTweets()
    {
		return $this->tweets->map(function($tweet) {
	    	$tweet = explode(',', $tweet);

			$attributes = [
				'body' 	=> $tweet[1],
				'time'	=> $tweet[0]
			];
			
			return new Tweet((object) $attributes);
		});
    }
}
