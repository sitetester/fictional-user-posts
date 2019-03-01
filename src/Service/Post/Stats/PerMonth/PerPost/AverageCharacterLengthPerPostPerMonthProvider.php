<?php
declare(strict_types=1);

namespace App\Service\Post\Stats\PerMonth\PerPost;

use App\Entity\Post;
use App\Service\Post\Stats\PerMonth\MonthlyPostsProvider;
use App\Service\Post\Stats\StatsProviderInterface;

class AverageCharacterLengthPerPostPerMonthProvider implements StatsProviderInterface
{
    private $monthlyPostsProvider;

    public function __construct(MonthlyPostsProvider $monthlyPostsProvider)
    {
        $this->monthlyPostsProvider = $monthlyPostsProvider;
    }

    public function provideStats(array $fetchedPosts): array
    {
        $postsByMonth = $this->monthlyPostsProvider->provideMonthlyPosts($fetchedPosts);
        $averageCharacterLengthPerPostPerMonth = [];

        foreach ($postsByMonth as $month => $monthlyPosts) {
            $totalPostsLength = 0;
            /** @var Post $post */
            foreach ($monthlyPosts as $post) {
                $totalPostsLength += \strlen($post->getMessage());
            }

            $averageCharacterLengthPerPostPerMonth[$month] = $totalPostsLength / \count($monthlyPosts);
        }

        return $averageCharacterLengthPerPostPerMonth;
    }
}
