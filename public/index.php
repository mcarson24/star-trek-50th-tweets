<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/bootstrap.php';

use App\TweetLoader;
use App\SimplePagination;

die(var_dump(phpinfo()));
$tweets = TweetLoader::load($page = SimplePagination::currentPage());

$loader = new Twig_Loader_Filesystem('../src/views');

$twig = new Twig_Environment($loader, [
    'autoescape' => false
]);

echo $twig->render('index.twig', compact('tweets', 'page'));
