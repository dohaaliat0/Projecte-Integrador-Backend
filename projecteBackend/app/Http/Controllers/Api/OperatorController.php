<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOperatorRequest;
use App\Http\Requests\UpdateOperatorRequest;
use App\Http\Resources\CallResource;
use App\Http\Resources\OperatorResource;
use App\Models\Call;
use App\Models\User;
use Illuminate\Http\Request;


/**
 * @OA\Tag(
 *     name="Operators",
 *     description="Gestió d'operadors"
 * )
 */
class OperatorController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/api/operators",
     *     tags={"Operators"},
     *     summary="Llistar operadors",
     *     description="Retorna tots els usuaris amb el rol d'operador",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Operadors recuperats correctament",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/OperatorResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error recuperant els operadors"
     *     )
     * )
     */
    public function index()
    {
        return OperatorResource::collection(User::where('role', UserRole::OPERATOR)->get());
    }

    /**
     * @OA\Post(
     *     path="/api/operators",
     *     tags={"Operators"},
     *     summary="Crear operador",
     *     description="Crea un nou operador",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreOperatorRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Operador creat correctament",
     *         @OA\JsonContent(ref="#/components/schemas/OperatorResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la creació de l'operador"
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/operators/{operator}",
     *     tags={"Operators"},
     *     summary="Mostrar operador",
     *     description="Retorna els detalls d'un operador específic",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="operator",
     *         in="path",
     *         required=true,
     *         description="Identificador de l'operador",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operador recuperat correctament",
     *         @OA\JsonContent(ref="#/components/schemas/OperatorResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Operador no trobat"
     *     )
     * )
     */
    public function show($id)
    {
        $user = User::find($id);
    
        if (!$user || $user->role !== UserRole::OPERATOR) {
            // return response()->json(['message' => 'User is not an operator'], 404);
            $this->sendError('User is not an operator', 404);
        }
    
        return $this->sendResponse(new OperatorResource($user), 'Operator retrieved successfully.', 200);
    }

    /**
     * @OA\Put(
     *     path="/api/operators/{operator}",
     *     tags={"Operators"},
     *     summary="Actualitzar operador",
     *     description="Actualitza un operador existent",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="operator",
     *         in="path",
     *         required=true,
     *         description="Identificador de l'operador",
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateOperatorRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operador actualitzat correctament",
     *         @OA\JsonContent(ref="#/components/schemas/OperatorResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error actualitzant l'operador"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/operators/{operator}",
     *     tags={"Operators"},
     *     summary="Eliminar operador",
     *     description="Elimina un operador específic",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="operator",
     *         in="path",
     *         required=true,
     *         description="Identificador de l'operador",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operador eliminat correctament"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error eliminant l'operador"
     *     )
     * )
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

    /**
     * @OA\Get(
     *     path="/api/operators/{id}/calls",
     *     tags={"Operators"},
     *     summary="Historial de trucades per operador",
     *     description="Recupera totes les trucades associades a un operador",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Identificador de l'operador",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Historial de trucades recuperat correctament",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/CallResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Operador no trobat"
     *     )
     * )
     */
    public function getCallHistoryByOperator($id)
    {
        $calls = Call::where('operatorId', $id)->get();
        return CallResource::collection($calls);
    }
}
