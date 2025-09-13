<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDarAltaRequest;
use App\Http\Requests\UpdateDasAltaAntiguoRequest;
use App\Http\Requests\UpdateDarAltaNuevoRequest;
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
        $this->authorize('create', User::class);
        return view('DarAltaBaja.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDarAltaRequest $request)
    {   
        
        $this->authorize('create', User::class);
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('DarAltaBaja.edit', compact('user'));  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDarAltaNuevoRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $validated = $request->validated();
        $user->update($validated);

        return redirect()->route('altabaja.index')->with('success', 'User updated successfully.');
        
    }


   
    public function altaAntiguoUser()
    {
        $this->authorize('update', User::class);
        $users = User::where('role', UserRole::OPERATOR->value)
                 ->whereNotNull('terminationDate')
                 ->get();

        return view('DarAltaBaja.DarAltaAntiguo', ['users' => $users, 'user' => $users->first()]);
    }


    public function updateAltaAntiguoUser(UpdateDasAltaAntiguoRequest $request)
    {
        $this->authorize('update', User::class);
        $validated = $request->validated();
        $user = User::find($validated['user_id']);
        if(!$user){
            return redirect()->route('altabaja.index')->with('error', 'User not found.');
        }
        $user->terminationDate = null;
        $user->save();

        return redirect()->route('altabaja.index')->with('success', 'User reactivated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $this->authorize('delete', User::class);
        $user = User::find($id);
        if(!$user){
            return redirect()->route('altabaja.index')->with('error', 'User not found.');
        }
        $user->terminationDate = now();
        $user->save();

        return redirect()->route('altabaja.index')->with('success', 'User terminated successfully.');
    }
}

