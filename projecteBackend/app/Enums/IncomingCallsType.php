<?php

namespace App\Enums;

enum IncomingCallsType: string
{
    // Emergency Attention
    case SOCIAL_EMERGENCY = 'Social Emergencies';
    case HEALTH_EMERGENCY = 'Health Emergencies';
    case LONELINESS_CRISIS = 'Loneliness or Distress Crisis';
    case UNANSWERED_ALARM = 'Unanswered Alarm';

    // Non-Urgent Communications
    case NOTIFY_ABSENCE_RETURN = 'Notify Absences or Returns';
    case MODIFY_PERSONAL_DATA = 'Modify Personal Data';
    case ACCIDENTAL_CALL = 'Accidental Calls';
    case REQUEST_INFORMATION = 'Request Information';
    case SUGGESTIONS_COMPLAINTS = 'Suggestions, Complaints or Claims';
    case SOCIAL_CALL = 'Social Calls (to greet or talk with staff)';
    case REGISTER_MEDICAL_APPOINTMENT = 'Register Medical Appointments from a Call';
    case OTHER_CALLS = 'Other Types of Calls';

    public function label(): string
    {
        return match($this) {
            self::SOCIAL_EMERGENCY => 'Social Emergencies',
            self::HEALTH_EMERGENCY => 'Health Emergencies',
            self::LONELINESS_CRISIS => 'Loneliness or Distress Crisis',
            self::UNANSWERED_ALARM => 'Unanswered Alarm',
            self::NOTIFY_ABSENCE_RETURN => 'Notify Absences or Returns',
            self::MODIFY_PERSONAL_DATA => 'Modify Personal Data',
            self::ACCIDENTAL_CALL => 'Accidental Calls',
            self::REQUEST_INFORMATION => 'Request Information',
            self::SUGGESTIONS_COMPLAINTS => 'Suggestions, Complaints or Claims',
            self::SOCIAL_CALL => 'Social Calls (to greet or talk with staff)',
            self::REGISTER_MEDICAL_APPOINTMENT => 'Register Medical Appointments from a Call',
            self::OTHER_CALLS => 'Other Types of Calls',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}