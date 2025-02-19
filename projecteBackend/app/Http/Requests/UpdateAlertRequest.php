<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateAlertRequest",
 *     description="Validation for updating an alert",
 *     required={"id", "time"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier of the alert",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="operatorId",
 *         type="integer",
 *         description="Identifier of the operator",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="patientId",
 *         type="integer",
 *         description="Identifier of the patient",
 *         example=3
 *     ),
 *     @OA\Property(
 *         property="isActive",
 *         type="boolean",
 *         description="Status of the alert",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="Type of the alert",
 *         example="emergency"
 *     ),
 *     @OA\Property(
 *         property="isRecurring",
 *         type="boolean",
 *         description="Whether the alert is recurring",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date",
 *         description="Date of the alert",
 *         example="2023-10-01"
 *     ),
 *     @OA\Property(
 *         property="endDate",
 *         type="string",
 *         format="date",
 *         description="End date of the alert",
 *         example="2023-10-02"
 *     ),
 *     @OA\Property(
 *         property="time",
 *         type="string",
 *         format="time",
 *         description="Time of the alert",
 *         example="14:30:00"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         maxLength=255,
 *         description="Title of the alert",
 *         example="Doctor Appointment"
 *     ),
 *     @OA\Property(
 *         property="dayOfWeek",
 *         type="array",
 *         @OA\Items(
 *             type="string",
 *             description="Day of the week",
 *             example="Monday"
 *         ),
 *         description="Days of the week for recurring alerts"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the alert",
 *         example="Monthly check-up"
 *     )
 * )
 */
class UpdateAlertRequest extends FormRequest
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
        $id = $this->route('alert')->id;
        return [
            'id' => 'required|integer|in:' . $id,
            'operatorId' => 'sometimes|integer',
            'patientId' => 'sometimes|integer',
            'isActive' => [
                'sometimes',
                'boolean',
                function ($attribute, $value, $fail) {
                    $this->merge(['isActive' => true]);
                },
            ],
            'type' => [
                'sometimes',
                'string',
                function ($attribute, $value, $fail) {
                    $validTypes = \App\Enums\AlertType::values();
                    if (!in_array($value, $validTypes)) {
                        $fail("The $attribute field contains an invalid type: $value. Valid types are: " . implode(', ', $validTypes));
                    }
                },
            ],
            'isRecurring' => [
                'sometimes',
                'boolean',
                function ($attribute, $value, $fail) {
                    $endDate = $this->input('endDate');
                    if ($value && is_null($endDate)) {
                        $fail('The isRecurring field can only be true if endDate is provided.');
                    }
                },
            ],
            'date' => 'sometimes|date',
            'endDate' => 'nullable|date|after_or_equal:date',
            'time' => [
                'required',
                'regex:/^\d{2}:\d{2}(:\d{2})?$/',
                function ($attribute, $value, $fail) {
                    if (preg_match('/^\d{2}:\d{2}$/', $value)) {
                        $this->merge([$attribute => $value . ':00']);
                    } elseif (!preg_match('/^\d{2}:\d{2}:\d{2}$/', $value)) {
                        $fail('The time format is invalid. It should be H:i or H:i:s.');
                    }
                },
            ],
            'title' => 'sometimes|string|max:255',
            'dayOfWeek' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    $validDays = \App\Enums\DayOfWeek::values();
                    $days = is_array($value) ? $value : explode(', ', $value);
                    foreach ($days as $day) {
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
