<?php
declare(strict_types=1);

namespace App\Service\Post\Stats\PerMonth\PerUser;

use App\Service\Post\Stats\PerMonth\MonthlyPostsProvider;
use App\Service\Post\Stats\StatsProviderInterface;

class TotalNumberOfPostsPerUserPerMonthProvider implements StatsProviderInterface
{
    private $monthlyPostsProvider;

    public function __construct(MonthlyPostsProvider $monthlyPostsProvider)
    {
        $this->monthlyPostsProvider = $monthlyPostsProvider;
    }

    public function provideStats(array $fetchedPosts): array
    {
        $postsByMonth = $this->monthlyPostsProvider->provideMonthlyPosts($fetchedPosts);

        $totalNumberOfPostsPerUserPerMonth = [];
        foreach ($postsByMonth as $month => $monthlyPosts) {
            foreach ($monthlyPosts as $post) {
                $user = $post->getFromId();
                if (!isset($totalNumberOfPostsPerUserPerMonth[$month][$user])) {
                    $totalNumberOfPostsPerUserPerMonth[$month][$user]['totalPosts'] = 1;
                } else {
                    $totalNumberOfPostsPerUserPerMonth[$month][$user]['totalPosts'] += 1;
                }
            }
        }

        return $totalNumberOfPostsPerUserPerMonth;
    }
}
