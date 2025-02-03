<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OutgoingCallResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'callId' => $this->callId,
            'type' => $this->type,
            'alertId' => new AlertResource($this->whenLoaded('alert')),
        ];
    }
}
