<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Models\Call;
use App\Http\Resources\CallResource;
use App\Models\Language;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Patients",
 *     description="Gestió de pacients"
 * )
 */
class PatientController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/api/patients",
     *     tags={"Patients"},
     *     summary="Llistar pacients",
     *     description="Retorna tots els pacients amb opcions de filtratge per zona, operador i estat",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="zoneId",
     *         in="query",
     *         description="ID de la zona",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="operatorId",
     *         in="query",
     *         description="ID de l'operador assignat",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Estat del pacient",
     *         required=false,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pacients recuperats correctament",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PatientResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error recuperant els pacients"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Patient::query();

        foreach ($request->query() as $key => $value) {
            if (in_array($key, ['zoneId', 'operatorId', 'status'])) {
            $query->where($key, $value);
            }
        }

        return PatientResource::collection($query->get());
    }

    /**
     * @OA\Post(
     *     path="/api/patients",
     *     tags={"Patients"},
     *     summary="Crear pacient",
     *     description="Crea un nou pacient amb idiomes i persones de contacte",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StorePatientRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pacient creat correctament",
     *         @OA\JsonContent(ref="#/components/schemas/PatientResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la creació del pacient"
     *     )
     * )
     */
    public function store(StorePatientRequest $request)
    {
        try{
            $validated = $request->validated();
            $patient = Patient::create($validated);
            $languages = $validated['languages'];
            foreach ($languages as $language) {
                if (is_numeric($language)) {
                    $languageModel = Language::find($language);
                } else {
                    $languageModel = Language::where('name', $language)->first();
                }
                if ($languageModel) {
                    if (!$patient->languages()->where('language_id', $languageModel->id)->exists()) {
                        $patient->languages()->attach($languageModel);
                    }
                }
            }

            $contactPersons = $validated['contactPersons'];
            foreach ($contactPersons as $contactPerson) {
                if (!isset($contactPerson['patientId'])) {
                    $contactPerson['patientId'] = $patient->id;
                }
                $patient->contactPersons()->create($contactPerson);
            }

            return response()->json(new PatientResource($patient), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

   /**
     * @OA\Get(
     *     path="/api/patients/{patient}",
     *     tags={"Patients"},
     *     summary="Mostrar pacient",
     *     description="Mostra els detalls d'un pacient concret",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="patient",
     *         in="path",
     *         required=true,
     *         description="ID del pacient",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pacient recuperat correctament",
     *         @OA\JsonContent(ref="#/components/schemas/PatientResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pacient no trobat"
     *     )
     * )
     */
    public function show(Patient $patient)
    {
        $patient->load(['languages', 'contactPersons', 'zone', 'operator', 'calls']);

        return $this->sendResponse(new PatientResource($patient), 'Patient retrieved successfully.', 200);
    }

    /**
     * @OA\Put(
     *     path="/api/patients/{patient}",
     *     tags={"Patients"},
     *     summary="Actualitzar pacient",
     *     description="Actualitza un pacient existent i la seva informació relacionada",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="patient",
     *         in="path",
     *         required=true,
     *         description="ID del pacient",
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdatePatientRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pacient actualitzat correctament",
     *         @OA\JsonContent(ref="#/components/schemas/PatientResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error actualitzant el pacient"
     *     )
     * )
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $validated = $request->validated();
        $patient->update($validated);
        $languages = $validated['languages'];
        $patient->languages()->detach();
        foreach ($languages as $language) {
            if (is_numeric($language)) {
                $languageModel = Language::find($language);
            } else {
                $languageModel = Language::where('name', $language)->first();
            }
            if ($languageModel) {
                if (!$patient->languages()->where('language_id', $languageModel->id)->exists()) {
                    $patient->languages()->attach($languageModel);
                }
            }
        }

        $contactPersons = $validated['contactPersons'];
        $patient->contactPersons()->delete();
        foreach ($contactPersons as $contactPerson) {
            if (!isset($contactPerson['patientId'])) {
                $contactPerson['patientId'] = $patient->id;
            }
            $patient->contactPersons()->create($contactPerson);
        }

        return $this->sendResponse(new PatientResource($patient), 'Patient updated successfully.', 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/patients/{patient}",
     *     tags={"Patients"},
     *     summary="Eliminar pacient",
     *     description="Elimina un pacient específic",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="patient",
     *         in="path",
     *         required=true,
     *         description="ID del pacient",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pacient eliminat correctament"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error eliminant el pacient"
     *     )
     * )
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return $this->sendResponse([], 'Patient deleted successfully.', 200);
    }

    /**
     * @OA\Get(
     *     path="/api/patients/{id}/calls",
     *     tags={"Patients"},
     *     summary="Historial de trucades per pacient",
     *     description="Recupera totes les trucades associades a un pacient",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del pacient",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Historial de trucades recuperat correctament",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/CallResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pacient no trobat"
     *     )
     * )
     */
    public function getCallHistoryByPatient($id)
    {
        $calls = Call::where('patientId', $id)->get();
        return CallResource::collection($calls);
    }


}
