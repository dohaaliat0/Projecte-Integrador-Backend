<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlertRequest extends FormRequest
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
            'operatorId' => 'required|integer',
            'zoneId' => 'nullable|integer',
            'patientId' => 'required|integer',
            'isActive' => 'required|boolean',
            'type' => 'required|string',
            'isRecurring' => 'required|boolean',
            'date' => 'required|date',
            'endDate' => 'nullable|date',
            'time' => 'required|date_format:H:i:s',
            'dayOfWeek' => 'nullable|string',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];



    }
}
