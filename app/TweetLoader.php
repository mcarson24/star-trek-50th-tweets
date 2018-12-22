<?php

namespace App;

use App\Tweet;
use App\Database\Connection;
use App\TweetLoaderInterface;
use App\Database\QueryBuilder;
use Illuminate\Support\Collection;

class TweetLoader implements TweetLoaderInterface
{
    protected $tweets;

    protected $connection;

    public function __construct()
    {
        $this->connection = new QueryBuilder(
            Connection::make(
               'sqlite:' . __DIR__ . '/database/database.sqlite'
            )
        );
    }

    /**
     * Grabs everything from the tweets table and converts 
     * all items that were returned to Tweet Objects.
     *
     * @param $page
     * @return Illuminate\Support\Collection
     */
    public function load($page = 1)
    {
        $offset = ($page - 1) * 100;

        $this->tweets = collect($this->connection->selectAll('tweets', $offset));

        return $this;
    }

    /**
     * Convert each tweet into a Tweet Object.
     *
     * @return Illuminate\Support\Collection
     */
    public function toTweets()
    {
        return $this->tweets->map(function ($tweet) {
            return new Tweet($tweet);
        });
    }
}
