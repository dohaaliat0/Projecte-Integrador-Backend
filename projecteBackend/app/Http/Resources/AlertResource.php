<?php

namespace App\Http\Resources;

use App\Http\Resources\Partials\PatientSimpleResource;
use App\Models\Patient;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="AlertResource",
 *     description="Esquema del recurs Alert",
 *     @OA\Property(property="id", type="integer", description="Identificador de l'alerta", example=1),
 *     @OA\Property(property="operatorId", type="integer", description="Identificador de l'operador", example=2),
 *     @OA\Property(
 *         property="operator",
 *         ref="#/components/schemas/OperatorResource",
 *         description="Recurs de l'operador associat a l'alerta"
 *     ),
 *     @OA\Property(property="patientId", type="integer", description="Identificador del pacient", example=5),
 *     @OA\Property(
 *         property="patient",
 *         ref="#/components/schemas/PatientSimpleResource",
 *         description="Recurs del pacient associat a l'alerta"
 *     ),
 *     @OA\Property(property="zoneId", type="integer", nullable=true, description="Identificador de la zona", example=3),
 *     @OA\Property(
 *         property="zone",
 *         ref="#/components/schemas/ZoneResource",
 *         description="Recurs de la zona associada a l'alerta"
 *     ),
 *     @OA\Property(property="isActive", type="boolean", description="Estat actiu de l'alerta", example=true),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="Tipus d'alerta",
 *         example="mèdica"
 *     ),
 *     @OA\Property(property="isRecurring", type="boolean", description="Indica si l'alerta és recurrent", example=false),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date",
 *         description="Data de l'alerta",
 *         example="2025-02-20"
 *     ),
 *     @OA\Property(
 *         property="endDate",
 *         type="string",
 *         format="date",
 *         nullable=true,
 *         description="Data de finalització de l'alerta (si és recurrent)",
 *         example="2025-03-20"
 *     ),
 *     @OA\Property(
 *         property="time",
 *         type="string",
 *         format="time",
 *         description="Hora de l'alerta",
 *         example="14:30:00"
 *     ),
 *     @OA\Property(
 *         property="dayOfWeek",
 *         type="array",
 *         description="Dies de la setmana per a alertes recurrents",
 *         @OA\Items(type="string", enum={"dilluns", "dimarts", "dimecres", "dijous", "divendres", "dissabte", "diumenge"}),
 *         example={"dilluns", "dimecres", "divendres"}
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         nullable=true,
 *         description="Descripció de l'alerta",
 *         example="Visita mèdica programada"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Títol de l'alerta",
 *         example="Control de tensió"
 *     )
 * )
 */
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
