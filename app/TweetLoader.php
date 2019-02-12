<?php

namespace App;

use App\Tweet;
use App\TweetLoaderInterface;
use App\Database\QueryBuilder;
use Illuminate\Support\Collection;

class TweetLoader implements TweetLoaderInterface
{
    protected static $tweets;

    protected static $connection;

    /**
     * Grabs everything from the tweets table and converts 
     * all items that were returned to Tweet Objects.
     *
     * @param $page
     * @return Illuminate\Support\Collection
     */
    public static function load($page = 1, $file = NULL)
    {
        static::setUpDatabaseConnection();

        $offset = ($page - 1) * 100;

        static::$tweets = collect(
            static::$connection->selectAll($offset)
        );

        return static::toTweets();
    }

    /**
     * Convert each tweet into a Tweet Object.
     *
     * @return Illuminate\Support\Collection
     */
    public static function toTweets()
    {
        return static::$tweets->map(function ($tweet) {
            return new Tweet($tweet);
        });

    }

    private static function setUpDatabaseConnection()
    {
        static::$connection = new QueryBuilder();
    }
}
