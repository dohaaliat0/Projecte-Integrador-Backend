<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Language;
use App\Models\User;
use App\Enums\UserRole;
use App\Models\Language as LanguageModel;
use App\Enums\Relationship;

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
        $currentDni = $this->route('patient')->dni;
        $currentHealthCardNumber = $this->route('patient')->healthCardNumber;
        $currentMail = $this->route('patient')->email;

        return [
            'fullName' => 'required|string|max:255',
            'birthDate' => 'required|date',
            'fullAddress' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:patients,dni,' . $currentDni . ',dni',
            'healthCardNumber' => 'required|string|max:20|unique:patients,healthCardNumber,' . $currentHealthCardNumber . ',healthCardNumber',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:patients,email,' . $currentMail . ',email',
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
                    if (!$user || $user->role !== UserRole::OPERATOR->value) {
                        $fail('The selected ' . $attribute . ' is invalid.');
                    }
                },
            ],
            'languages' => [
                'required',
                'array',
                function ($attribute, $value, $fail) use ($validLanguages) {
                    if (empty($value)) {
                        $fail('The ' . $attribute . ' must have at least one element.');
                    }
                    foreach ($value as $language) {
                        if (!in_array($language, $validLanguages) && !LanguageModel::isValidId($language)) {
                            $fail('The selected ' . $attribute . ' is invalid. It failed for ' . $language);
                        }
                    }
                },
            ],
            'status' => [
                function ($attribute, $value, $fail) {
                    if (is_null($value)) {
                        $value = \App\Enums\PatientStatus::ADMITTED->value;
                    }
                    if (!in_array($value, \App\Enums\PatientStatus::values())) {
                        $fail('The selected ' . $attribute . ' is invalid. Valid status are: ' . implode(', ', \App\Enums\PatientStatus::values()));
                    }
                },
            ],
            'contactPersons' => 'nullable|array',
            'contactPersons.*.firstName' => 'required|string|max:255',
            'contactPersons.*.lastName' => 'required|string|max:255',
            'contactPersons.*.phone' => 'required|string|max:15',
            'contactPersons.*.relationship' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!in_array($value, Relationship::values())) {
                        $fail('The selected ' . $attribute . ' is invalid.');
                    }
                },
            ],
        ];
    }
}
