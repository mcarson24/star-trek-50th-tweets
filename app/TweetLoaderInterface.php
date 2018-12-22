<?php

namespace App;

interface TweetLoaderInterface
{
    public function load();

    public function toTweets();
}
