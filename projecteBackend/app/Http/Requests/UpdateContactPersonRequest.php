<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateContactPersonRequest",
 *     description="Validació per a l'actualització de la persona de contacte",
 *     required={"name", "email"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=255,
 *         description="Nom de la persona de contacte",
 *         example="Toni García"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         maxLength=255,
 *         description="Correu electrònic únic de la persona de contacte",
 *         example="toni.garcia@example.com"
 *     )
 * )
 */
class UpdateContactPersonRequest extends FormRequest
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
            //
        ];
    }
}
