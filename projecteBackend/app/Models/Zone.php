<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Zone",
 *     description="Esquema del model Zone",
 *     @OA\Property(property="id", type="integer", description="ID de la zona", example=1),
 *     @OA\Property(property="name", type="string", description="Nom de la zona", example="Zona Nord"),
 *     @OA\Property(property="status", type="string", description="Estat de la zona", example="activa"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Data de creació del registre", example="2025-02-19T10:15:30Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Data d'actualització del registre", example="2025-02-19T12:45:00Z")
 * )
 */
class Zone extends Model
{
    use HasFactory;
    protected $table = 'zones';
    protected $fillable = ['name', 'status'];
    public $timestamps = true;


    
    public function operators()
    {
        return $this->belongsToMany(User::class, 'user_zone', 'zone_id', 'user_id')->where('role', 'operator');
    }

    public function patients()
    {
        return $this->hasMany(Patient::class, 'zoneId');
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class, 'zoneId');
    }
}
