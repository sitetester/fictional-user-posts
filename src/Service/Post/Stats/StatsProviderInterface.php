<?php
declare(strict_types=1);

namespace App\Service\Post\Stats;

use App\Entity\Post;

interface StatsProviderInterface
{
    /**
     * @param Post[] $fetchedPosts
     */
    public function provideStats(array $fetchedPosts): array;
}
