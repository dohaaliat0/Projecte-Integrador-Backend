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
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Autenticació de l'usuari",
     *     tags={"Autenticació"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="admin@example.com"),
     *             @OA\Property(property="password", type="string", example="password"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login correcte",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="jwt-token"),
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="coordinator"),
     *                     @OA\Property(property="email", type="string", format="email", example="admin@example.com")
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string", example="User signed in")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autoritzat",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthorised."),
     *             @OA\Property(property="info", type="object",
     *                 @OA\Property(property="error", type="string", example="Incorrect Email/Password")
     *             )
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && $user->terminationDate !== null) {
            return $this->sendError('Unauthorised.', ['error' => 'User is terminated.']);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $authUser = Auth::user();
            $result['token'] =  $authUser->createToken('MyAuthApp')->plainTextToken;
            $result['user'] =  OperatorResource::make($authUser);

            return $this->sendResponse($result, 'User signed in');
        }
        return $this->sendError('Unauthorised.', ['error' => 'Incorrect Email/Password'], 401);
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Registrar un nou usuari",
     *     tags={"Autenticació"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "confirm_password"},
     *             @OA\Property(property="name", type="string", example="Marc"),
     *             @OA\Property(property="email", type="string", format="email", example="marcmolla123@gmail.com"),
     *             @OA\Property(property="password", type="string", example="password"),
     *             @OA\Property(property="confirm_password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuari registrat correctament",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="jwt-token"),
     *                 @OA\Property(property="name", type="string", example="Marc")
     *             ),
     *             @OA\Property(property="message", type="string", example="User created successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error validation"),
     *             @OA\Property(property="data", type="object", example={"email": {"The email field is required."}})
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Tanca la sessió de l'usuari",
     *     tags={"Autenticació"},
     *     @OA\Response(
     *         response=200,
     *         description="Usuari desconnectat correctament",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="name", type="string", example="Marc"),
     *             @OA\Property(property="message", type="string", example="User successfully signed out.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autoritzat",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthorised.")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {

        $user = request()->user(); //or Auth::user()
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        $success['name'] =  $user->name;
         return $this->sendResponse($success, 'User successfully signed out.');
    }

    /**
     * @OA\Get(
     *     path="/api/login/google/callback",
     *     summary="Callback d'autenticació de Google",
     *     tags={"Autenticació"},
     *     @OA\Response(
     *         response=200,
     *         description="Autenticació correcta via Google",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="jwt-token"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=15),
     *                 @OA\Property(property="name", type="string", example="Toni"),
     *                 @OA\Property(property="email", type="string", format="email", example="jsegura@bolsa.lana")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuari no trobat",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User not found in the system. Please, contact the coordinator.")
     *         )
     *     )
     * )
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    /**
     * @OA\Get(
     *     path="/api/auth/google/callback",
     *     summary="Gestiona la resposta de Google OAuth i autentica l'usuari",
     *     tags={"Autenticació"},
     *     @OA\Parameter(
     *         name="code",
     *         in="query",
     *         description="Codi d'autorització rebut de Google",
     *         required=true,
     *         @OA\Schema(type="string", example="4/0AX4XfW...")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Autenticació correcta",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6..."),
     *             @OA\Property(property="token_type", type="string", example="Bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Codi d'autorització invàlid o no proporcionat",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid authorization code.")
     *         )
     *     )
     * )
     */
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Cerca l'usuari o crea'l si no existeix
        // $user = User::firstOrCreate(
        //     ['email' => $googleUser->getEmail()],
        //     [
        //         'name' => $googleUser->getName(),
        //         'surnames' => $googleUser->user['family_name'],
        //         'hireDate' => now(),
        //         'username' => $googleUser->getEmail(),
        //         'google_id' => $googleUser->getId(),
        //         'avatar' => $googleUser->getAvatar(),
        //         'password' => bcrypt(str()->random(24)), // Contrassenya aleatòria
        //     ]
        // );
        $user = User::where('email', $googleUser->getEmail())->first();
        $errorMessage = 'User not found in the system. Please, contact the coordinator.';
        if (!$user) {
            return response()->view('auth.popup', compact('errorMessage'));
        }

        // Actualiza la información del usuario si es necesario
        $user->update([
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
        ]);

        // // Generate token for the user
        $token = $user->createToken('MyAuthApp')->plainTextToken;



        // Return a JSON response for the Vue app
        // return $this->sendResponse([
        //     'token' => $token,
        //     'user' => OperatorResource::make($user),
        // ], 'User authenticated via Google');

        return response()->view('auth.popup', compact('token', 'user', ));
    }

}