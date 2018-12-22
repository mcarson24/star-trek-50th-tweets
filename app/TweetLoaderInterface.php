<?php

namespace App;

interface TweetLoaderInterface
{
    public function load($page = 1);

    public function toTweets();
}
