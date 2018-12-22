<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Tweet;
use App\TweetLoader;
use Illuminate\Support;

$tweets = (new TweetLoader)->load();

$loader = new Twig_Loader_Filesystem('../views');

$twig = new Twig_Environment($loader, [
    'autoescape' => false
]);

echo $twig->render('index.twig', compact('tweets'));
