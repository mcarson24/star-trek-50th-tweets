<?php

require(__DIR__ . '/vendor/autoload.php');

use App\TweetLoader;

$tweets = (new TweetLoader)->get();

include('index.view.php');
