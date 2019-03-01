<?php
declare(strict_types=1);

namespace App\Service\Post\Stats\PerMonth\PerUser;

use App\Service\Post\Stats\StatsProviderInterface;

class AverageNumberOfPostsPerUserPerMonthProvider implements StatsProviderInterface
{
    private $totalNumberOfPostsPerUserPerMonthProvider;

    public function __construct(TotalNumberOfPostsPerUserPerMonthProvider $totalNumberOfPostsPerUserPerMonthProvider)
    {
        $this->totalNumberOfPostsPerUserPerMonthProvider = $totalNumberOfPostsPerUserPerMonthProvider;
    }

    public function provideStats(array $fetchedPosts): array
    {
        $totalNumberOfPostsPerUserPerMonth = $this->totalNumberOfPostsPerUserPerMonthProvider->provideStats($fetchedPosts);

        $averageNumberOfPostsPerUserPerMonth = [];
        foreach ($totalNumberOfPostsPerUserPerMonth as $month => $totalPostsByUser) {
            $usersTotalPosts = 0;
            $usersCounter = 0;
            foreach ($totalPostsByUser as $user => $totalPosts) {
                ++$usersCounter;
                $usersTotalPosts += $totalPosts['totalPosts'];
            }

            $averageNumberOfPostsPerUserPerMonth[$month]['averageNumberOfPostsPerUser'] = $usersTotalPosts / $usersCounter;
        }

        return $averageNumberOfPostsPerUserPerMonth;
    }
}
