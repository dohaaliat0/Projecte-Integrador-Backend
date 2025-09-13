<?php

namespace App\Http\Resources\Partials;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PatientSimpleResource",
 *     description="Informació simplificada del pacient",
 *     @OA\Property(property="id", type="integer", description="Identificador del pacient", example=12),
 *     @OA\Property(property="fullName", type="string", description="Nom complet del pacient", example="Ana García López"),
 *     @OA\Property(property="birthDate", type="string", format="date", description="Data de naixement", example="1985-07-22"),
 *     @OA\Property(property="fullAddress", type="string", description="Adreça completa", example="Carrer Major, 45, 2n A, Alcoi, 03801"),
 *     @OA\Property(property="dni", type="string", description="DNI del pacient", example="12345678A"),
 *     @OA\Property(property="healthCardNumber", type="string", description="Número de la targeta sanitària", example="SIP87654321"),
 *     @OA\Property(property="phone", type="string", description="Número de telèfon", example="+34 654 321 987"),
 *     @OA\Property(property="email", type="string", format="email", description="Correu electrònic", example="ana.garcia@example.com"),
 *     @OA\Property(property="personalFamilySituation", type="string", description="Situació personal i familiar", example="Viu sola, té dos fills que viuen a prop."),
 *     @OA\Property(property="healthSituation", type="string", description="Situació de salut", example="Diabetis tipus 2 controlada amb medicació."),
 *     @OA\Property(property="housingSituation", type="string", description="Situació d'habitatge", example="Habitatge propi amb ascensor."),
 *     @OA\Property(property="personalAutonomy", type="string", description="Autonomia personal", example="Autònoma per a activitats bàsiques, necessita ajuda per a la compra."),
 *     @OA\Property(property="economicSituation", type="string", description="Situació econòmica", example="Pensió contributiva de 800€ mensuals."),
 * )
 */
class PatientSimpleResource extends JsonResource
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
        ];
    }
}
