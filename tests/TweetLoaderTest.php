<?php

use App\Tweet;
use App\FakeTweetLoader;
use PHPUnit\Framework\TestCase;

class TweetLoaderTest extends TestCase
{
    /** @test */
    public function it_converts_a_csv_into_a_collection_of_tweets()
    {
		$tweets = (new FakeTweetLoader(__DIR__ . '/test-tweets.csv'))->load()->toTweets();

        $this->assertInstanceOf(Tweet::class, $tweets->first());
        $this->assertCount(2, $tweets);
    }
}
