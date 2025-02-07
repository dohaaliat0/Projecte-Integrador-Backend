<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlertRequest;
use App\Http\Resources\AlertResource;
use App\Models\Alert;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AlertController extends BaseController
{
    private function getValidData()
    {
        $query = Alert::query();
        $params = request()->except(['debug', 'date', 'endDate']);

        foreach ($params as $key => $value) {
            if (in_array($key, (new Alert)->getFillable())) {
                $query->where($key, $value);
            }
        }

        if(request()->has('date')) {
            $query->where('date', '>=', request()->date);
        }

        if(request()->has('endDate')) {
            if (Carbon::hasFormat(request()->endDate, 'Y-m-d')) {
                dd('here');
                $query->where('endDate  ', '<=', request()->endDate);
            } else {
                $query->whereNull('endDate');
            }
        }

        return $query->get();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AlertResource::collection($this->getValidData());
    }

    public function show(Alert $alert)
    {
        return $this->sendResponse(new AlertResource($alert), 'Alert retrieved successfully.', 200);
    }
}
