<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCallRequest;
use App\Http\Requests\UpdateCallRequest;
use App\Http\Resources\CallResource;
use App\Models\Call;
use Illuminate\Http\Request;

class CallController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CallResource::collection(Call::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCallRequest $request)
    {
        try {
            $validated = $request->validated();
            if (isset($validated['incomingCall'])) {
                $call = Call::create($validated);
                

                $call->incomingCall()->create($validated['incomingCall']);
            } elseif (isset($validated['outgoingCall'])) {
                $call = Call::create($validated);

                $call->outgoingCall()->create($validated['outgoingCall']);
            }else{
                throw new \Exception('Either incomingCall or outgoingCall must be provided.');
            }

            return $this->sendResponse(new CallResource($call), 201);
        } catch (\Exception $e) {
            return $this->sendError(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Call $call)
    {
        return $this->sendResponse(new CallResource($call), 'Call retrieved successfully.', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCallRequest $request, Call $call)
    {
        $call->update($request->validated());
        return $this->sendResponse($call, 'Call updated successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Call $call)
    {
        $call->delete();
        return $this->sendResponse([], 'Call deleted successfully.', 200);
    }
}
