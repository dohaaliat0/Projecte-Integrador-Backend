<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZoneResource extends JsonResource
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
        'status' => $this->status,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
        'operators' => OperatorResource::collection($this->whenLoaded('operators')),
        'patients' => PatientResource::collection($this->whenLoaded('patients')),
        'alerts' => AlertResource::collection($this->whenLoaded('alerts')),
        ];
    }
}
