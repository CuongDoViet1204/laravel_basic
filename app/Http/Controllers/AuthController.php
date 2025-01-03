<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(LoginRequest $request) 
    {
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

        $access_token = $user->createToken('accessToken', ['*'], now()->addHours(config('sanctum.expiration') / 60));
        $refresh_token = $user->createToken('refreshToken', ['refresh-token'], now()->addHours(config('sanctum.rt_expiration') / 60));
        
        $cookie = Cookie::make(
            'access_token',          // Tên cookie
            $access_token->plainTextToken,           // Giá trị
            60,                       // Thời gian tồn tại (60 phút)
            '/',                      // Đường dẫn (path)
            null,                     // Tên miền (domain)
            false,                     // Secure (chỉ truyền qua HTTPS)
            false,                     // HttpOnly
            false,                    // Raw (cho phép raw cookie)
            'None'                  // SameSite policy
        );

        return response()->json([
            'status_code' => 200,
            'access_token' => $access_token->plainTextToken,
            'expires_at' => $access_token->accessToken->expires_at,
            'refresh_token' => $refresh_token->plainTextToken,
            'rt_expires_at' => $refresh_token->accessToken->expires_at,
        ])->withCookie($cookie);
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

    public function refresh(Request $request)
    {
        $access_token = $request->user()->createToken('accessToken', ['*'], now()->addHours(config('sanctum.expiration') / 60));
        return response()->json([
            'status_code' => 200,
            'access_token' => $access_token->plainTextToken,
            'expires_at' => $access_token->accessToken->expires_at,
        ]);
    }
}
