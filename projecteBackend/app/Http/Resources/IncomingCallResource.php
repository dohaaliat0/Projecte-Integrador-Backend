<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="IncomingCallResource",
 *     description="Esquema del recurs IncomingCall",
 *     @OA\Property(property="callId", type="integer", description="Identificador de la trucada", example=1),
 *     @OA\Property(property="type", type="string", description="Tipus de trucada", example="emergència"),
 *     @OA\Property(property="emergencyLevel", type="integer", description="Nivell d'emergència", example=3)
 * )
 */
class IncomingCallResource extends JsonResource
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
            'emergencyLevel' => $this->emergencyLevel,
        ];
    }
}
