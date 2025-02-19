<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\IncomingCallsType;
use App\Enums\OutgoingCallsType;
use Carbon\Carbon;

/**
 * @OA\Schema(
 *     schema="UpdateCallRequest",
 *     description="Validació per a l'actualització de trucades",
 *     required={"patientId", "operatorId", "details", "dateTime"},
 *     @OA\Property(
 *         property="patientId",
 *         type="integer",
 *         description="ID del pacient",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="operatorId",
 *         type="integer",
 *         description="ID de l'operador",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="details",
 *         type="string",
 *         description="Detalls de la trucada",
 *         example="Detalls de la trucada"
 *     ),
 *     @OA\Property(
 *         property="dateTime",
 *         type="string",
 *         format="date-time",
 *         description="Data i hora de la trucada",
 *         example="2023-10-01 12:00:00"
 *     ),
 *     @OA\Property(
 *         property="incomingCall",
 *         type="object",
 *         description="Detalls de la trucada entrant",
 *         @OA\Property(
 *             property="type",
 *             type="string",
 *             description="Tipus de trucada entrant",
 *             example="emergency"
 *         ),
 *         @OA\Property(
 *             property="emergencyLevel",
 *             type="integer",
 *             description="Nivell d'emergència de la trucada entrant",
 *             example=3
 *         )
 *     ),
 *     @OA\Property(
 *         property="outgoingCall",
 *         type="object",
 *         description="Detalls de la trucada sortint",
 *         @OA\Property(
 *             property="type",
 *             type="string",
 *             description="Tipus de trucada sortint",
 *             example="follow-up"
 *         ),
 *         @OA\Property(
 *             property="alertId",
 *             type="integer",
 *             description="ID de l'alerta associada",
 *             example=5
 *         )
 *     )
 * )
 */
class UpdateCallRequest extends FormRequest
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

        $this->merge([
            'dateTime' => Carbon::parse($this->input('dateTime'))->format('Y-m-d H:i:s'),
        ]);
        return [
            'patientId' => 'required|exists:patients,id',
            'operatorId' => 'required|exists:users,id',
            'details' => 'required|string',
            'dateTime' => 'required|date',
            'incomingCall' => 'required_without:outgoingCall|array',
            'incomingCall.type' => [
                'required_with:incomingCall',
                function ($attribute, $value, $fail) {
                    if (!in_array($value, IncomingCallsType::values())) {
                        $fail('The selected ' . $attribute . ' is invalid. Valid values are: [' . implode(', ', IncomingCallsType::values()) . ']');
                    }
                },
            ],
            'incomingCall.emergencyLevel' => 'required_with:incomingCall|integer|min:1|max:5',
            'outgoingCall' => 'required_without:incomingCall|array',
            'outgoingCall.type' => [
                'required_with:outgoingCall',
                function ($attribute, $value, $fail) {
                    if (!in_array($value, OutgoingCallsType::values())) {
                        $fail('The selected ' . $attribute . ' is invalid. Valid values are: [' . implode(', ', OutgoingCallsType::values()) . ']');
                    }
                },
            ],
            'outgoingCall.alertId' => 'nullable|exists:alerts,id',
        ];
    }
}
