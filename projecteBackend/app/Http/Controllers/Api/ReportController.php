<?php

namespace App\Http\Controllers\Api;

use App\Models\Call;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Enums\EmergencyTypes;
use App\Enums\OutgoingCallsType;
use App\Enums\SocialTypes;
use App\Models\Patient;
use App\Models\Alert;
use Dompdf\Dompdf;

/**
 * @OA\Tag(
 *     name="Reports",
 *     description="Gestió d'informes PDF de trucades, pacients i alertes"
 * )
 */
class ReportController extends BaseController
{
        /**
     * @OA\Get(
     *     path="/api/reports/emergencies",
     *     tags={"Reports"},
     *     summary="Informe d'emergències",
     *     description="Genera un PDF amb les trucades d'emergència dins del rang de dates indicat.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Data d'inici (format: YYYY-MM-DD)",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Data de fi (format: YYYY-MM-DD)",
     *         required=false,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PDF generat correctament",
     *         @OA\MediaType(
     *             mediaType="application/pdf",
     *             @OA\Schema(type="string", format="binary")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error generant l'informe"
     *     )
     * )
     */
    public function getEmergencies(Request $request)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();

        $calls = Call::whereHas('incomingCall', function ($query) {
            $query->whereIn('type', EmergencyTypes::values());
        })->whereBetween('dateTime', [$startDate, $endDate])->get();
        foreach ($request->query() as $key => $value) {
            if (!in_array($key, ['startDate', 'endDate'])) {
            $calls = $calls->where($key, $value);
            }
        }
        $dompdf = new Dompdf();
        $html = view('reports.emergencies', compact('calls', 'startDate', 'endDate'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $response = response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="emergencies_report.pdf"')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;
    }

    /**
     * @OA\Get(
     *     path="/api/reports/socials",
     *     tags={"Reports"},
     *     summary="Informe de trucades socials",
     *     description="Genera un PDF amb les trucades socials dins del rang de dates indicat.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Data d'inici (format: YYYY-MM-DD)",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Data de fi (format: YYYY-MM-DD)",
     *         required=false,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PDF generat correctament",
     *         @OA\MediaType(
     *             mediaType="application/pdf",
     *             @OA\Schema(type="string", format="binary")
     *         )
     *     )
     * )
     */
    public function getSocials(Request $request)
    {

        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();

        $calls = Call::whereHas('incomingCall', function ($query) {
            $query->whereIn('type', SocialTypes::values());
        })->whereBetween('dateTime', [$startDate, $endDate])->get();
        foreach ($request->query() as $key => $value) {
            if (!in_array($key, ['startDate', 'endDate'])) {
            $calls = $calls->where($key, $value);
            }
        }

        $dompdf = new Dompdf();
        $html = view('reports.socials', compact('calls', 'startDate', 'endDate'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $response = response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="socials_report.pdf"')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;
    }

    /**
     * @OA\Get(
     *     path="/api/reports/monitoring",
     *     tags={"Reports"},
     *     summary="Informe de monitoratges",
     *     description="Genera un PDF amb les trucades de monitoratge dins del rang de dates indicat.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Data d'inici (format: YYYY-MM-DD)",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Data de fi (format: YYYY-MM-DD)",
     *         required=false,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PDF generat correctament",
     *         @OA\MediaType(
     *             mediaType="application/pdf",
     *             @OA\Schema(type="string", format="binary")
     *         )
     *     )
     * )
     */
    public function getMonitorings(Request $request)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();

        $calls = Call::whereHas('outgoingCall', function ($query) {
            $query->whereIn('type', OutgoingCallsType::values());
        })->whereBetween('dateTime', [$startDate, $endDate])->get();
        foreach ($request->query() as $key => $value) {
            if (!in_array($key, ['startDate', 'endDate'])) {
            $calls = $calls->where($key, $value);
            }
        }

        $dompdf = new Dompdf();
        $html = view('reports.monitoring', compact('calls', 'startDate', 'endDate'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $response = response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="monitoring_report.pdf"')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;
    }

    /**
     * @OA\Get(
     *     path="/api/reports/patients",
     *     tags={"Reports"},
     *     summary="Informe de pacients",
     *     description="Genera un PDF amb tots els pacients filtrats pels paràmetres indicats.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nom del pacient",
     *         required=false,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PDF generat correctament",
     *         @OA\MediaType(
     *             mediaType="application/pdf",
     *             @OA\Schema(type="string", format="binary")
     *         )
     *     )
     * )
     */
    public function getAllPatients(Request $request)
    {
        $query = Patient::query();

        foreach ($request->query() as $key => $value) {
            $query->where($key, $value);
        }

        $patients = $query->get();
        $dompdf = new Dompdf();
        $html = view('reports.patients', compact('patients'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $response = response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="patients_report.pdf"')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;
    }

    /**
     * @OA\Get(
     *     path="/api/reports/patients/{id}/history",
     *     tags={"Reports"},
     *     summary="Historial de trucades d'un pacient",
     *     description="Genera un PDF amb l'historial de trucades d'un pacient concret.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del pacient",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         name="startDate",
     *         in="query",
     *         description="Data d'inici (format: YYYY-MM-DD)",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Data de fi (format: YYYY-MM-DD)",
     *         required=false,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PDF generat correctament",
     *         @OA\MediaType(
     *             mediaType="application/pdf",
     *             @OA\Schema(type="string", format="binary")
     *         )
     *     )
     * )
     */
    public function getPatientHistory(Request $request, $id)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();

        $calls = Call::where('patientId', $id)->whereBetween('dateTime', [$startDate, $endDate])->get();
        $patient = Patient::find($id);

        $dompdf = new Dompdf();
        $html = view('reports.patient_history', compact('calls', 'patient', 'startDate', 'endDate'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $response = response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="patient_history_report.pdf"')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;
    }


     /**
     * @OA\Get(
     *     path="/api/reports/scheduled-calls",
     *     tags={"Reports"},
     *     summary="Informe de trucades programades",
     *     description="Genera un PDF amb les trucades programades dins del rang de dates i opcionalment per zona.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="zoneId",
     *         in="query",
     *         description="ID de la zona",
     *         required=false,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PDF generat correctament",
     *         @OA\MediaType(
     *             mediaType="application/pdf",
     *             @OA\Schema(type="string", format="binary")
     *         )
     *     )
     * )
     */
    public function getScheduledCalls(Request $request)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();
        $zoneId = $request->query('zoneId') ? $request->query('zoneId') : null;

        if ($zoneId) {
            $alertsWithCalls = Alert::where('zoneId', $zoneId)->whereBetween('date', [$startDate, $endDate])->whereHas('outgoingCall')->get();
            $alertsWithoutCalls = Alert::where('zoneId', $zoneId)->whereBetween('date', [$startDate, $endDate])->whereDoesntHave('outgoingCall')->get();
        } else {
            $alertsWithCalls = Alert::whereBetween('date', [$startDate, $endDate])->whereHas('outgoingCall')->get();

            $alertsWithoutCalls = Alert::whereBetween('date', [$startDate, $endDate])->whereDoesntHave('outgoingCall')->get();
        }

        $dompdf = new Dompdf();
        $html = view('reports.scheduled_calls', compact('alertsWithCalls', 'alertsWithoutCalls', 'startDate', 'endDate'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $response = response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="scheduled_calls_report.pdf"')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;
    }

    /**
     * @OA\Get(
     *     path="/api/reports/done-calls",
     *     tags={"Reports"},
     *     summary="Informe de trucades realitzades",
     *     description="Genera un PDF amb totes les trucades entrants i sortints realitzades dins del rang de dates indicat.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="PDF generat correctament",
     *         @OA\MediaType(
     *             mediaType="application/pdf",
     *             @OA\Schema(type="string", format="binary")
     *         )
     *     )
     * )
     */
    public function doneCalls(Request $request)
    {

        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();

        $incomingCalls = Call::whereHas('incomingCall')->whereBetween('dateTime', [$startDate, $endDate])->get();
        $outgoingCalls = Call::whereHas('outgoingCall')->whereBetween('dateTime', [$startDate, $endDate])->get();

        $dompdf = new Dompdf();
        $html = view('reports.done_calls', compact('incomingCalls', 'outgoingCalls', 'startDate', 'endDate'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $response = response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="done_calls_report.pdf"')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;
    }
}
