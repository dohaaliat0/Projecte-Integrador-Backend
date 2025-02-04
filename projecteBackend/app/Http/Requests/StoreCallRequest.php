<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\IncomingCallsType;
use App\Enums\OutgoingCallsType;
use Carbon\Carbon;

class StoreCallRequest extends FormRequest
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
            'dateTime' => 'required|date|after_or_equal:today',
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
