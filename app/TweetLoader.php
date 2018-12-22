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
                App::get('config')['database']
            )
        );
    }

    /**
     * Grabs everything from the tweets table and converts 
     * all items that were returned to Tweet Objects.
     *
     * @return Illuminate\Support\Collection
     */
    public function load()
    {
        $this->tweets = collect($this->connection->selectAll('tweets'));

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
