<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;
use App\Enums\TypeZones;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateZoneRequest",
 *     description="Validació per a l'actualització de la zona",
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
class UpdateZoneRequest extends FormRequest
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
}
