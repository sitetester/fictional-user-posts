<?php
declare(strict_types=1);

namespace App\Service\Post\Stats\PerMonth;

use App\Entity\Post;
use App\Service\Post\Stats\StatsProviderInterface;

class LongestPostByCharacterLengthPerMonthProvider implements StatsProviderInterface
{
    private $monthlyPostsProvider;

    public function __construct(MonthlyPostsProvider $monthlyPostsProvider)
    {
        $this->monthlyPostsProvider = $monthlyPostsProvider;
    }

    /**
     * http://php.net/manual/en/function.array-key-last.php
     * Use array_key_last() whenever available in PHP version
     */
    public function provideStats(array $fetchedPosts): array
    {
        $postsByMonth = $this->monthlyPostsProvider->provideMonthlyPosts($fetchedPosts);

        $longestPostByCharacterLengthPerMonth = [];
        foreach ($postsByMonth as $month => $monthlyPosts) {
            $postLengthByMonth = [];
            /** @var Post $post */
            foreach ($monthlyPosts as $post) {
                $postLengthByMonth[$month][$post->getId()] = \strlen($post->getMessage());
            }

            asort($postLengthByMonth[$month]);
            end($postLengthByMonth[$month]);

            $longestPostByCharacterLengthPerMonth[$month] = key($postLengthByMonth[$month]);
        }

        return $longestPostByCharacterLengthPerMonth;
    }
}
