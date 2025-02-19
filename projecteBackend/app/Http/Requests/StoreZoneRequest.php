<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\TypeZones;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;

/**
 * @OA\Schema(
 *     schema="StoreZoneRequest",
 *     description="Validació per a la creació d'una zona",
 *     required={"name", "status"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=255,
 *         description="Nom de la zona",
 *         example="Zona Nord"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Estat de la zona",
 *         example="active"
 *     )
 * )
 */
class StoreZoneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role === UserRole::COORDINATOR->value;
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
            'status' => ['required', 'string', Rule::in(TypeZones::values())],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo nombre es obligatorio',
            'name.string' => 'El campo nombre debe ser un texto',
            'name.max' => 'El campo nombre no debe exceder los 255 caracteres',
            'status.required' => 'El campo estado es obligatorio',
            'status.string' => 'El campo estado debe ser un texto',
            'status.in' => 'El campo estado no es válido',
        ];
    }
}
