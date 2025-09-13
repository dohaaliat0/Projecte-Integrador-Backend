<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Relationship;
use App\Models\Patient;


/**
 * @OA\Schema(
 *     schema="ContactPerson",
 *     description="Esquema del model ContactPerson",
 *     @OA\Property(property="id", type="integer", description="ID de la persona de contacte", example=1),
 *     @OA\Property(property="firstName", type="string", description="Nom de la persona de contacte", example="John"),
 *     @OA\Property(property="lastName", type="string", description="Cognom de la persona de contacte", example="Doe"),
 *     @OA\Property(property="phone", type="string", description="Telèfon de la persona de contacte", example="+123456789"),
 *     @OA\Property(property="relationship", type="string", description="Relació amb el pacient", example="Germà"),
 *     @OA\Property(property="patientId", type="integer", description="ID del pacient associat", example=5),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Data de creació del registre", example="2025-02-19T10:15:30Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Data d'actualització del registre", example="2025-02-19T12:45:00Z")
 * )
 */
class ContactPerson extends Model
{
    protected $table = 'contactPeople';
    protected $fillable = [
        'firstName',
        'lastName',
        'phone',
        'relationship',
        'patientId',
    ];

    public function casts()
    {
        return [
            'relationship' => Relationship::class,
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientId');
    }
}
