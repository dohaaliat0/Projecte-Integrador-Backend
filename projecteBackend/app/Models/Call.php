<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Events\LlamadaActualizada;


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

    protected static function booted()
    {
        static::created(function ($call) {
            dd($call);
            event(new LlamadaActualizada($call));
        });
    
        static::updated(function ($call) {
            dd($call);
            event(new LlamadaActualizada($call));
        });
    }

}
