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
		$this->text = $items[1];
	}

	/**
	 * Return the time in the desired format.
	 * 
	 * @return string
	 */
	public function time()
	{
		return $this->time->setTimezone('America/Los_Angeles')->format('l, F jS, g:ia');
	}

	/**
	 * Return the time in the shorter format.
	 * 
	 * @return string
	 */
	public function shortTime()
	{
		return $this->time->setTimezone('America/Los_Angeles')->format('M jS');
	}

 	/**
 	 * Completely format the text of the tweet.
 	 *  
 	 * @return string
 	 */
	public function formattedText()
	{
		return $this->links_to_anchor_tags()
				    ->twitter_handles_to_links()
				    ->hashtags_to_links();
	}

	/**
	 * Convert links to anchor tags for displaying in a web browser.
	 * 
	 * @return App\Tweet
	 */
	private function links_to_anchor_tags()
	{
		$this->text = preg_replace('/(http[s]?:\/\/[a-z.\/0-9_?=-]*)/i', '<a target="_blank" href="$1">$1</a>', $this->text);

		return $this;
	}

	/**
	 * Convert twitter handles to anchor tags for displaying in a web browser.
	 * 
	 * @return App\Tweet
	 */
	private function twitter_handles_to_links()
	{
		$this->text =  preg_replace('/@(\w+)/', '<a target="_blank" href="https://twitter.com/$1">@$1</a>', $this->text);

		return $this;
	}

	/**
	 * Convert hash tags to anchor tags for displaying in a web browser.
	 * 
	 * @return string
	 */
	private function hashtags_to_links()
	{
		return preg_replace('/#([a-z0-9]+)/i', '<a target="_blank" href="https://twitter.com/hashtag/$1?src=hash">#$1</a>', $this->text);
	}
}
