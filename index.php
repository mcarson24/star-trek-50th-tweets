<?php
$tweets_file = fopen('holly-tweets.csv', 'a+');

$tweets = fgetcsv($tweets_file, 1050000, '^');

$table_headers = explode(',', $tweets[0]);

function convert_link($text)
{
	return preg_replace('/(https:\/\/[a-z.\/0-9]*)/i', '<a href="$1">$1</a>', $text);
}

include('index.view.php');
