<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Language;
use App\Enums\Relationship;
use App\Enums\UserRole;
use App\Models\User;
use App\Models\Language as LanguageModel;

/**
 * @OA\Schema(
 *     schema="StorePatientRequest",
 *     description="Validació per a l'emmagatzematge de pacients",
 *     required={"fullName", "birthDate", "fullAddress", "dni", "healthCardNumber", "phone", "email", "zoneId", "operatorId", "languages"},
 *     @OA\Property(
 *         property="fullName",
 *         type="string",
 *         maxLength=255,
 *         description="Nom complet del pacient",
 *         example="Joan Pérez"
 *     ),
 *     @OA\Property(
 *         property="birthDate",
 *         type="string",
 *         format="date",
 *         description="Data de naixement del pacient",
 *         example="1980-01-01"
 *     ),
 *     @OA\Property(
 *         property="fullAddress",
 *         type="string",
 *         maxLength=255,
 *         description="Adreça completa del pacient",
 *         example="Carrer de l'Example, 123, 08001 Barcelona"
 *     ),
 *     @OA\Property(
 *         property="dni",
 *         type="string",
 *         maxLength=20,
 *         description="DNI del pacient",
 *         example="12345678A"
 *     ),
 *     @OA\Property(
 *         property="healthCardNumber",
 *         type="string",
 *         maxLength=20,
 *         description="Número de targeta sanitària del pacient",
 *         example="12345678901234567890"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         maxLength=15,
 *         description="Telèfon del pacient",
 *         example="600123456"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         maxLength=255,
 *         description="Correu electrònic únic del pacient",
 *         example="joan.perez@example.com"
 *     ),
 *     @OA\Property(
 *         property="zoneId",
 *         type="integer",
 *         description="Identificador de la zona",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="operatorId",
 *         type="integer",
 *         description="Identificador de l'operador",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="languages",
 *         type="array",
 *         @OA\Items(
 *             type="string",
 *             description="Idiomes parlats pel pacient",
 *             example="ca"
 *         )
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Estat del pacient",
 *         example="admitted"
 *     ),
 *     @OA\Property(
 *         property="contactPersons",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(
 *                 property="firstName",
 *                 type="string",
 *                 maxLength=255,
 *                 description="Nom de la persona de contacte",
 *                 example="Maria"
 *             ),
 *             @OA\Property(
 *                 property="lastName",
 *                 type="string",
 *                 maxLength=255,
 *                 description="Cognom de la persona de contacte",
 *                 example="García"
 *             ),
 *             @OA\Property(
 *                 property="phone",
 *                 type="string",
 *                 maxLength=15,
 *                 description="Telèfon de la persona de contacte",
 *                 example="600123456"
 *             ),
 *             @OA\Property(
 *                 property="relationship",
 *                 type="string",
 *                 description="Relació amb el pacient",
 *                 example="parent"
 *             )
 *         )
 *     )
 * )
 */
class StorePatientRequest extends FormRequest
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
        return [
            'fullName' => 'required|string|max:255',
            'birthDate' => 'required|date',
            'fullAddress' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:patients,dni',
            'healthCardNumber' => 'required|string|max:20|unique:patients,healthCardNumber',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:patients,email',
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
                            $fail('The selected ' . $attribute . ' is invalid.');
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
