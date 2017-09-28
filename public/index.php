<?php

require __DIR__ . '/../vendor/autoload.php';

use App\TweetLoader;

$tweets = (new TweetLoader)->load('../holly-tweets.csv')->reverse();

$loader = new Twig_Loader_Filesystem('../views');

$twig = new Twig_Environment($loader, [
    'autoescape' => false
]);

echo $twig->render('index.twig', compact('tweets'));
