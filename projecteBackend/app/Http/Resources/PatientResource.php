<?php

namespace App\Http\Resources;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PatientResource",
 *     description="Esquema del recurs Patient",
 *     @OA\Property(property="id", type="integer", description="Identificador del pacient", example=1),
 *     @OA\Property(property="fullName", type="string", description="Nom complet del pacient", example="John Doe"),
 *     @OA\Property(property="birthDate", type="string", format="date", description="Data de naixement del pacient", example="1980-01-01"),
 *     @OA\Property(property="fullAddress", type="string", description="Adreça completa del pacient", example="123 Main St, City, Country"),
 *     @OA\Property(property="dni", type="string", description="DNI del pacient", example="12345678A"),
 *     @OA\Property(property="healthCardNumber", type="string", description="Número de targeta sanitària del pacient", example="HC123456789"),
 *     @OA\Property(property="phone", type="string", description="Telèfon del pacient", example="+123456789"),
 *     @OA\Property(property="email", type="string", format="email", description="Correu electrònic del pacient", example="johndoe@example.com"),
 *     @OA\Property(property="personalFamilySituation", type="string", description="Situació familiar personal del pacient", example="Single"),
 *     @OA\Property(property="healthSituation", type="string", description="Situació de salut del pacient", example="Healthy"),
 *     @OA\Property(property="housingSituation", type="string", description="Situació d'habitatge del pacient", example="Own house"),
 *     @OA\Property(property="personalAutonomy", type="string", description="Autonomia personal del pacient", example="Independent"),
 *     @OA\Property(property="economicSituation", type="string", description="Situació econòmica del pacient", example="Stable"),
 *     @OA\Property(property="operatorId", type="integer", description="Identificador de l'operador", example=2),
 *     @OA\Property(
 *         property="languages",
 *         type="array",
 *         description="Llengües parlades pel pacient",
 *         @OA\Items(ref="#/components/schemas/LanguageResource")
 *     ),
 *     @OA\Property(
 *         property="contactPersons",
 *         type="array",
 *         description="Persones de contacte del pacient",
 *         @OA\Items(ref="#/components/schemas/ContactPersonResource")
 *     ),
 *     @OA\Property(
 *         property="zone",
 *         ref="#/components/schemas/ZoneResource",
 *         description="Zona associada al pacient"
 *     ),
 *     @OA\Property(
 *         property="operator",
 *         ref="#/components/schemas/OperatorResource",
 *         description="Operador associat al pacient"
 *     ),
 *     @OA\Property(
 *         property="calls",
 *         type="array",
 *         description="Trucades associades al pacient",
 *         @OA\Items(ref="#/components/schemas/CallResource")
 *     )
 * )
 */
class PatientResource extends JsonResource
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
            'fullName' => $this->fullName,
            'birthDate' => $this->birthDate,
            'fullAddress' => $this->fullAddress,
            'dni' => $this->dni,
            'healthCardNumber' => $this->healthCardNumber,
            'phone' => $this->phone,
            'email' => $this->email,
            'personalFamilySituation' => $this->personalFamilySituation,
            'healthSituation' => $this->healthSituation,
            'housingSituation' => $this->housingSituation,
            'personalAutonomy' => $this->personalAutonomy,
            'economicSituation' => $this->economicSituation,
            'operatorId' => $this->operatorId,
            'languages' => LanguageResource::collection($this->languages),
            'contactPersons' => ContactPersonResource::collection($this->contactPersons),
            'zone' => new ZoneResource($this->zone),
            'operator' => new OperatorResource($this->operator),
            'calls' => CallResource::collection($this->calls),
        ];
    }
}
