<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/bootstrap.php';

use App\App;
use App\Tweet;
use App\TweetLoader;
use Illuminate\Support;
use App\Database\Connection;
use App\Database\QueryBuilder;

$tweets = (new TweetLoader)->load()->toTweets();

$loader = new Twig_Loader_Filesystem('../src/views');

$twig = new Twig_Environment($loader, [
    'autoescape' => false
]);

echo $twig->render('index.twig', compact('tweets'));
