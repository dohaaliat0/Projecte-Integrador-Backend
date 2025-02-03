<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlertResource extends JsonResource
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
            'operator' => new OperatorResource($this->operator),
            'patient' => new PatientResource($this->patient), 
            'zone' => $this->zone->name,
            'isActive' => $this->isActive,
            'type' => $this->type,
            'isRecurring' => $this->isRecurring,
            'date' => $this->date,
            'endDate' => $this->endDate,
            'time' => $this->time,
            'dayOfWeek' => $this->dayOfWeek,
            'description' => $this->description,
            'title' => $this->title,
        ];
    }
}
