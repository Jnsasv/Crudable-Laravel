<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUserInfo()
    {
        $user = Auth::user();
        return  response()->json(["success" => true, "message" => "success", "data" =>  $user]);
    }

    public function postUserInfo(Request $request)
    {
        try {

            $user = Auth::user();

            if (!$request->email == $user->mail) {
                //TODO: Logica para enviar correo de verificación de nuevo
            }

            $toedit =  User::where('id', $user->id)->first();

            $toedit->email =  $request->email;
            $toedit->name =  $request->name;
            $toedit->save();

            return  response()->json(["success" => true, "message" => "success", "data" =>  ""]);
        } catch (\Exception $ex) {
            return response()->json(["success" => false, "message" => $ex->getMessage()], 500);
        }
    }
}
