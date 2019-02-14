<?php

namespace App;

use App\Tweet;
use App\TweetLoaderInterface;
use App\Database\QueryBuilder;

class TweetLoader implements TweetLoaderInterface
{
    /**
     * The loaded tweets.
     * 
     * @var Illuminate\Support\Collection
     */
    protected static $tweets;

    /**
     * The database connection.
     * 
     * @var PDO
     */
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

        static::$tweets = static::$connection->select(static::tweetOffset($page));

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

    /**
     * Set up a database connection.
     * 
     * @return void
     */
    private static function setUpDatabaseConnection()
    {
        static::$connection = new QueryBuilder();
    }

    /**
     * Determine the set of tweets to select 
     * for the desired page.
     * 
     * @param  integer $page 
     * @return integer
     */
    private static function tweetOffset($page)
    {
        return ($page - 1) * 100;
    }
}
