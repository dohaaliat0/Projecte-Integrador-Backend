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
            'patientId' => 'required|integer',
            'isActive' => [
                'required',
                'boolean',
                function ($attribute, $value, $fail) {
                    $date = $this->input('date');
                    $endDate = $this->input('endDate');
                    if ($value && ($date > now() || ($endDate && $endDate < now()) || (!$endDate && $date != now()->toDateString()))) {
                        $fail('The isActive field can only be true if the current date is between date and endDate, or if endDate is not provided, it must be the same as date.');
                    }
                },
            ],
            'type' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $validTypes = \App\Enums\AlertType::values();
                    if (!in_array($value, $validTypes)) {
                        $fail("The $attribute field contains an invalid type: $value. Valid types are: " . implode(', ', $validTypes));
                    }
                },
            ],
            'isRecurring' => [
                'required',
                'boolean',
                function ($attribute, $value, $fail) {
                    $endDate = $this->input('endDate');
                    if ($value && is_null($endDate)) {
                        $fail('The isRecurring field can only be true if endDate is provided.');
                    }
                },
            ],
            'date' => 'required|date',
            'endDate' => 'nullable|date|after_or_equal:date',
            'time' => 'required|date_format:H:i:s',
            'title' => 'required|string|max:255',
            'dayOfWeek' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) {
                    $validDays = \App\Enums\DayOfWeek::values();
                    foreach ($value as $day) {
                        if (!in_array($day, $validDays)) {
                            $fail("The $attribute field contains an invalid day: $day. Valid days are: " . implode(', ', $validDays));
                        }
                    }
                },
            ],
            'description' => 'nullable|string',
        ];



    }
}
