<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientHistory extends Model
{
    protected $fillable = ['dateTime', 'user_id', 'patient_id', 'call_id'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    
}