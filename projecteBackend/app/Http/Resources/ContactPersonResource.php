<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ContactPersonResource",
 *     description="Esquema del recurs ContactPerson",
 *     @OA\Property(property="id", type="integer", description="Identificador de la persona de contacte", example=1),
 *     @OA\Property(property="firstName", type="string", description="Nom de la persona de contacte", example="John"),
 *     @OA\Property(property="lastName", type="string", description="Cognom de la persona de contacte", example="Doe"),
 *     @OA\Property(property="phone", type="string", description="Telèfon de la persona de contacte", example="+123456789"),
 *     @OA\Property(property="relationship", type="string", description="Relació amb el pacient", example="Germà"),
 *     @OA\Property(
 *         property="patient",
 *         ref="#/components/schemas/PatientResource",
 *         description="Recurs del pacient associat a la persona de contacte"
 *     )
 * )
 */
class ContactPersonResource extends JsonResource
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
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'phone' => $this->phone,
            'relationship' => $this->relationship,
            'patient' => new PatientResource($this->whenLoaded('patient')),
        ];
    }
}
