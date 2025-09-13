<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateDasAltaAntiguoRequest",
 *     description="Validació per a l'actualització de Das Alta Antiguo",
 *     required={"user_id"},
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="ID de l'usuari",
 *         example=1
 *     )
 * )
 */
class UpdateDasAltaAntiguoRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
