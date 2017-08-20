<?php

namespace App;

class TweetLoader
{
	protected $file;
	protected $tweets;

	public function __construct()
	{
		$this->file = fopen('./app/holly-tweets.csv', 'a+');
		$this->tweets = fgetcsv($this->file, 1050000, '^');
	}

	public function get()
	{
		return$this->tweets;
	}
}