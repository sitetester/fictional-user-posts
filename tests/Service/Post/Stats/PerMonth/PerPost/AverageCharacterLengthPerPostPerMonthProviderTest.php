<?php
declare(strict_types=1);

use App\Service\Post\Stats\PerMonth\PerPost\AverageCharacterLengthPerPostPerMonthProvider;
use tests\BaseTestCase;

class AverageCharacterLengthPerPostPerMonthProviderTest extends BaseTestCase
{
    /** @var AverageCharacterLengthPerPostPerMonthProvider */
    private $averageCharacterLengthPerPostPerMonthProvider;

    public function setUp(): void
    {
        parent::setUp();

        $this->averageCharacterLengthPerPostPerMonthProvider = $this->container->getService(
            'averageCharacterLengthPerPostPerMonthProvider'
        );
    }

    public function testProvideStats(): void
    {
        $averageCharacterLengthPerPostPerMonth = $this->averageCharacterLengthPerPostPerMonthProvider->provideStats(
            $this->getSampleFetchedPosts()
        );

        self::assertEquals($averageCharacterLengthPerPostPerMonth['Feb'], 16.5);
        self::assertEquals($averageCharacterLengthPerPostPerMonth['Jan'], 22.6);
    }
}
