<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
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
            'operatorId' => 'required|integer|exists:operators,id',
            'language' => 'nullable|string|max:50',
        ];
    }
}
