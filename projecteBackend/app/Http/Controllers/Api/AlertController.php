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
            if ($value === 'null') {
                $query->whereNull($key);
            } else {
                $query->where($key, $value);
            }
            }
        }

        if(request()->has('date')) {
            $query->where('date', '>=', request()->date);
        }

        if(request()->has('endDate')) {
            if (Carbon::hasFormat(request()->endDate, 'Y-m-d')) {
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

    public function store(StoreAlertRequest $request)
    {
        try{
            $validated = $request->validated();
            $alert = Alert::create($validated);
            return $this->sendResponse(new AlertResource($alert), 201);
        }catch (\Exception $e) {
            return $this->sendError(['message' => $e->getMessage()], $e->status ?? 400);
        }
    }

    public function update(StoreAlertRequest $request, Alert $alert)
    {
        try{
            $validated = $request->validated();
            $alert->update($validated);
            return $this->sendResponse(new AlertResource($alert), 200);
        }catch (\Exception $e) {
            return $this->sendError(['message' => $e->getMessage()], $e->status ?? 400);
        }
    }

    public function destroy(Alert $alert)
    {
        try{
            $alert->delete();
            return $this->sendResponse([], 204);
        }catch (\Exception $e) {
            return $this->sendError(['message' => $e->getMessage()], $e->status ?? 400);
        }
    }

    public function getCallByAlertId($id)
    {
        $alert = Alert::find($id);



        if (!$alert) {
            return $this->sendError(['message' => 'Alert not found'], 404);
        }

        $calls = $alert->outgoingCall;
        
        foreach ($calls as $call) {
            $call->call;
        }

        return $this->sendResponse($calls, 'Calls retrieved successfully.', 200);
    }
}
