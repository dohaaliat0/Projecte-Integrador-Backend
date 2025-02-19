<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Language;
use App\Models\User;
use App\Enums\UserRole;
use App\Models\Language as LanguageModel;
use App\Enums\Relationship;


/**
 * @OA\Schema(
 *     schema="UpdatePatientRequest",
 *     description="Validation for updating a patient",
 *     required={"fullName", "birthDate", "fullAddress", "dni", "healthCardNumber", "phone", "email", "zoneId", "operatorId", "languages"},
 *     @OA\Property(
 *         property="fullName",
 *         type="string",
 *         maxLength=255,
 *         description="Full name of the patient",
 *         example="John Doe"
 *     ),
 *     @OA\Property(
 *         property="birthDate",
 *         type="string",
 *         format="date",
 *         description="Birth date of the patient",
 *         example="1990-01-01"
 *     ),
 *     @OA\Property(
 *         property="fullAddress",
 *         type="string",
 *         maxLength=255,
 *         description="Full address of the patient",
 *         example="123 Main St, Anytown, USA"
 *     ),
 *     @OA\Property(
 *         property="dni",
 *         type="string",
 *         maxLength=20,
 *         description="DNI of the patient",
 *         example="12345678A"
 *     ),
 *     @OA\Property(
 *         property="healthCardNumber",
 *         type="string",
 *         maxLength=20,
 *         description="Health card number of the patient",
 *         example="HC123456789"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         maxLength=15,
 *         description="Phone number of the patient",
 *         example="+1234567890"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         maxLength=255,
 *         description="Unique email of the patient",
 *         example="john.doe@example.com"
 *     ),
 *     @OA\Property(
 *         property="zoneId",
 *         type="integer",
 *         description="Zone ID where the patient resides",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="personalFamilySituation",
 *         type="string",
 *         description="Personal family situation of the patient",
 *         example="Single"
 *     ),
 *     @OA\Property(
 *         property="healthSituation",
 *         type="string",
 *         description="Health situation of the patient",
 *         example="Good"
 *     ),
 *     @OA\Property(
 *         property="housingSituation",
 *         type="string",
 *         description="Housing situation of the patient",
 *         example="Own house"
 *     ),
 *     @OA\Property(
 *         property="personalAutonomy",
 *         type="string",
 *         description="Personal autonomy of the patient",
 *         example="Independent"
 *     ),
 *     @OA\Property(
 *         property="economicSituation",
 *         type="string",
 *         description="Economic situation of the patient",
 *         example="Stable"
 *     ),
 *     @OA\Property(
 *         property="operatorId",
 *         type="integer",
 *         description="ID of the operator handling the patient",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="languages",
 *         type="array",
 *         @OA\Items(
 *             type="string",
 *             description="Languages spoken by the patient",
 *             example="en"
 *         )
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Status of the patient",
 *         example="admitted"
 *     ),
 *     @OA\Property(
 *         property="contactPersons",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(
 *                 property="firstName",
 *                 type="string",
 *                 maxLength=255,
 *                 description="First name of the contact person",
 *                 example="Jane"
 *             ),
 *             @OA\Property(
 *                 property="lastName",
 *                 type="string",
 *                 maxLength=255,
 *                 description="Last name of the contact person",
 *                 example="Doe"
 *             ),
 *             @OA\Property(
 *                 property="phone",
 *                 type="string",
 *                 maxLength=15,
 *                 description="Phone number of the contact person",
 *                 example="+1234567890"
 *             ),
 *             @OA\Property(
 *                 property="relationship",
 *                 type="string",
 *                 description="Relationship of the contact person to the patient",
 *                 example="Sibling"
 *             )
 *         )
 *     )
 * )
 */
class UpdatePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $validLanguages = Language::values();
        $currentDni = $this->route('patient')->dni;
        $currentHealthCardNumber = $this->route('patient')->healthCardNumber;
        $currentMail = $this->route('patient')->email;

        return [
            'fullName' => 'required|string|max:255',
            'birthDate' => 'required|date',
            'fullAddress' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:patients,dni,' . $currentDni . ',dni',
            'healthCardNumber' => 'required|string|max:20|unique:patients,healthCardNumber,' . $currentHealthCardNumber . ',healthCardNumber',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:patients,email,' . $currentMail . ',email',
            'zoneId' => 'required|integer|exists:zones,id',
            'personalFamilySituation' => 'nullable|string',
            'healthSituation' => 'nullable|string',
            'housingSituation' => 'nullable|string',
            'personalAutonomy' => 'nullable|string',
            'economicSituation' => 'nullable|string',
            'operatorId' => [
                'required',
                'integer',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = User::find($value);
                    if (!$user || $user->role !== UserRole::OPERATOR->value) {
                        $fail('The selected ' . $attribute . ' is invalid.');
                    }
                },
            ],
            'languages' => [
                'required',
                'array',
                function ($attribute, $value, $fail) use ($validLanguages) {
                    if (empty($value)) {
                        $fail('The ' . $attribute . ' must have at least one element.');
                    }
                    foreach ($value as $language) {
                        if (!in_array($language, $validLanguages) && !LanguageModel::isValidId($language)) {
                            $fail('The selected ' . $attribute . ' is invalid. It failed for ' . $language);
                        }
                    }
                },
            ],
            'status' => [
                function ($attribute, $value, $fail) {
                    if (is_null($value)) {
                        $value = \App\Enums\PatientStatus::ADMITTED->value;
                    }
                    if (!in_array($value, \App\Enums\PatientStatus::values())) {
                        $fail('The selected ' . $attribute . ' is invalid. Valid status are: ' . implode(', ', \App\Enums\PatientStatus::values()));
                    }
                },
            ],
            'contactPersons' => 'nullable|array',
            'contactPersons.*.firstName' => 'required|string|max:255',
            'contactPersons.*.lastName' => 'required|string|max:255',
            'contactPersons.*.phone' => 'required|string|max:15',
            'contactPersons.*.relationship' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!in_array($value, Relationship::values())) {
                        $fail('The selected ' . $attribute . ' is invalid.');
                    }
                },
            ],
        ];
    }
}
