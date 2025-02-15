<?php

namespace App\Http\Resources;

use App\Http\Resources\Partials\PatientSimpleResource;
use App\Models\Patient;
use App\Models\User;
use App\Models\Zone;
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
        $zone = null;
        if($this->zoneId == null){
            $zone = null;
        }else{
            $zone = Zone::find($this->zoneId);
        }

        return [
            'id' => $this->id,
            'operatorId' => $this->operatorId,
            'operator' => new OperatorResource(User::find($this->operatorId)),
            'patientId' => $this->patientId,
            'patient' => new PatientSimpleResource(Patient::find($this->patientId)),
            'zoneId' => $this->zoneId, 
            'zone' => new ZoneResource($zone),
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
