<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageResource;
use Illuminate\Http\Request;
use App\Models\Language;
class LanguageController extends BaseController
{

    public function index()
    {
        return LanguageResource::collection(Language::all());
    }

    public function store(Request $request)
    {
        // 
    }

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
