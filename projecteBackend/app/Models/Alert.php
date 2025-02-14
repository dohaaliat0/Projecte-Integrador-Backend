<?php

namespace App\Models;

use App\Enums\DayOfWeek;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{

    use HasFactory;
    protected $fillable = ['operatorId', 'zoneId', 'patientId', 'isActive',  'type', 'isRecurring', 'date', 'endDate', 'time', 'dayOfWeek','title', 'description'];

    // public function casts(){
    //     [
    //         'dayOfWeek' => DayOfWeek::class . '|null',
    //     ];
    // }
    protected $casts = [
        'dayOfWeek' => 'array',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function zone() {
        return $this->belongsTo(Zone::class);
    }

    public function patient() {
        return $this->belongsTo(Patient::class, 'patientId');
    }

    public function outgoingCall() {
        return $this->hasMany(OutgoingCall::class, 'alertId');
    }


}
