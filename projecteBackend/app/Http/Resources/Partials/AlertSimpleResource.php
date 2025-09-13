<?php

namespace App\Http\Resources\Partials;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlertSimpleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $zone = null;
        if($this->zone != null) {
            $zone = $this->zone->name;
        }

        return [
            'id' => $this->id,
            'operatorId' => $this->operatorId,
            'patientId' => $this->patientId,
            'zone' => $zone,
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
