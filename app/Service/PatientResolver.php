<?php

namespace App\Service;

use App\Dto\AgeDto;
use App\Dto\PatientResourceDto;
use App\Enum\AgeTypeEnum;
use App\Models\Patient;
use Illuminate\Cache\Repository as Cache;

class PatientResolver
{
    public function __construct(public readonly Cache $cache)
    {
    }

    public function savePatient(string $firstName, string $lastName, \DateTime $birthdate): void
    {
        $patient = new Patient();

        $patient->first_name = $firstName;
        $patient->last_name = $lastName;

        $patient->birthdate = $birthdate->format("Y-m-d");

        $ageDto = AgeDto::createByBirthdate($birthdate);
        $patient->age = $ageDto->age;
        $patient->age_type = $ageDto->ageType->value;

        $patient->save();
    }

    /**
     * @return \App\Dto\PatientResourceDto[]
     */
    public function getAllPatientsCollection(): array
    {
        return $this->cache->get('patient:list', function () {
            return $this->getAllPatientsNonCached();
        });
    }

    /**
     * @return \App\Dto\PatientResourceDto[]
     */
    protected function getAllPatientsNonCached(): array
    {
        $patientsList = [];

        foreach (Patient::all() as $patient) {
            $patientsList[] = new PatientResourceDto(
                $patient->first_name,
                $patient->last_name,
                new \DateTime($patient->birthdate),
                new AgeDto($patient->age, AgeTypeEnum::from($patient->age_type))
            );
        }

        return $patientsList;
    }
}
