<?php

namespace ST50Tweets;

interface TweetLoaderInterface
{
    public static function load($page = 1, $file = NULL);

    public static function toTweets();
}
