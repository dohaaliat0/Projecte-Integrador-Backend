<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OperatorResource;
use App\Http\Resources\Partials\PatientSimpleResource;
use App\Models\Call;
use App\Models\IncomingCall;
use App\Models\OutgoingCall;
use App\Models\Patient;
use App\Models\User;

class CallResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'details' => $this->details,
            'dateTime' => $this->dateTime,
            'operator' => new OperatorResource(User::find($this->operatorId)),
            'patient' => new PatientSimpleResource(Patient::find($this->patientId)),
            'incomingCall' => new IncomingCallResource(IncomingCall::where('callId', $this->id)->first()),
            'outgoingCall' => new OutgoingCallResource(OutgoingCall::where('callId', $this->id)->first()),
        ];
    }
}
