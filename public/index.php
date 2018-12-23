<?php

require __DIR__ . '/../vendor/autoload.php';

use App\TweetLoader;
use App\SimplePagination;
use App\Database\Connection;
use App\Database\QueryBuilder;
use Pagerfanta\Adapter\ArrayAdapter;

$page = SimplePagination::currentPage();

$tweets = (new TweetLoader)->load($page)->toTweets();

$loader = new Twig_Loader_Filesystem('../src/views');

$twig = new Twig_Environment($loader, [
    'autoescape' => false
]);

echo $twig->render('index.twig', compact('tweets', 'page'));
