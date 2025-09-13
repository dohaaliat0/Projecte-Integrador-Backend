<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Enums\Relationship;
use App\Http\Resources\RelationshipResource;

/**
 * @OA\Tag(
 *     name="Relationships",
 *     description="Gestió de relacions de contacte"
 * )
 */
class RelationshipController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/api/relationships",
     *     tags={"Relationships"},
     *     summary="Llistar relacions",
     *     description="Retorna totes les relacions definides a l'enum Relationship",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Relacions recuperades correctament",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *                 example="Pare"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error recuperant les relacions"
     *     )
     * )
     */
    public function index()
    {
        return $this->sendResponse(Relationship::values(), 'Relationships retrieved successfully.', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
