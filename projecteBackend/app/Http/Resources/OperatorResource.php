<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="OperatorResource",
 *     description="Esquema del recurs Operator",
 *     @OA\Property(property="id", type="integer", description="Identificador de l'operador", example=1),
 *     @OA\Property(property="name", type="string", description="Nom de l'operador", example="John Doe"),
 *     @OA\Property(property="email", type="string", description="Correu electrònic de l'operador", example="john.doe@example.com"),
 *     @OA\Property(property="role", type="string", description="Rol de l'operador", example="admin"),
 *     @OA\Property(property="surnames", type="string", description="Cognoms de l'operador", example="Doe"),
 *     @OA\Property(property="phone", type="string", description="Telèfon de l'operador", example="123456789"),
 *     @OA\Property(property="hireDate", type="string", format="date", description="Data de contractació de l'operador", example="2022-01-01"),
 *     @OA\Property(property="terminationDate", type="string", format="date", nullable=true, description="Data de finalització de l'operador", example="2023-01-01"),
 *     @OA\Property(
 *         property="zones",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ZoneResource"),
 *         description="Zones associades a l'operador"
 *     ),
 *     @OA\Property(
 *         property="patients",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/PatientResource"),
 *         description="Pacients associats a l'operador"
 *     ),
 *     @OA\Property(
 *         property="languages",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/LanguageResource"),
 *         description="Idiomes parlats per l'operador"
 *     )
 * )
 */
class OperatorResource extends JsonResource
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
            'email' => $this->email,
            'role' => $this->role,
            'surnames' => $this->surnames,
            'phone' => $this->phone,
            'hireDate' => $this->hireDate,
            'terminationDate' => $this->terminationDate,
            'zones' => ZoneResource::collection($this->whenLoaded('zones')),
            'patients' => PatientResource::collection($this->whenLoaded('patients')),
            'languages' => LanguageResource::collection($this->whenLoaded('languages')),
        ];
    }
}
