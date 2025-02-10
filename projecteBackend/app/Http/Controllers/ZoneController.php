<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreZoneRequest;
use App\Http\Requests\UpdateZoneRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{

    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zones = Zone::all();
        return view('webzones.index', compact('zones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Zone::class);
        return view('webzones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreZoneRequest $request)
    {
        $this->authorize('create', Zone::class);
        $validated = $request->validated();

        
        Zone::create($validated);

        return redirect()->route('webzones.index')->with('success', 'Zona creada correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Zone $zone)
    {
        return view('webzones.show', compact('zone'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zone $zone)
    {
        $this->authorize('update', $zone);
        return view('webzones.edit', compact('zone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateZoneRequest $request, Zone $zone)
    {
        $this->authorize('update', $zone);
        $validated = $request->validated();
        $equip = Zone::findOrFail($zone->id);
        $equip->update($validated);
        return redirect()->route('webzones.index')->with('success', 'Zona actualitzada correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zone $zone)
    {
        $this->authorize( 'delete', $zone);
        $zone->delete();
        return redirect()->route('webzones.index')->with('success', 'Zona esborrada correctament!');
    }
}
