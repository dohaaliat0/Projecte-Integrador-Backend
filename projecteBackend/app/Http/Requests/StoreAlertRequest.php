<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreAlertRequest",
 *     description="Validació per a la creació d'una alerta",
 *     required={"operatorId", "patientId", "type", "isRecurring", "date", "time", "title"},
 *     @OA\Property(
 *         property="operatorId",
 *         type="integer",
 *         description="ID de l'operador",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="patientId",
 *         type="integer",
 *         description="ID del pacient",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="isActive",
 *         type="boolean",
 *         description="Indica si l'alerta està activa",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="Tipus d'alerta",
 *         example="emergency"
 *     ),
 *     @OA\Property(
 *         property="isRecurring",
 *         type="boolean",
 *         description="Indica si l'alerta és recurrent",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date",
 *         description="Data de l'alerta",
 *         example="2023-10-01"
 *     ),
 *     @OA\Property(
 *         property="endDate",
 *         type="string",
 *         format="date",
 *         description="Data de finalització de l'alerta",
 *         example="2023-10-02"
 *     ),
 *     @OA\Property(
 *         property="time",
 *         type="string",
 *         format="time",
 *         description="Hora de l'alerta",
 *         example="14:30:00"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         maxLength=255,
 *         description="Títol de l'alerta",
 *         example="Reunió amb el metge"
 *     ),
 *     @OA\Property(
 *         property="dayOfWeek",
 *         type="array",
 *         @OA\Items(type="string"),
 *         description="Dies de la setmana per a l'alerta recurrent",
 *         example={"Monday", "Wednesday"}
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Descripció de l'alerta",
 *         example="Reunió de seguiment amb el metge"
 *     )
 * )
 */
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
                'sometimes',
                'boolean',
                function ($attribute, $value, $fail) {
                    $this->merge(['isActive' => true]);
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
            'title' => 'required|string|max:255',
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
