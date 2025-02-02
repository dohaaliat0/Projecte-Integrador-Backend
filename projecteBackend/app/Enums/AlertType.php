<?php

namespace App\Enums;

enum AlertType: string {
    case MEDICATION = 'medication';
    case SPECIAL = 'special';
    case EMERGENCY_FOLLOWUP = 'emergency_followup';
    case GRIEF_PROCESS = 'grief_process';
    case HOSPITAL_DISCHARGE = 'hospital_discharge';
    case TEMPORARY_SUSPENSION = 'temporary_suspension';
    case RETURN_HOME = 'return_home';
    case HEAT_WAVE = 'heat_wave';
    case VACCINATIONS = 'vaccinations';

    public function label(): string {
        return match ($this) {
            self::MEDICATION => 'Medication alert',
            self::SPECIAL => 'Special alert',
            self::EMERGENCY_FOLLOWUP => 'Emergency follow-up',
            self::GRIEF_PROCESS => 'Grief process follow-up',
            self::HOSPITAL_DISCHARGE => 'Hospital discharge follow-up',
            self::TEMPORARY_SUSPENSION => 'Temporary service suspension',
            self::RETURN_HOME => 'Return home',
            self::HEAT_WAVE => 'Heat wave alert',
            self::VACCINATIONS => 'Preventive vaccinations',
        };
    }

    public static function values(): array {
        return array_column(self::cases(), 'value');
    }
}
