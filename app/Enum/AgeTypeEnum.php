<?php

namespace App\Enum;

enum AgeTypeEnum: int
{
    case DAYS = 0;
    case MONTHES = 1;
    case YEARS = 2;

    /**
     * Предполагаем, что за месяц берется 31 день и 365 дня за год
     */
    private const SECONDS_IN_MONTH = 31 * 24 * 60 * 60;
    private const SECONDS_IN_YEAR = 365 * 24 * 60 * 60;

    public static function createByBirthdate(\DateTime $birthdate): AgeTypeEnum
    {
        $ageInSeconds = time() - $birthdate->getTimestamp();

        if ($ageInSeconds < self::SECONDS_IN_MONTH) {
            return self::DAYS;
        }

        if ($ageInSeconds < self::SECONDS_IN_YEAR) {
            return self::MONTHES;
        }

        return self::YEARS;
    }

    public function getAsString(): string
    {
        return match ($this) {
            self::DAYS => 'день',
            self::MONTHES => 'месяц',
            self::YEARS => 'год',
        };
    }
}
