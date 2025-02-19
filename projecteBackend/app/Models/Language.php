<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Language as LanguageEnum;

/**
 * @OA\Schema(
 *     schema="Language",
 *     description="Esquema del model Language",
 *     @OA\Property(property="id", type="integer", description="ID del llenguatge", example=1),
 *     @OA\Property(property="name", type="string", description="Nom del llenguatge", example="Català"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Data de creació del registre", example="2025-02-19T10:15:30Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Data d'actualització del registre", example="2025-02-19T12:45:00Z")
 * )
 */
class Language extends Model
{
    protected $fillable = ['name'];

    public function patients()
    {
        return $this->belongsToMany(Patient::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getNameAttribute($value)
    {
        return LanguageEnum::tryFrom($value)?->label() ?? $value;
    }

    public static function isValidId($id)
    {
        return self::where('id', $id)->exists();
    }
}
