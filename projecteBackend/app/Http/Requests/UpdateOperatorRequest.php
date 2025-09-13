<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\UserRole;


/**
 * @OA\Schema(
 *     schema="UpdateOperatorRequest",
 *     description="Validació per a l'actualització de l'operador",
 *     required={"name", "email", "password", "role", "surnames", "hireDate", "username"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=255,
 *         description="Nom de l'operador",
 *         example="Toni García"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         maxLength=255,
 *         description="Correu electrònic únic de l'operador",
 *         example="toni.garcia@example.com"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         minLength=8,
 *         description="Contrasenya de l'operador",
 *         example="password123"
 *     ),
 *     @OA\Property(
 *         property="role",
 *         type="string",
 *         description="Rol de l'operador",
 *         example="operator"
 *     ),
 *     @OA\Property(
 *         property="surnames",
 *         type="string",
 *         maxLength=255,
 *         description="Cognoms de l'operador",
 *         example="García López"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         maxLength=20,
 *         description="Telèfon de l'operador",
 *         example="123456789"
 *     ),
 *     @OA\Property(
 *         property="hireDate",
 *         type="string",
 *         format="date",
 *         description="Data de contractació de l'operador",
 *         example="2023-01-01"
 *     ),
 *     @OA\Property(
 *         property="terminationDate",
 *         type="string",
 *         format="date",
 *         description="Data de finalització de contracte de l'operador",
 *         example="2023-12-31"
 *     ),
 *     @OA\Property(
 *         property="username",
 *         type="string",
 *         maxLength=255,
 *         description="Nom d'usuari únic de l'operador",
 *         example="toni.garcia"
 *     )
 * )
 */
class UpdateOperatorRequest extends FormRequest
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
        $id = $this->route(param: 'operator');

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:'.UserRole::OPERATOR->value,
            'surnames' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'hireDate' => 'required|date',
            'terminationDate' => 'nullable|date|after:hireDate',
            'username' => 'required|string|max:255|unique:users',
        ];
    }
}
