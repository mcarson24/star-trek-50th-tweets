<?php

namespace App;

use App\Tweet;
use App\Database\Connection;
use App\Database\QueryBuilder;
use Illuminate\Support\Collection;

class TweetLoader
{
    protected $tweets;

    protected $connection;

    public function __construct()
    {
        $this->connection = new QueryBuilder(Connection::make());
    }

    /**
     * Grabs everything from the tweets table and converts 
     * all items that were returned to Tweet Objects.
     *
     * @param  $file
     * @return Illuminate\Support\Collection
     */
    public function load()
    {
        $this->tweets = collect($this->connection->selectAll('tweets'));

        return $this->toTweets();
    }

    /**
     * Convert each tweet into a Tweet Object.
     *
     * @return Illuminate\Support\Collection
     */
    private function toTweets()
    {
        return $this->tweets->map(function ($tweet) {
            return new Tweet($tweet);
        });
    }
}
