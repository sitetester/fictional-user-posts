<?php
declare(strict_types=1);

namespace App\Service\Helper;

class DateTimeHelper
{
    public function isWithinPast60Min(int $timestamp): bool
    {
        $diff = abs((new \DateTime('now'))->getTimestamp() - $timestamp) / 60;

        return $diff < 60;
    }
}
