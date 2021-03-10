<?php

namespace ST50Tweets;

use App\Tweet;
use App\TweetLoaderInterface;

class CsvTweetLoader implements TweetLoaderInterface
{
	protected static $csvFile;

	protected static $tweets;

	/**
     * Loads the csv file and converts all items to Tweet Objects.
     *
     * @return Illuminate\Support\Collection
     */
	public static function load($page = 1, $file = NULL)
	{
		static::$csvFile = $file;

		static::$tweets = collect(fgetcsv(fopen(static::$csvFile, 'r'), 1050000, '^'));

		return static::toTweets();
	}

	/**
     * Convert each tweet into a Tweet Object.
     *
     * @return Illuminate\Support\Collection
     */
    public static function toTweets()
    {
		return static::$tweets->map(function($tweet) {
	    	$tweet = explode(',', $tweet);

			$attributes = [
				'body' 	=> $tweet[1],
				'time'	=> $tweet[0]
			];
			
			return new Tweet((object) $attributes);
		});
    }
}
