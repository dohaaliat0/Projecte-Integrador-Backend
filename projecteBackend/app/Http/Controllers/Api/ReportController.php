<?php

namespace App\Http\Controllers\Api;

use App\Models\Call;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Enums\EmergencyTypes;
use App\Enums\OutgoingCallsType;
use App\Enums\SocialTypes;
use Dompdf\Dompdf;

class ReportController extends BaseController
{
    public function getEmergencies(Request $request)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();

        $calls = Call::whereHas('incomingCall', function ($query) {
            $query->whereIn('type', EmergencyTypes::values());
        })->whereBetween('dateTime', [$startDate, $endDate])->get();

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

    public function getSocials(Request $request)
    {

        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();

        $calls = Call::whereHas('incomingCall', function ($query) {
            $query->whereIn('type', SocialTypes::values());
        })->whereBetween('dateTime', [$startDate, $endDate])->get();


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

    public function getMonitorings(Request $request)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();

        $calls = Call::whereHas('outgoingCall', function ($query) {
            $query->whereIn('type', OutgoingCallsType::values());
        })->whereBetween('dateTime', [$startDate, $endDate])->get();

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

    public function getAllPatients(Request $request)
    {
        $query = Call::query();

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

    public function getPatientHistory(Request $request, $id)
    {
        $startDate = $request->query('startDate') ? Carbon::parse($request->query('startDate'))->startOfDay() : Carbon::now()->startOfYear();
        $endDate = $request->query('endDate') ? Carbon::parse($request->query('endDate'))->endOfDay() : Carbon::now()->endOfYear();

        $calls = Call::where('patient_id', $id)->whereBetween('dateTime', [$startDate, $endDate])->get();

        $dompdf = new Dompdf();
        $html = view('reports.patient_history', compact('calls', 'startDate', 'endDate'))->render();
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
}
