<?php

namespace App\Dto;

use App\Enum\AgeTypeEnum;


class AgeDto
{
    public function __construct(public readonly float $age, public readonly AgeTypeEnum $ageType)
    {
    }

    public function getAsString(): string
    {
        return sprintf('%g', $this->age) . ' ' . $this->ageType->getAsString();
    }

    public static function createByBirthdate(\DateTime $birthdate): AgeDto {
    	$ageType = AgeTypeEnum::createByBirthdate($birthdate);

    	$todayDate = new \DateTime();
    	$ageInterval = $todayDate->diff($birthdate);

    	$age = match ($ageType) {
    		AgeTypeEnum::DAYS => $ageInterval->d,
            AgeTypeEnum::MONTHES => $ageInterval->m,
            AgeTypeEnum::YEARS => $ageInterval->y,
    	};

    	return new static($age, $ageType);
    }
}
