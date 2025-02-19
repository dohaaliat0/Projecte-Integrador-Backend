<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ZoneResource",
 *     description="Esquema del recurs Zone",
 *     @OA\Property(property="id", type="integer", description="Identificador de la zona", example=1),
 *     @OA\Property(property="name", type="string", description="Nom de la zona", example="Zona 1"),
 *     @OA\Property(property="status", type="string", description="Estat de la zona", example="activa"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Data de creació", example="2023-01-01T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Data d'actualització", example="2023-01-02T00:00:00Z"),
 *     @OA\Property(
 *         property="operators",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/OperatorResource"),
 *         description="Llista d'operadors associats a la zona"
 *     ),
 *     @OA\Property(
 *         property="patients",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/PatientResource"),
 *         description="Llista de pacients associats a la zona"
 *     ),
 *     @OA\Property(
 *         property="alerts",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/AlertResource"),
 *         description="Llista d'alertes associades a la zona"
 *     )
 * )
 */
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
