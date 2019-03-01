<?php
declare(strict_types=1);

use App\Service\Post\PostsFetcher;

require __DIR__ . '/vendor/autoload.php';

/** @var PostsFetcherTest $postsFetcher */
$postsFetcher = $serviceContainer->getService('PostsFetcherTest');

print_r(
    $postsFetcher->fetchAllPosts()
);


