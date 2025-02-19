<?php

namespace App\Models;

use App\Enums\OutgoingCallsType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="OutgoingCall",
 *     description="Esquema del model OutgoingCall",
 *     @OA\Property(property="callId", type="integer", description="ID de la trucada", example=1),
 *     @OA\Property(property="type", type="string", description="Tipus de trucada", example="emergency"),
 *     @OA\Property(property="alertId", type="integer", description="ID de l'alerta associada", example=2),
 * )
 */
class OutgoingCall extends Model
{
    use HasFactory;
    protected $fillable = ['callId', 'type', 'alertId'];
    public $timestamps = false;
    protected $primaryKey = 'callId';



    public function call() {
        return $this->belongsTo(Call::class, 'callId');
    }

    public function alert() {
        return $this->belongsTo(Alert::class, 'alertId');
    }
}
