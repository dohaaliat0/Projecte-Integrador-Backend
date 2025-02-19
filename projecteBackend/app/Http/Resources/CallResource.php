<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OperatorResource;
use App\Http\Resources\Partials\PatientSimpleResource;
use App\Models\Call;
use App\Models\IncomingCall;
use App\Models\OutgoingCall;
use App\Models\Patient;
use App\Models\User;

/**
 * @OA\Schema(
 *     schema="CallResource",
 *     description="Esquema del recurs Call",
 *     @OA\Property(property="id", type="integer", description="Identificador de la trucada", example=1),
 *     @OA\Property(property="details", type="string", description="Detalls de la trucada", example="Detalls de la trucada"),
 *     @OA\Property(property="dateTime", type="string", format="date-time", description="Data i hora de la trucada", example="2025-02-20T14:30:00Z"),
 *     @OA\Property(
 *         property="operator",
 *         ref="#/components/schemas/OperatorResource",
 *         description="Recurs de l'operador associat a la trucada"
 *     ),
 *     @OA\Property(
 *         property="patient",
 *         ref="#/components/schemas/PatientSimpleResource",
 *         description="Recurs del pacient associat a la trucada"
 *     ),
 *     @OA\Property(
 *         property="incomingCall",
 *         ref="#/components/schemas/IncomingCallResource",
 *         description="Recurs de la trucada entrant associada"
 *     ),
 *     @OA\Property(
 *         property="outgoingCall",
 *         ref="#/components/schemas/OutgoingCallResource",
 *         description="Recurs de la trucada sortint associada"
 *     )
 * )
 */
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
            'details' => $this->details,
            'dateTime' => $this->dateTime,
            'operator' => new OperatorResource(User::find($this->operatorId)),
            'patient' => new PatientSimpleResource(Patient::find($this->patientId)),
            'incomingCall' => new IncomingCallResource(IncomingCall::where('callId', $this->id)->first()),
            'outgoingCall' => new OutgoingCallResource(OutgoingCall::where('callId', $this->id)->first()),
        ];
    }
}
