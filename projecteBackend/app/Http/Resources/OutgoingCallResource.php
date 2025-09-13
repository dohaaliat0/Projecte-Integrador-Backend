<?php

namespace App\Http\Resources;

use App\Models\Alert;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="OutgoingCallResource",
 *     description="Esquema del recurs OutgoingCall",
 *     @OA\Property(property="callId", type="integer", description="Identificador de la trucada", example=1),
 *     @OA\Property(property="type", type="string", description="Tipus de trucada", example="emergència"),
 *     @OA\Property(
 *         property="alert",
 *         ref="#/components/schemas/AlertResource",
 *         description="Recurs de l'alerta associada a la trucada"
 *     )
 * )
 */
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
            'alert' => new AlertResource(Alert::find($this->alertId)),
        ];
    }
}
