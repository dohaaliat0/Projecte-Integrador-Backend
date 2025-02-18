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

class PatientController extends BaseController
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        $patient->load(['languages', 'contactPersons', 'zone', 'operator', 'calls']);

        return $this->sendResponse(new PatientResource($patient), 'Patient retrieved successfully.', 200);
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return $this->sendResponse([], 'Patient deleted successfully.', 200);
    }

    public function getCallHistoryByPatient($id)
    {
        $calls = Call::where('patientId', $id)->get();
        return CallResource::collection($calls);
    }


}
