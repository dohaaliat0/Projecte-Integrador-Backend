<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDarAltaRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AltaYBajaController extends Controller
{

    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', UserRole::OPERATOR->value)
                 ->whereNull('terminationDate')
                 ->get();

        return view('DarAltaBaja.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('DarAltaBaja.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDarAltaRequest $request)
    {   
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => UserRole::OPERATOR->value,
            'surnames' => $validated['surnames'],
            'phone' => $validated['phone'],
            'hireDate' => now(),
            'username' =>   $validated['name'] . ' ' . $validated['surnames'],
            'terminationDate' => null,
        ]);

        return redirect()->route('altabaja.index')->with('success', 'User activated successfully.');
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Zone $zone)
    // {

    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(UpdateZoneRequest $request, Zone $zone)
    // {

    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $user = User::find($id);
        if(!$user){
            return redirect()->route('altabaja.index')->with('error', 'User not found.');
        }
        $user->terminationDate = now();
        $user->save();

        return redirect()->route('altabaja.index')->with('success', 'User terminated successfully.');
    }
}

