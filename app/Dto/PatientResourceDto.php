<?php

namespace App\Dto;

class PatientResourceDto implements \JsonSerializable
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly \DateTime $birthdate,
        public readonly AgeDto $age
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->firstName . ' ' . $this->lastName,
            'birthdate' => $this->birthdate->format('d.m.Y'),
            'age' => $this->age->getAsString()
        ];
    }
}
