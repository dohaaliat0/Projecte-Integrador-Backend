<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOperatorRequest;
use App\Http\Requests\UpdateOperatorRequest;
use App\Http\Resources\OperatorResource;
use App\Models\User;
use Illuminate\Http\Request;

class OperatorController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OperatorResource::collection(User::where('role', UserRole::OPERATOR)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOperatorRequest $request)
    {
        try {
            $operator = User::create($request->validated());
            return response()->json(new OperatorResource($operator), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
    
        if (!$user || $user->role !== UserRole::OPERATOR) {
            return response()->json(['message' => 'User is not an operator'], 404);
        }
    
        return $this->sendResponse(new OperatorResource($user), 'Operator retrieved successfully.', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOperatorRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== UserRole::OPERATOR) {
            return response()->json(['message' => 'User is not an operator'], 404);
        }

        $user->update($request->validated());
        return $this->sendResponse(new OperatorResource($user), 'Operator updated successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== UserRole::OPERATOR) {
            return response()->json(['message' => 'User is not an operator'], 404);
        }

        $user->delete();
        return $this->sendResponse([], 'Operator deleted successfully.', 200);
    }
}
