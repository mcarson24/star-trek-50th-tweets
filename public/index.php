<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../ST50Tweets/bootstrap.php';

use ST50Tweets\TweetLoader;
use ST50Tweets\SimplePagination;

$tweets = TweetLoader::load($page = SimplePagination::currentPage());

$loader = new Twig_Loader_Filesystem('../src/views');

$twig = new Twig_Environment($loader, [
    'autoescape' => false
]);

echo $twig->render('index.twig', compact('tweets', 'page'));
