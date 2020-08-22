<?php
declare(strict_types=1);

use tests\BaseTestCase;

class AverageCharacterLengthPerPostPerMonthProviderTest extends BaseTestCase
{
    private object $averageCharacterLengthPerPostPerMonthProvider;

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

        self::assertEquals(16.5, $averageCharacterLengthPerPostPerMonth['Feb']);
        self::assertEquals(22.6, $averageCharacterLengthPerPostPerMonth['Jan']);
    }
}
