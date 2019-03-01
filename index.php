<?php
declare(strict_types=1);

use App\Service\Post\PostsFetcher;
use App\Service\Post\Stats\PerMonth\LongestPostByCharacterLengthPerMonthProvider;
use App\Service\Post\Stats\PerMonth\PerPost\AverageCharacterLengthPerPostPerMonthProvider;
use App\Service\Post\Stats\PerMonth\PerUser\AverageNumberOfPostsPerUserPerMonthProvider;
use App\Service\Post\Stats\PerWeek\WeeklyPostsProvider;
use Config\Di\ServiceContainer;

require __DIR__ . '/vendor/autoload.php';

/** @var ServiceContainer $container */
$container = (new \Config\DiConfig())->setupConfig();


/** @var PostsFetcher $postsFetcher */
$postsFetcher = $container->getService('postsFetcher');
$fetchedPosts = $postsFetcher->fetchAllPosts();

/** @var AverageCharacterLengthPerPostPerMonthProvider $averageCharacterLengthPerPostPerMonthProvider */
$averageCharacterLengthPerPostPerMonthProvider = $container->getService(
    'averageCharacterLengthPerPostPerMonthProvider'
);

/** @var LongestPostByCharacterLengthPerMonthProvider $longestPostByCharacterLengthPerMonthProvider */
$longestPostByCharacterLengthPerMonthProvider = $container->getService(
    'longestPostByCharacterLengthPerMonthProvider'
);

/** @var AverageNumberOfPostsPerUserPerMonthProvider $averageNumberOfPostsPerUserPerMonthProvider */
$averageNumberOfPostsPerUserPerMonthProvider = $container->getService(
    'averageNumberOfPostsPerUserPerMonthProvider'
);

// show in template when using some framework
echo '<b> - Average character length / post / month</b>';
foreach ($averageCharacterLengthPerPostPerMonthProvider->provideStats($fetchedPosts) as $month => $averageCharacterLengthPerPost) {
    echo '<li>' . $month . ' - ' . round($averageCharacterLengthPerPost);
}

echo '</br></br>';
echo '<b> - Longest post by character length / month: </b>';
foreach ($longestPostByCharacterLengthPerMonthProvider->provideStats($fetchedPosts) as $month => $longestPostByCharacterLength) {
    echo '<li>' . $month . ' - ' . $longestPostByCharacterLength;
}

echo '</br></br>';
echo '<b> - Total posts split by week number of year: </b>';
foreach ((new WeeklyPostsProvider())->provideWeeklyPosts($fetchedPosts) as $week => $weeklyPosts) {
    echo '<li>' . $week . ' - ' . count($weeklyPosts);
}


echo '</br></br><b> - Average number of  posts per user / month: </b>';
foreach ($averageNumberOfPostsPerUserPerMonthProvider->provideStats($fetchedPosts) as $month => $averageNumberOfPostsPerUser) {
    echo '<li>' . $month . ' - ' . round($averageNumberOfPostsPerUser['averageNumberOfPostsPerUser']);
}


