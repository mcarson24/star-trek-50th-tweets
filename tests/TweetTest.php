<?php

use App\Tweet;
use PHPUnit\Framework\TestCase;

class TweetTest extends TestCase
{

	/** @test */
	public function it_can_replace_links_with_anchor_tags()
	{
	    $tweet = new Tweet((object) ['time' => '2017-01-01 12:00:00 +0000' , 'body' => 'Just click here https://example.com!']);

	    $this->assertEquals('Just click here <a target="_blank" href="https://example.com">https://example.com</a>!', $tweet->formattedText());
	}

	/** @test */
	public function it_can_replace_twitter_handles_with_anchor_tags()
	{
	    $tweet = new Tweet((object) ['time' => '2017-01-01 12:00:00 +0000' , 'body' => 'Thanks alot @twitter!']);

	    $this->assertEquals('Thanks alot <a target="_blank" href="https://twitter.com/twitter">@twitter</a>!', $tweet->formattedText());
	}

	/** @test */
	public function it_can_replace_hashtags_with_the_correct_anchor_tags()
	{
	    $tweet = new Tweet((object) ['time' => '2017-01-01 12:00:00 +0000' , 'body' => 'So cool! #sample']);

	    $this->assertEquals('So cool! <a target="_blank" href="https://twitter.com/hashtag/sample?src=hash">#sample</a>', $tweet->formattedText());
	}

	/** @test */
	public function it_correctly_formats_a_tweet()
	{
	    $tweet = new Tweet(
	    	(object) [
	    		'time' => '2017-01-01 10:00:00 +0000', 
	    		'body' => '@sample Hello everyone. #Greeting" https://twitter.com/sample'
	    	]
	    );

	    $this->assertEquals('Sunday, January 1st, 2:00am', $tweet->time());
	    $this->assertEquals('<a target="_blank" href="https://twitter.com/sample">@sample</a> Hello everyone. <a target="_blank" href="https://twitter.com/hashtag/Greeting?src=hash">#Greeting</a>" <a target="_blank" href="https://twitter.com/sample">https://twitter.com/sample</a>', $tweet->formattedText());
	}

	/** @test */
	public function it_can_set_time_into_a_shorter_format()
	{
	    $tweet = new Tweet((object) ['time' => '2017-01-01 12:00:00 +0000' , 'body' => 'So cool! #sample']);

	    $this->assertEquals('Jan 1st', $tweet->shortTime());
	}
}
