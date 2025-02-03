<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OperatorResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'surnames' => $this->surnames,
            'phone' => $this->phone,
            'hireDate' => $this->hireDate,
            'terminationDate' => $this->terminationDate,
            'zones' => ZoneResource::collection($this->whenLoaded('zones')),
            'patients' => PatientResource::collection($this->whenLoaded('patients')),
            'languages' => LanguageResource::collection($this->whenLoaded('languages')),
        ];
    }
}
