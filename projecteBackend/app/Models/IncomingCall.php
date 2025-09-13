<?php

namespace App\Models;

use App\Enums\IncomingCallsType;
use App\Enums\OutgoingCallsType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="IncomingCall",
 *     description="Esquema del model IncomingCall",
 *     @OA\Property(property="callId", type="integer", description="ID de la trucada", example=1),
 *     @OA\Property(property="type", type="string", description="Tipus de trucada", example="emergència"),
 *     @OA\Property(property="emergencyLevel", type="integer", description="Nivell d'emergència", example=3)
 * )
 */
class IncomingCall extends Model
{
    use HasFactory;
    protected $fillable = ['callId', 'type', 'emergencyLevel'];
    public $timestamps = false;
    protected $primaryKey = 'callId';


    public function call() {
        return $this->belongsTo(Call::class, 'callId');
    }
}
