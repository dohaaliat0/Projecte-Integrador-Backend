<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreZoneRequest;
use App\Http\Requests\UpdateZoneRequest;
use App\Http\Resources\ZoneResource;
use App\Models\Zone;

class ZoneController extends BaseController
{

    public function index()
    {
        return ZoneResource::collection(Zone::all());
    }

    public function store(StoreZoneRequest $request)
    {
        // 
    }

    public function show($id)
    {
        $zone = Zone::find($id);

        if (!$zone) {
            return response()->json(['message' => 'Zone not found'], 404);
        }

        return $this->sendResponse(new ZoneResource($zone), 'Zone retrieved successfully.', 200);
    }

    public function update(UpdateZoneRequest $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
