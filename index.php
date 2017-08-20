<?php

require(__DIR__ . '/vendor/autoload.php');

use App\TweetLoader;


// $tweets_file = fopen('app/holly-tweets.csv', 'a+');

// $tweets = fgetcsv($tweets_file, 1050000, '^');
$tweets = (new TweetLoader)->get();

function convert_link($text)
{
	return preg_replace('/(https:\/\/[a-z.\/0-9]*)/i', '<a href="$1">$1</a>', $text);
}

include('index.view.php');
