<?php

namespace App\Http\Controllers;

use App\Events\RegisteredToken;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\HasApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Models\RegisterToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthController extends Controller
{
    use HasApiResponse;

    public function register(RegisterRequest $request)
    {

        $model =  new User();
        $model->name = $request->name;
        $model->email = $request->email;
        $model->password = Hash::make($request->password);
        $model->id_status = 1;

        $model->save();
        $model->afterStore();

        event(new RegisteredToken($model->email));

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user['user'] = Auth::user();
            $user['token'] =  Auth::user()->createToken('myApp')->accessToken;
            return $this->httpSuccess($user, 'User Registered.');
        }

        return $this->httpUnauthorizedError('Unauthorised.', ['error' => 'Username or email is not matched in our records!']);
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user['user'] = Auth::user();
            $user['token'] =  Auth::user()->createToken('myApp')->accessToken;
            return $this->httpSuccess($user, 'User login successfully.');
        }
        return $this->httpUnauthorizedError('Unauthorised.', ['error' => 'Username or email is not matched in our records!']);
    }

    public function logout(User $user)
    {
        $user->logout();

        return response()->json(['Success' => 'Logged out'], 200);
    }

    public function validateCode(Request $request)
    {
        $user =  User::where("email", $request->email)->first();
        if (!$user)
            return response()->json([
                'success' => false,
                'message' => "Usuario Inexistente",
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

        $token = RegisterToken::where("id_user", $user->id)->first();

        if (!$token)
            return response()->json([
                'success' => false,
                'message' => "Solicite un nuevo codigo",
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

        if ($token->due_date < now())
            return response()->json([
                'success' => false,
                'message' => "Codigo Vencido, Solicite uno Nuevo",
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

        if ($token->code != $request->code)
            return response()->json([
                'success' => false,
                'message' => "Codigo Incorrecto",
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

        $user->email_verified_at = now();
        $user->save();
        return response()->json(["success" => true, "message" => "Correo Verificado"]);
    }

    public function resendCode(Request $request)
    {
        $user = User::where("email", $request->email)->first();

        if (!$user)
            return response()->json([
                'success' => false,
                'message' => "Usuario Inexistente",
            ], Response::HTTP_UNPROCESSABLE_ENTITY);


        event(new RegisteredToken($user->email));
        return response()->json(["success" => true, "message" => "Se ha enviado un correo con el codigo"]);
    }

    public function checktoken(Request $request)
    {
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return true;
        }

        return response()->json([
            'success' => false,
            'message' => "Usuario Inexistente",
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
