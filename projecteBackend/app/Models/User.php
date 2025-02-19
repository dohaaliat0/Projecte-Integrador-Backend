<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Language;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *     schema="User",
 *     description="Esquema del model User",
 *     @OA\Property(property="id", type="integer", description="ID de l'usuari", example=1),
 *     @OA\Property(property="name", type="string", description="Nom de l'usuari", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", description="Correu electrònic de l'usuari", example="john.doe@example.com"),
 *     @OA\Property(property="password", type="string", description="Contrasenya de l'usuari", example="hashed_password"),
 *     @OA\Property(property="role", type="string", description="Rol de l'usuari", example="admin"),
 *     @OA\Property(property="surnames", type="string", description="Cognoms de l'usuari", example="Doe"),
 *     @OA\Property(property="phone", type="string", description="Telèfon de l'usuari", example="123456789"),
 *     @OA\Property(property="hireDate", type="string", format="date", description="Data de contractació de l'usuari", example="2023-01-01"),
 *     @OA\Property(property="terminationDate", type="string", format="date", description="Data de finalització del contracte de l'usuari", example="2023-12-31"),
 *     @OA\Property(property="username", type="string", description="Nom d'usuari", example="johndoe"),
 *     @OA\Property(property="google_id", type="string", description="ID de Google de l'usuari", example="1234567890"),
 *     @OA\Property(property="avatar", type="string", description="URL de l'avatar de l'usuari", example="http://example.com/avatar.jpg"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Data de creació del registre", example="2023-01-01T10:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Data d'actualització del registre", example="2023-01-01T12:00:00Z")
 * )
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'surnames',
        'phone',
        'hireDate',
        'terminationDate',
        'username',
        'google_id',
        'avatar',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'user_zone');
    }

    public function patients()
    {
        return $this->hasMany(Patient::class, 'operatorId');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'language_user');
    }
}
