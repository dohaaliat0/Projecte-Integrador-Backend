<?php

namespace App\Enums;

enum OutgoingCallsType: string
{
    case FOLLOW_UP_AFTER_NOTICE_OR_HOSPITALIZATION = 'Follow-up after notice or hospitalization';
    case CHECK_IF_PERSON_IS_OK = 'Check if person is okay';
    case FOLLOW_UP_ON_ACTIVATED_ALARM = 'Follow-up on activated alarm';
    case GENERAL_UNEXPECTED_EMERGENCIES = 'General unexpected emergencies';

    public function label(): string
    {
        return match($this) {
            self::FOLLOW_UP_AFTER_NOTICE_OR_HOSPITALIZATION => 'Follow-up after notice or hospitalization',
            self::CHECK_IF_PERSON_IS_OK => 'Check if person is okay',
            self::FOLLOW_UP_ON_ACTIVATED_ALARM => 'Follow-up on activated alarm',
            self::GENERAL_UNEXPECTED_EMERGENCIES => 'General unexpected emergencies',
        };
    }
}