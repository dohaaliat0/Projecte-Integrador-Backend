<?php 
namespace App\Enums;

enum SocialTypes :string{
    case NOTIFY_ABSENCE_RETURN = 'Notificar absències o retorns';
    case MODIFY_PERSONAL_DATA = 'Modificar dades personals';
    case ACCIDENTAL_CALL = 'Cridades accidentals';
    case REQUEST_INFORMATION = 'Petició d’informació';
    case SUGGESTIONS_COMPLAINTS = 'Formulació de suggeriments, queixes o reclamacions';
    case SOCIAL_CALL = 'Cridades socials (per saludar o parlar amb el personal)';
    case REGISTER_MEDICAL_APPOINTMENT = 'Registrar cites mèdiques arran d’una crida';
    case OTHER_CALLS = 'Altres tipus de crides';

    public function label(): string
    {
        return match($this) {
            self::NOTIFY_ABSENCE_RETURN => 'Notificar absències o retorns',
            self::MODIFY_PERSONAL_DATA => 'Modificar dades personals',
            self::ACCIDENTAL_CALL => 'Cridades accidentals',
            self::REQUEST_INFORMATION => 'Petició d’informació',
            self::SUGGESTIONS_COMPLAINTS => 'Formulació de suggeriments, queixes o reclamacions',
            self::SOCIAL_CALL => 'Cridades socials (per saludar o parlar amb el personal)',
            self::REGISTER_MEDICAL_APPOINTMENT => 'Registrar cites mèdiques arran d’una crida',
            self::OTHER_CALLS => 'Altres tipus de crides',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}