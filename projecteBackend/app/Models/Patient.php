<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ContactPerson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Language;

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

    // public function casts()
    // {
    //     return [
    //         'language' => Language::class,
    //     ];
    // }

    public function contactPersons()
    {
        return $this->hasMany(ContactPerson::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function operator()
    {
        return $this->belongsTo(User::class);
    }

    public function calls()
    {
        return $this->hasMany(Call::class);
    }
}
