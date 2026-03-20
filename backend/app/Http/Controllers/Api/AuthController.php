<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function login(Request $request)
{
//var_dump("Login attempt");
// return [
//         'user' => "test",
//         'token' => "test-token"
//     ];
//     exit;
   
    
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['error' => 'Credenciales inválidas'], 401);
    }

    $user->tokens()->delete();

    $token = $user->createToken('api-token')->plainTextToken;

    return [
        'user' => $user,
        'token' => $token
    ];


}
}
