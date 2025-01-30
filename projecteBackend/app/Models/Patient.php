<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ContactPerson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\Language;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'fullName',
        'birthDate',
        'fullAddress',
        'dni',
        'healthCardNumber',
        'phone',
        'email',
        'zoneId',
        'personalFamilySituation',
        'healthSituation',
        'housingSituation',
        'personalAutonomy',
        'economicSituation',
        'operatorId',
        'language',
    ];

    public function casts()
    {
        return [
            'language' => Language::class,
        ];
    }

    public function contactPersons()
    {
        return $this->hasMany(ContactPerson::class);
    }
}
