<?php
declare(strict_types=1);

use App\Service\Helper\DateTimeHelper;

class DateTimeHelperTest extends \tests\BaseTestCase
{
    private $dateTimeHelper;

    public function setUp(): void
    {
        parent::setUp();
        $this->dateTimeHelper = new DateTimeHelper();
    }

    public function testIsWithinPast60Min(): void
    {
        self::assertTrue(
            $this->dateTimeHelper->isWithinPast60Min(
                strtotime('-5 minute')
            )
        );

        self::assertFalse(
            $this->dateTimeHelper->isWithinPast60Min(
                strtotime('-1 hour')
            )
        );

        self::assertFalse(
            $this->dateTimeHelper->isWithinPast60Min(
                strtotime('+1 hour')
            )
        );
    }
}
