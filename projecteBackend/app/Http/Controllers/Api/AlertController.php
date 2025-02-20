<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlertRequest;
use App\Http\Requests\UpdateAlertRequest;
use App\Http\Resources\AlertResource;
use App\Models\Alert;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * @OA\Tag(
 *     name="Alerts",
 *     description="Gestió d'alertes"
 * )
 */
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
     * @OA\Get(
     *     path="/api/alerts",
     *     tags={"Alerts"},
     *     summary="Llistar alertes",
     *     description="Retorna una col·lecció d'alertes amb filtres opcionals",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="operatorId",
     *         in="query",
     *         description="Filtrar per operador",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="patientId",
     *         in="query",
     *         description="Filtrar per pacient",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Mostrar alertes a partir d'una data",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="endDate",
     *         in="query",
     *         description="Mostrar alertes fins a una data",
     *         required=false,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Llista d'alertes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/AlertResource")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return AlertResource::collection($this->getValidData());
    }

    /**
     * @OA\Get(
     *     path="/api/alerts/{id}",
     *     tags={"Alerts"},
     *     summary="Mostrar alerta",
     *     description="Retorna els detalls d'una alerta específica",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Identificador de l'alerta",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalls de l'alerta",
     *         @OA\JsonContent(ref="#/components/schemas/AlertResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Alerta no trobada"
     *     )
     * )
     */
    public function show(Alert $alert)
    {
        return $this->sendResponse(new AlertResource($alert), 'Alert retrieved successfully.', 200);
    }

    /**
     * @OA\Post(
     *     path="/api/alerts",
     *     tags={"Alerts"},
     *     summary="Crear alerta",
     *     description="Crea una nova alerta",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreAlertRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Alerta creada correctament",
     *         @OA\JsonContent(ref="#/components/schemas/AlertResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació o de creació"
     *     )
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/alerts/{id}",
     *     tags={"Alerts"},
     *     summary="Actualitzar alerta",
     *     description="Actualitza una alerta existent",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Identificador de l'alerta",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateAlertRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Alerta actualitzada correctament",
     *         @OA\JsonContent(ref="#/components/schemas/AlertResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error d'actualització"
     *     )
     * )
     */
    public function update(UpdateAlertRequest $request, Alert $alert)
    {
        try{
            $validated = $request->validated();
            $alert->update($validated);

            return $this->sendResponse(new AlertResource($alert), 200);
        }catch (\Exception $e) {
            return $this->sendError(['message' => $e->getMessage()], $e->status ?? 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/alerts/{id}",
     *     tags={"Alerts"},
     *     summary="Eliminar alerta",
     *     description="Elimina una alerta específica",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Identificador de l'alerta",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Alerta eliminada correctament"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en l'eliminació"
     *     )
     * )
     */
    public function destroy(Alert $alert)
    {
        try{
            $alert->delete();
            return $this->sendResponse([], 204);
        }catch (\Exception $e) {
            return $this->sendError(['message' => $e->getMessage()], $e->status ?? 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/calls/alerts/{id}",
     *     tags={"Alerts"},
     *     summary="Obtenir trucades per alerta",
     *     description="Retorna les trucades associades a una alerta específica",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Identificador de l'alerta",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trucades recuperades correctament",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/OutgoingCallResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Alerta no trobada"
     *     )
     * )
     */
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
