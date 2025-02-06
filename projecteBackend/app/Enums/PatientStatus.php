<?php

namespace App\Enums;

enum PatientStatus: string
{
    case ADMITTED = 'Admitted';
    case DISCHARGED = 'Discharged';
    case IN_TREATMENT = 'In Treatment';
    case RECOVERED = 'Recovered';
    case DECEASED = 'Deceased';

    public function label(): string
    {
        return match ($this) {
            self::ADMITTED => 'Admitted',
            self::DISCHARGED => 'Discharged',
            self::IN_TREATMENT => 'In Treatment',
            self::RECOVERED => 'Recovered',
            self::DECEASED => 'Deceased',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}