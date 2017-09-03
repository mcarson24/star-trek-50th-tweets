<?php

use App\Tweet;
use PHPUnit\Framework\TestCase;

class TweetTest extends PHPUnit\Framework\TestCase
{
	/** @test */
	public function it_can_split_the_time_and_the_tweet_text()
	{
	    $tweet = new Tweet('2017-01-01 12:00:00 +0000,This is a sample tweet!');

	    $this->assertEquals('This is a sample tweet!', $tweet->formattedText());
	    $this->assertEquals('Sunday, January 1st, 4:00am', $tweet->time());
	}

	/** @test */
	public function it_can_replace_links_with_anchor_tags()
	{
	    $tweet = new Tweet('2017-01-01 12:00:00 +0000,Just click here https://example.com!');

	    $this->assertEquals('Just click here <a target="_blank" href="https://example.com">https://example.com</a>!', $tweet->formattedText());
	}

	/** @test */
	public function it_can_replace_twitter_handles_with_anchor_tags()
	{
	    $tweet = new Tweet('2017-01-01 12:00:00 +0000,Thanks alot @twitter');

	    $this->assertEquals('Thanks alot <a target="_blank" href="https://twitter.com/twitter">@twitter</a>', $tweet->formattedText());
	}

	/** @test */
	public function it_can_replace_hashtags_with_the_correct_anchor_tags()
	{
	    $tweet = new Tweet('2017-01-01 12:00:00 +0000,So cool! #sample');

	    $this->assertEquals('So cool! <a target="_blank" href="https://twitter.com/hashtag/sample?src=hash">#sample</a>', $tweet->formattedText());
	}

	/** @test */
	public function it_correctly_formats_a_tweet()
	{
	    $tweet = new Tweet('2017-01-01 10:00:00 +0000,"@sample Hello everyone. #Greeting" https://twitter.com/sample');

	    $this->assertEquals('Sunday, January 1st, 2:00am', $tweet->time());
	    $this->assertEquals('"<a target="_blank" href="https://twitter.com/sample">@sample</a> Hello everyone. <a target="_blank" href="https://twitter.com/hashtag/Greeting?src=hash">#Greeting</a>" <a target="_blank" href="https://twitter.com/sample">https://twitter.com/sample</a>', $tweet->formattedText());
	}

	/** @test */
	public function it_can_set_time_into_a_shorter_format()
	{
	    $tweet = new Tweet('2017-01-01 12:00:00 +0000,So cool! #sample');

	    $this->assertEquals('Jan 1st', $tweet->shortTime());
	}
}
