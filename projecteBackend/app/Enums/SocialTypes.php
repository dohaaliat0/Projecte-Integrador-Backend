<?php 
namespace App\Enums;

enum SocialTypes :string{
    case NOTIFY_ABSENCE_RETURN = IncomingCallsType::NOTIFY_ABSENCE_RETURN->value;
    case MODIFY_PERSONAL_DATA = IncomingCallsType::MODIFY_PERSONAL_DATA->value;
    case ACCIDENTAL_CALL = IncomingCallsType::ACCIDENTAL_CALL->value;
    case REQUEST_INFORMATION = IncomingCallsType::REQUEST_INFORMATION->value;
    case SUGGESTIONS_COMPLAINTS = IncomingCallsType::SUGGESTIONS_COMPLAINTS->value;
    case SOCIAL_CALL = IncomingCallsType::SOCIAL_CALL->value;
    case REGISTER_MEDICAL_APPOINTMENT = IncomingCallsType::REGISTER_MEDICAL_APPOINTMENT->value;
    case OTHER_CALLS = IncomingCallsType::OTHER_CALLS->value;

    public function label(): string
    {
        return match($this) {
            self::NOTIFY_ABSENCE_RETURN => IncomingCallsType::NOTIFY_ABSENCE_RETURN->label(),
            self::MODIFY_PERSONAL_DATA => IncomingCallsType::MODIFY_PERSONAL_DATA->label(),
            self::ACCIDENTAL_CALL => IncomingCallsType::ACCIDENTAL_CALL->label(),
            self::REQUEST_INFORMATION => IncomingCallsType::REQUEST_INFORMATION->label(),
            self::SUGGESTIONS_COMPLAINTS => IncomingCallsType::SUGGESTIONS_COMPLAINTS->label(),
            self::SOCIAL_CALL => IncomingCallsType::SOCIAL_CALL->label(),
            self::REGISTER_MEDICAL_APPOINTMENT => IncomingCallsType::REGISTER_MEDICAL_APPOINTMENT->label(),
            self::OTHER_CALLS => IncomingCallsType::OTHER_CALLS->label(),
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}