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
		return $this->time->toDayDateTimeString();
	}

	public function text()
	{
		return $this->convert_twitter_handles_to_link($this->convert_links_to_anchor_tags($this->text));
	}

	private function convert_links_to_anchor_tags($text)
	{
		return preg_replace('/(https:\/\/[a-z.\/0-9_]*)/i', '<a href="$1">$1</a>', $text);
	}

	private function convert_twitter_handles_to_link($text)
	{
		return preg_replace('/@(\w+)/', '<a href="https://twitter.com/$1">@$1</a>', $text);
	}
}