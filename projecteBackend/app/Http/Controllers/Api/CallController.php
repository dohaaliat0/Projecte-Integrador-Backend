<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCallRequest;
use App\Http\Requests\UpdateCallRequest;
use App\Http\Resources\CallResource;
use App\Models\Call;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Calls",
 *     description="Gestió de trucades"
 * )
 */
class CallController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/api/calls",
     *     tags={"Calls"},
     *     summary="Obté totes les trucades",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Llista de trucades obtinguda correctament",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/CallResource")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return CallResource::collection(Call::all());
    }

    /**
     * @OA\Post(
     *     path="/api/calls",
     *     tags={"Calls"},
     *     summary="Crea una nova trucada",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCallRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Trucada creada correctament",
     *         @OA\JsonContent(ref="#/components/schemas/CallResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació o falta d'informació"
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/calls/{id}",
     *     tags={"Calls"},
     *     summary="Obté una trucada per ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la trucada",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trucada trobada",
     *         @OA\JsonContent(ref="#/components/schemas/CallResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trucada no trobada"
     *     )
     * )
     */
    public function show(Call $call)
    {
        return $this->sendResponse(new CallResource($call), 'Call retrieved successfully.', 200);
    }

    /**
     * @OA\Put(
     *     path="/api/calls/{id}",
     *     tags={"Calls"},
     *     summary="Actualitza una trucada existent",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la trucada a actualitzar",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCallRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trucada actualitzada correctament",
     *         @OA\JsonContent(ref="#/components/schemas/CallResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en actualitzar la trucada"
     *     )
     * )
     */
    public function update(UpdateCallRequest $request, Call $call)
    {
        $call->update($request->validated());
        return $this->sendResponse($call, 'Call updated successfully.', 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/calls/{id}",
     *     tags={"Calls"},
     *     summary="Elimina una trucada",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la trucada a eliminar",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trucada eliminada correctament"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trucada no trobada"
     *     )
     * )
     */
    public function destroy(Call $call)
    {
        $call->delete();
        return $this->sendResponse([], 'Call deleted successfully.', 200);
    }
}
