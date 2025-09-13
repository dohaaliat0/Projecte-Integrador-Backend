<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreDarAltaRequest",
 *     description="Validació per a la creació d'un nou usuari",
 *     required={"name", "surnames", "email", "password"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=255,
 *         description="Nom de l'usuari",
 *         example="Toni García"
 *     ),
 *     @OA\Property(
 *         property="surnames",
 *         type="string",
 *         maxLength=255,
 *         description="Cognoms de l'usuari",
 *         example="García Pérez"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         maxLength=20,
 *         description="Telèfon de l'usuari",
 *         example="123456789"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         maxLength=255,
 *         description="Correu electrònic únic de l'usuari",
 *         example="toni.garcia@example.com"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         minLength=8,
 *         description="Contrasenya de l'usuari",
 *         example="password123"
 *     )
 * )
 */
class StoreDarAltaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'name' => 'required|string|max:255',
            'surnames' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
