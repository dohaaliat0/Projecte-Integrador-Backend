<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Events\LlamadaActualizada;

/**
 * @OA\Schema(
 *     schema="Call",
 *     description="Esquema del model Call",
 *     @OA\Property(property="id", type="integer", description="ID de la trucada", example=1),
 *     @OA\Property(property="patientId", type="integer", description="ID del pacient", example=5),
 *     @OA\Property(property="operatorId", type="integer", description="ID de l'operador", example=3),
 *     @OA\Property(property="details", type="string", description="Detalls de la trucada", example="Consulta mèdica"),
 *     @OA\Property(property="dateTime", type="string", format="date-time", description="Data i hora de la trucada", example="2025-02-20T14:30:00Z"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Data de creació del registre", example="2025-02-19T10:15:30Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Data d'actualització del registre", example="2025-02-19T12:45:00Z")
 * )
 */
class Call extends Model
{
    use HasFactory;
    protected $fillable = ['patientId', 'operatorId', 'details', 'dateTime'];


    public function operator() {
        return $this->belongsTo(User::class, 'operatorId');
    }

    public function patient() {
        return $this->belongsTo(Patient::class, 'patientId');
    }

    public function incomingCall(){
        return $this->hasOne(IncomingCall::class, 'callId');
    }

    public function outgoingCall(){
        return $this->hasOne(OutgoingCall::class, 'callId');
    }

    protected static function booted()
    {
        static::created(function ($call) {
            event(new LlamadaActualizada($call));
        });
    
        static::updated(function ($call) {
            event(new LlamadaActualizada($call));
        });
    }

}
