<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreZoneRequest;
use App\Http\Requests\UpdateZoneRequest;
use App\Http\Resources\ZoneResource;
use App\Models\Zone;

/**
 * @OA\Tag(
 *     name="Zones",
 *     description="Gestió de zones per gestionar àrees de cobertura i operacions relacionades"
 * )
 */
class ZoneController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/api/zones",
     *     tags={"Zones"},
     *     summary="Obtenir totes les zones",
     *     description="Recupera un llistat de totes les zones disponibles.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Zones recuperades correctament",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Zone")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return ZoneResource::collection(Zone::all());
    }

    public function store(StoreZoneRequest $request)
    {
        // 
    }

    /**
     * @OA\Get(
     *     path="/api/zones/{id}",
     *     tags={"Zones"},
     *     summary="Obtenir una zona per ID",
     *     description="Recupera la informació detallada d'una zona específica pel seu ID.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la zona",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Zona recuperada correctament",
     *         @OA\JsonContent(ref="#/components/schemas/Zone")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Zona no trobada"
     *     )
     * )
     */
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
