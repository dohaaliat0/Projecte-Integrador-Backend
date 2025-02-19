<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="LanguageResource",
 *     description="Esquema del recurs Language",
 *     @OA\Property(property="id", type="integer", description="Identificador de l'idioma", example=1),
 *     @OA\Property(property="name", type="string", description="Nom de l'idioma", example="Català")
 * )
 */
class LanguageResource extends JsonResource
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
        ];
    }
}
