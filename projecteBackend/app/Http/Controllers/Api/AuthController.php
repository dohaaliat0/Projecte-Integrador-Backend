<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\OperatorResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $authUser = Auth::user();
            $result['token'] =  $authUser->createToken('MyAuthApp')->plainTextToken;
            $result['user'] =  OperatorResource::make($authUser);

            return $this->sendResponse($result, 'User signed in');
        }
        return $this->sendError('Unauthorised.', ['error'=>'incorrect Email/Password']);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());
        }

        try {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $result['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
            $result['name'] =  $user->name;

            return $this->sendResponse($result, 'User created successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Registration Error' , $e->getMessage());
        }
    }
    public function logout(Request $request)
    {

        $user = request()->user(); //or Auth::user()
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        $success['name'] =  $user->name;
         return $this->sendResponse($success, 'User successfully signed out.');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Cerca l'usuari o crea'l si no existeix
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'surnames' => $googleUser->user['family_name'],
                'hireDate' => now(),
                'username' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => bcrypt(str()->random(24)), // Contrassenya aleatòria
            ]
        );

        // Generate token for the user
        $token = $user->createToken('MyAuthApp')->plainTextToken;

        // Return a JSON response for the Vue app
        // return $this->sendResponse([
        //     'token' => $token,
        //     'user' => OperatorResource::make($user),
        // ], 'User authenticated via Google');

        return response()->view('auth.popup', compact('token', 'user'));
    }

}