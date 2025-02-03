<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Relationship;
use App\Models\Patient;

class ContactPerson extends Model
{
    protected $table = 'contactPeople';
    protected $fillable = [
        'firstName',
        'lastName',
        'phone',
        'relationship',
        'patientId',
    ];

    public function casts()
    {
        return [
            'relationship' => Relationship::class,
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientId');
    }
}
