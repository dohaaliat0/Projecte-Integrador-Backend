<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ContactPerson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Language;


/**
 * @OA\Schema(
 *     schema="Patient",
 *     description="Esquema del model Patient",
 *     @OA\Property(property="id", type="integer", description="ID del pacient", example=1),
 *     @OA\Property(property="fullName", type="string", description="Nom complet del pacient", example="John Doe"),
 *     @OA\Property(property="birthDate", type="string", format="date", description="Data de naixement del pacient", example="1980-01-01"),
 *     @OA\Property(property="fullAddress", type="string", description="Adreça completa del pacient", example="123 Main St, City, Country"),
 *     @OA\Property(property="dni", type="string", description="DNI del pacient", example="12345678A"),
 *     @OA\Property(property="healthCardNumber", type="string", description="Número de targeta sanitària del pacient", example="HC123456789"),
 *     @OA\Property(property="phone", type="string", description="Telèfon del pacient", example="+123456789"),
 *     @OA\Property(property="email", type="string", description="Correu electrònic del pacient", example="johndoe@example.com"),
 *     @OA\Property(property="zoneId", type="integer", description="ID de la zona", example=2),
 *     @OA\Property(property="personalFamilySituation", type="string", description="Situació familiar personal del pacient", example="Single"),
 *     @OA\Property(property="healthSituation", type="string", description="Situació de salut del pacient", example="Good"),
 *     @OA\Property(property="housingSituation", type="string", description="Situació d'habitatge del pacient", example="Own house"),
 *     @OA\Property(property="personalAutonomy", type="string", description="Autonomia personal del pacient", example="Independent"),
 *     @OA\Property(property="economicSituation", type="string", description="Situació econòmica del pacient", example="Stable"),
 *     @OA\Property(property="operatorId", type="integer", description="ID de l'operador", example=3),
 *     @OA\Property(property="language", type="string", description="Idioma del pacient", example="English"),
 *     @OA\Property(property="status", type="string", description="Estat del pacient", example="Active"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Data de creació del registre", example="2025-02-19T10:15:30Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Data d'actualització del registre", example="2025-02-19T12:45:00Z")
 * )
 */
class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'fullName',
        'birthDate',
        'fullAddress',
        'dni',
        'healthCardNumber',
        'phone',
        'email',
        'zoneId',
        'personalFamilySituation',
        'healthSituation',
        'housingSituation',
        'personalAutonomy',
        'economicSituation',
        'operatorId',
        'language',
        'status'
    ];

    // public function casts()
    // {
    //     return [
    //         'language' => Language::class,
    //     ];
    // }

    public function contactPersons()
    {
        return $this->hasMany(ContactPerson::class, 'patientId');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zoneId');
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operatorId');
    }

    public function calls()
    {
        return $this->hasMany(Call::class, 'patientId');
    }

    
}
