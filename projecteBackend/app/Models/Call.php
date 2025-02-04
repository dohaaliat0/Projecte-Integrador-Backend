<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Call extends Model
{
    use HasFactory;
    protected $fillable = ['patientId', 'operatorId', 'details', 'dateTime'];


    public function operator() {
        return $this->belongsTo(User::class, 'operatorId');
    }

    public function patient() {
        return $this->belongsTo(Patient::class, 'patientId');
    }

    public function incomingCall(){
        return $this->hasOne(IncomingCall::class, 'callId');
    }

    public function outgoingCall(){
        return $this->hasOne(OutgoingCall::class, 'callId');
    }

}
