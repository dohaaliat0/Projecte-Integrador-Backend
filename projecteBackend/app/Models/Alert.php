<?php

namespace App\Models;

use App\Enums\DayOfWeek;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="Alert",
 *     description="Esquema del model Alert",
 *     @OA\Property(property="id", type="integer", description="ID de l'alerta", example=1),
 *     @OA\Property(property="operatorId", type="integer", description="ID de l'operador", example=3),
 *     @OA\Property(property="zoneId", type="integer", description="ID de la zona", example=2),
 *     @OA\Property(property="patientId", type="integer", description="ID del pacient", example=5),
 *     @OA\Property(property="isActive", type="boolean", description="Indica si l'alerta està activa", example=true),
 *     @OA\Property(property="type", type="string", description="Tipus d'alerta", example="caiguda"),
 *     @OA\Property(property="isRecurring", type="boolean", description="Indica si l'alerta és recurrent", example=false),
 *     @OA\Property(property="date", type="string", format="date", description="Data de l'alerta", example="2025-02-20"),
 *     @OA\Property(property="endDate", type="string", format="date", description="Data de finalització de l'alerta", example="2025-02-25"),
 *     @OA\Property(property="time", type="string", format="time", description="Hora de l'alerta", example="14:30"),
 *     @OA\Property(
 *         property="dayOfWeek",
 *         type="array",
 *         description="Dies de la setmana en què es repeteix l'alerta",
 *         @OA\Items(type="string", example="Monday")
 *     ),
 *     @OA\Property(property="title", type="string", description="Títol de l'alerta", example="Revisió mèdica"),
 *     @OA\Property(property="description", type="string", description="Descripció de l'alerta", example="Recordatori per la visita al metge."),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Data de creació del registre", example="2025-02-19T10:15:30Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Data d'actualització del registre", example="2025-02-19T12:45:00Z")
 * )
 */
class Alert extends Model
{

    use HasFactory;
    protected $fillable = ['operatorId', 'zoneId', 'patientId', 'isActive',  'type', 'isRecurring', 'date', 'endDate', 'time', 'dayOfWeek','title', 'description'];

    // public function casts(){
    //     [
    //         'dayOfWeek' => DayOfWeek::class . '|null',
    //     ];
    // }
    protected $casts = [
        'dayOfWeek' => 'array',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function zone() {
        return $this->belongsTo(Zone::class);
    }

    public function patient() {
        return $this->belongsTo(Patient::class, 'patientId');
    }

    public function outgoingCall() {
        return $this->hasMany(OutgoingCall::class, 'alertId');
    }


}
