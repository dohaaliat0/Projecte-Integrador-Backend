<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageResource;
use Illuminate\Http\Request;
use App\Models\Language;

/**
 * @OA\Tag(
 *     name="Languages",
 *     description="Gestió de llengües"
 * )
 */
class LanguageController extends BaseController
{

    /**
     * @OA\Get(
     *     path="/api/languages",
     *     tags={"Languages"},
     *     summary="Llistar llengües",
     *     description="Retorna totes les llengües disponibles",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Llengües recuperades correctament",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/LanguageResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error recuperant les llengües"
     *     )
     * )
     */
    public function index()
    {
        return LanguageResource::collection(Language::all());
    }

    public function store(Request $request)
    {
        // 
    }

    /**
     * @OA\Get(
     *     path="/api/languages/{language}",
     *     tags={"Languages"},
     *     summary="Mostrar llengua",
     *     description="Retorna els detalls d'una llengua específica",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="language",
     *         in="path",
     *         required=true,
     *         description="Identificador de la llengua",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Llengua recuperada correctament",
     *         @OA\JsonContent(ref="#/components/schemas/LanguageResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Llengua no trobada"
     *     )
     * )
     */
    public function show($id)
    {
        $language = Language::find($id);

        if (!$language) {
            return response()->json(['message' => 'Language not found'], 404);
        }

        return $this->sendResponse(new LanguageResource($language), 'Language retrieved successfully.', 200);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
