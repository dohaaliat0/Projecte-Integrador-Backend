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
        return $dompdf->stream('emergencies_report.pdf');
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
        return $dompdf->stream('socials_report.pdf');

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
        return $dompdf->stream('monitoring_report.pdf');
    }
}