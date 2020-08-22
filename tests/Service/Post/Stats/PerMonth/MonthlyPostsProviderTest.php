<?php
declare(strict_types=1);

use App\Service\Post\Stats\PerMonth\MonthlyPostsProvider;
use tests\BaseTestCase;

class MonthlyPostsProviderTest extends BaseTestCase
{
    private MonthlyPostsProvider $monthlyPostsProvider;

    public function setUp(): void
    {
        parent::setUp();

        $this->monthlyPostsProvider = new MonthlyPostsProvider();
    }

    public function testProvideMonthlyPosts(): void
    {
        $postsByMonth = $this->monthlyPostsProvider->provideMonthlyPosts(
            $this->getSampleFetchedPosts()
        );

        self::assertCount(6, $postsByMonth['Feb']);
        self::assertCount(5, $postsByMonth['Jan']);
    }
}
