<?php

namespace App;

use Carbon\Carbon;

class Tweet 
{
	protected $time;
	protected $text;

	public function __construct($tweetText)
	{
		$items = explode(',', $tweetText);

		$this->time = Carbon::parse($items[0]);
		$this->text = $items[2];
	}

	public function time()
	{
		return $this->time->format('l, F jS, g:ia');
	}

	public function text()
	{
		return $this->text;
	}

	public function formattedText()
	{
		return $this->convert_links_to_anchor_tags()->convert_twitter_handles_to_links();
	}

	private function convert_links_to_anchor_tags()
	{
		$this->text = preg_replace('/(https:\/\/[a-z.\/0-9_]*)/i', '<a href="$1">$1</a>', $this->text);

		return $this;
	}

	private function convert_twitter_handles_to_links()
	{
		return preg_replace('/@(\w+)/', '<a href="https://twitter.com/$1">@$1</a>', $this->text);
	}
}