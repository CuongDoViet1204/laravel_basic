<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'email' => array('required', 'email'),
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code' => 400,
                'message' => $validator->errors(),
            ]);
        }

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Unauthorized'
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, $user->password, [])) {
            throw new \Exception('Error in Login');
        }

        $token = $user->createToken('authToken', ['*'], now()->addHour());
        return response()->json([
            'status_code' => 200,
            'expires_at' => $token->accessToken->expires_at,
            'access_token' => $token->plainTextToken,
        ]);
    }

    

    public function logout(Request $request)
    {
        $currentRequestPersonalAccessToken = PersonalAccessToken::findToken($request->bearerToken());
        $currentRequestPersonalAccessToken->delete();
        return response()->json([
            'status_code' => 200,
            'message' => 'Logout success'
        ]);
    }
}
