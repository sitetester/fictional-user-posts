<?php
declare(strict_types=1);

namespace App\Service\Post\Stats\PerMonth;

use App\Entity\Post;

class MonthlyPostsProvider
{
    /**
     * @param Post[] $fetchedPosts
     * @return Post[]
     */
    public function provideMonthlyPosts(array $fetchedPosts): array
    {
        $postsByMonth = [];
        foreach ($fetchedPosts as $post) {
            $month = $post->getCreatedTime()->format('M');
            $postsByMonth[$month][] = $post;
        }

        return $postsByMonth;
    }
}
