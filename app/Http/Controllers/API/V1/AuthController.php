<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users,email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            $response = [
                'error' => $validator->errors()->first(),
                'message' => __('auth.failed'),
                'code' => "VALIDATION_ERROR",
            ];
            return response($response, 406);
        }

        $login_credentials = ['email' => $request->username, 'password' => $request->password];

        if (Auth::guard('users')->attempt($login_credentials)) {
            $user = Auth::guard('users')->user();
            $user = Auth::loginUsingId($user->id);
            $user->tokens->delete();
            $token = $user->createToken('cbub console');
            $response = [
                'code' => 'LOGIN_SUCCESS',
                'token_type' => 'Bearer',
                'status' => true,
                'message' => 'Successfully logged in.',
                'auth_token' => $token->plainTextToken,
                'user' => UserResource::make($user)
            ];

            return response($response);
        }

        return response([
            'message' => __('auth.failed'),
            'code' => "INVALID_CREDENTIALS",
        ], 406);
    }

    public function getAuthenticatedUserData(Request $request) {
        $user = Auth::user();
        return response([
            'message' => 'User data successfully retrieved',
            'code' => 'USER_DATA_RETRIEVED',
            'user' => UserResource::make($user)
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        session()->forget('password_verified_at');
        session()->invalidate();

        return response([
            'message' => 'You have been successfully logged out!',
            'CODE' => 'USER_LOGOUT'
        ], 200);
    }


    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users']);
        Password::broker('users')
            ->sendResetLink($request->only('email'));

        return response([
            'message' => __('auth.verification_link_sent', ['email' => $request->email])
        ], 200);
    }
}
