<?php

namespace App;

interface TweetLoaderInterface
{
    public static function load($page = 1, $file = NULL);

    public static function toTweets();
}
