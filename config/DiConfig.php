<?php
declare(strict_types=1);

namespace Config;

use App\Service\Helper\DateTimeHelper;
use App\Service\Post\PostsDenormalizer;
use App\Service\Post\PostsFetcher;
use App\Service\Post\Stats\PerMonth\LongestPostByCharacterLengthPerMonthProvider;
use App\Service\Post\Stats\PerMonth\MonthlyPostsProvider;
use App\Service\Post\Stats\PerMonth\PerPost\AverageCharacterLengthPerPostPerMonthProvider;
use App\Service\Post\Stats\PerMonth\PerUser\AverageNumberOfPostsPerUserPerMonthProvider;
use App\Service\Post\Stats\PerMonth\PerUser\TotalNumberOfPostsPerUserPerMonthProvider;
use App\Service\Token\TokenProvider;
use Config\Di\ServiceContainer;
use Config\Helper\MonologHelper;
use Doctrine\Common\Cache\FilesystemCache;
use Zend\Http\Client;

class DiConfig
{
    public function setupConfig(): ServiceContainer
    {
        $container = new ServiceContainer();

        foreach ($this->getServices() as $serviceInfo) {
            $container->registerService($serviceInfo[0], $serviceInfo[1]);
        }

        return $container;
    }

    private function getServices(): array
    {
        $config = require __DIR__ . '/configParams.php';
        $logger = MonologHelper::getLogger();
        $cache = new FilesystemCache('var/data');

        $tokenProvider = new TokenProvider(
            $config['token'],
            new Client(),
            new DateTimeHelper()
        );

        return [
            [
                'tokenProvider',
                $tokenProvider
            ],
            [
                'postsFetcher',
                new PostsFetcher(
                    $cache,
                    $config['posts'],
                    $tokenProvider,
                    new Client(),
                    new PostsDenormalizer(),
                    $logger
                )
            ],
            [
                'averageNumberOfPostsPerUserPerMonthProvider',
                new AverageNumberOfPostsPerUserPerMonthProvider(
                    new TotalNumberOfPostsPerUserPerMonthProvider(
                        new MonthlyPostsProvider()
                    )
                )
            ],
            [
                'longestPostByCharacterLengthPerMonthProvider',
                new LongestPostByCharacterLengthPerMonthProvider(
                    new MonthlyPostsProvider()
                )
            ],
            [
                'averageCharacterLengthPerPostPerMonthProvider',
                new AverageCharacterLengthPerPostPerMonthProvider(
                    new MonthlyPostsProvider()
                )
            ]
        ];
    }
}
