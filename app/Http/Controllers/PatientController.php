<?php

namespace App\Http\Controllers;

use App\Service\PatientResolver;    
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(protected readonly PatientResolver $patientResolver)
    {
    }

    public function create(
        string $firstName,
        string $lastName,
        \DateTime $birthdate
    ): JsonResponse {

        $this->patientResolver->savePatient($firstName, $lastName, $birthdate);

        return response()->json(['message' => 'ok']);
    }

    public function list(Request $request): JsonResponse
    {
        $patientsList = $this->patientResolver->getAllPatientsCollection();

        return response()->json($patientsList);
    }
}
