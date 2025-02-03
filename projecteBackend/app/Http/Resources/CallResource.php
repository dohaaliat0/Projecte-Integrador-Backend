<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CallResource extends JsonResource
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
            'patientId' => $this->patientId,
            'operatorId' => $this->operatorId,
            'details' => $this->details,
            'dateTime' => $this->dateTime,
            'operator' => new OperatorResource($this->whenLoaded('operator')),
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'incomingCall' => new IncomingCallResource($this->whenLoaded('incomingCall')),
            'outgoingCall' => new OutgoingCallResource($this->whenLoaded('outgoingCall')),
        ];
    }
}
