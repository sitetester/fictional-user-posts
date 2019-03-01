<?php
declare(strict_types=1);

use App\Service\Post\Stats\PerMonth\LongestPostByCharacterLengthPerMonthProvider;
use tests\BaseTestCase;

class LongestPostByCharacterLengthPerMonthProviderTest extends BaseTestCase
{
    /** @var LongestPostByCharacterLengthPerMonthProvider */
    private $longestPostByCharacterLengthPerMonthProvider;

    public function setUp(): void
    {
        parent::setUp();

        $this->longestPostByCharacterLengthPerMonthProvider = $this->container->getService(
            'longestPostByCharacterLengthPerMonthProvider'
        );
    }

    public function testProvideStats(): void
    {
        $longestPostByCharacterLengthPerMonth = $this->longestPostByCharacterLengthPerMonthProvider->provideStats(
            $this->getSampleFetchedPosts()
        );

        self::assertEquals('post6', $longestPostByCharacterLengthPerMonth['Feb']);
        self::assertEquals('post11', $longestPostByCharacterLengthPerMonth['Jan']);
    }
}
