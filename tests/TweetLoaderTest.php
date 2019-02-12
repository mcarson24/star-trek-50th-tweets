<?php

use App\Tweet;
use App\CsvTweetLoader;
use PHPUnit\Framework\TestCase;

class TweetLoaderTest extends TestCase
{
    /** @test */
    public function it_converts_a_csv_into_a_collection_of_tweets()
    {
		$tweets = collect(
			CsvTweetLoader::load(1, __DIR__ . '/test-tweets.csv')
		);
		
        $this->assertInstanceOf(Tweet::class, $tweets->first());
        $this->assertCount(2, $tweets);
    }
}
