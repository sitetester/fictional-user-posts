<?php
declare(strict_types=1);

namespace Test\Service\Post\Stats\Provider\PerWeek;

use App\Service\Post\Stats\PerWeek\WeeklyPostsProvider;
use tests\BaseTestCase;

class WeeklyPostsProviderTest extends BaseTestCase
{
    /** @var WeeklyPostsProvider */
    private $weeklyPostsProvider;

    public function setUp(): void
    {
        parent::setUp();
        $this->weeklyPostsProvider = new WeeklyPostsProvider();
    }

    public function testProvideWeeklyPosts(): void
    {
        $postsByWeek = $this->weeklyPostsProvider->provideWeeklyPosts(
            $this->getSampleFetchedPosts()
        );

        // 8th week has 2 posts
        self::assertCount(2, $postsByWeek[8]);

        // 7th week has 4 posts
        self::assertCount(4, $postsByWeek[7]);

        // Ist week has 3 posts
        self::assertCount(3, $postsByWeek[1]);

        // 3rd week has 2 posts
        self::assertCount(2, $postsByWeek[3]);
    }
}
