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
		return $this->links_to_anchor_tags()
				    ->twitter_handles_to_links()
				    ->hashtags_to_links();
	}

	private function links_to_anchor_tags()
	{
		$this->text = preg_replace('/(http[s]?:\/\/[a-z.\/0-9_?=-]*)/i', '<a href="$1">$1</a>', $this->text);

		return $this;
	}

	private function twitter_handles_to_links()
	{
		$this->text =  preg_replace('/@(\w+)/', '<a href="https://twitter.com/$1">@$1</a>', $this->text);

		return $this;
	}

	private function hashtags_to_links()
	{
		return preg_replace('/#([a-z0-9]+)/i', '<a href="https://twitter.com/hashtag/$1?src=hash">#$1</a>', $this->text);
	}
}