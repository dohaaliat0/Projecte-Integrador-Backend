<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Language;
use App\Models\User;
use App\Enums\UserRole;

class UpdatePatientRequest extends FormRequest
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
        $validLanguages = Language::values();
        return [
            'fullName' => 'required|string|max:255',
            'birthDate' => 'required|date',
            'fullAddress' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:patients,dni',
            'healthCardNumber' => 'required|string|max:20|unique:patients,healthCardNumber',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:patients,email',
            'zoneId' => 'required|integer|exists:zones,id',
            'personalFamilySituation' => 'nullable|string',
            'healthSituation' => 'nullable|string',
            'housingSituation' => 'nullable|string',
            'personalAutonomy' => 'nullable|string',
            'economicSituation' => 'nullable|string',
            'operatorId' => [
                'required',
                'integer',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = User::find($value);
                    if (!$user || $user->role !== UserRole::OPERATOR) {
                        $fail('The selected ' . $attribute . ' is invalid.');
                    }
                },
            ],
            //Si da problemas comentadlo de momento
            'languages' => [
                'required',
                'array',
                function ($attribute, $value, $fail) use ($validLanguages) {
                    if (empty($value)) {
                        $fail('The ' . $attribute . ' must have at least one element.');
                    }
                    foreach ($value as $language) {
                        if (!in_array($language, $validLanguages)) {
                            $fail('The selected ' . $attribute . ' is invalid.');
                        }
                    }
                },
            ],
        ];
    }
}
