<?php

namespace App\Http\Resources;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fullName' => $this->fullName,
            'birthDate' => $this->birthDate,
            'fullAddress' => $this->fullAddress,
            'dni' => $this->dni,
            'healthCardNumber' => $this->healthCardNumber,
            'phone' => $this->phone,
            'email' => $this->email,
            'personalFamilySituation' => $this->personalFamilySituation,
            'healthSituation' => $this->healthSituation,
            'housingSituation' => $this->housingSituation,
            'personalAutonomy' => $this->personalAutonomy,
            'economicSituation' => $this->economicSituation,
            'operatorId' => $this->operatorId,
            'languages' => LanguageResource::collection($this->languages),
            'contactPersons' => ContactPersonResource::collection($this->contactPersons),
            'zone' => new ZoneResource($this->zone),
            'operator' => new OperatorResource($this->operator),
            'calls' => CallResource::collection($this->calls),
        ];
    }
}
