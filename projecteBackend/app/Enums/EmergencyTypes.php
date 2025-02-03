<?php

namespace App\Enums;

enum EmergencyTypes :string{
    case SOCIAL_EMERGENCY = IncomingCallsType::SOCIAL_EMERGENCY->value;
    case HEALTH_EMERGENCY = IncomingCallsType::HEALTH_EMERGENCY->value;
    case LONELINESS_CRISIS = IncomingCallsType::LONELINESS_CRISIS->value;
    case UNANSWERED_ALARM = IncomingCallsType::UNANSWERED_ALARM->value;

    public function label(): string
    {
        return match($this) {
            self::SOCIAL_EMERGENCY => 'Social Emergencies',
            self::HEALTH_EMERGENCY => 'Health Emergencies',
            self::LONELINESS_CRISIS => 'Loneliness or Distress Crisis',
            self::UNANSWERED_ALARM => 'Unanswered Alarm',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}