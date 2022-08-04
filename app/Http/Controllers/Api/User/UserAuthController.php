<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class UserAuthController extends Controller
{
    //

    public function register(RegisterRequest $request)
    {
        try {
            $credentials = array_merge(
                $request->only(['name', 'email']),
                [
                    'password' => bcrypt($request->password),

                ]
            );

            $user = User::create($credentials);
            $token = $user->createToken('apiToken')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token,
                'status' => true,
                'message' => 'User Created Successfully',
            ];
            return response($response, 200);
        } catch (\Throwable$th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(LoginRequest $request)
    {
        try {

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
            ], 200);
        } catch (\Throwable$th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    public function logoutUser(Request $request)
    {
        Auth::user()->tokens()->where('id', 1)->delete();
        return [
            'message' => 'logged out',
        ];
    }

}
