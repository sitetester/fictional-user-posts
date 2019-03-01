<?php
declare(strict_types=1);

namespace App\Service\Post\Stats\PerWeek;

use App\Entity\Post;

class WeeklyPostsProvider
{
    /**
     * @return Post[]
     */
    public function provideWeeklyPosts(array $fetchedPosts): array
    {
        $weeklyPosts = [];

        /** @var Post $post */
        foreach ($fetchedPosts as $post) {
            $weekNumberOfYear = (int)$post->getCreatedTime()->format('W');
            $weeklyPosts[$weekNumberOfYear][] = $post;
        }

        return $weeklyPosts;
    }
}
