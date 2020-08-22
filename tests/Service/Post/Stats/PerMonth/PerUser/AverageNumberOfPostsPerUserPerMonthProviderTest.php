<?php
declare(strict_types=1);

namespace Test\Service\Post\Stats\PerMonth\PerUser;

use App\Service\Post\Stats\PerMonth\MonthlyPostsProvider;
use App\Service\Post\Stats\PerMonth\PerUser\AverageNumberOfPostsPerUserPerMonthProvider;
use App\Service\Post\Stats\PerMonth\PerUser\TotalNumberOfPostsPerUserPerMonthProvider;
use tests\BaseTestCase;

class AverageNumberOfPostsPerUserPerMonthProviderTest extends BaseTestCase
{
    private AverageNumberOfPostsPerUserPerMonthProvider $averageNumberOfPostsPerUserPerMonthProvider;

    public function setUp(): void
    {
        parent::setUp();

        $this->averageNumberOfPostsPerUserPerMonthProvider = new AverageNumberOfPostsPerUserPerMonthProvider(
            new TotalNumberOfPostsPerUserPerMonthProvider(
                new MonthlyPostsProvider()
            )
        );
    }

    public function testProvideStats(): void
    {
        $averageNumberOfPostsPerUserPerMonth = $this->averageNumberOfPostsPerUserPerMonthProvider->provideStats(
            $this->getSampleFetchedPosts()
        );

        self::assertEquals(3, $averageNumberOfPostsPerUserPerMonth['Feb']['averageNumberOfPostsPerUser']);
        self::assertEquals(2.5, $averageNumberOfPostsPerUserPerMonth['Jan']['averageNumberOfPostsPerUser']);
    }
}
