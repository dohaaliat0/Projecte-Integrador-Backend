<?php

namespace App\Http\Resources\Partials;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientSimpleResource extends JsonResource
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
        ];
    }
}
