<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users,email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors()->first(),
                'message' => __('auth.failed'),
                'code' => "VALIDATION_ERROR",
            ], 406);
        }

        $user = User::where(function ($q) use ($request) {
            $q->where('email', $request->username)
                ->orWhere('phone', $request->username);
        })->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        $user->tokens()->delete();
        $token = $user->createToken('cbub user console');
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

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed|min:6'
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors()->first(),
                'message' => __('auth.failed'),
                'code' => "VALIDATION_ERROR",
            ], 406);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => explode('@', $request->email)[0],
            'email' => $request->email,
            'password' => $request->password,
            'device_token' => $request->headers->get('device-token'),
            'device_platform' => $request->headers->get('device-platform'),
            'language' => $request->headers->get('accept-language')
        ]);

        $token = $user->createToken('cbub user console');
        $response = [
            'code' => 'REGISTER_SUCCESS',
            'token_type' => 'Bearer',
            'status' => true,
            'message' => 'Successfully sign in.',
            'auth_token' => $token->plainTextToken,
            'user' => UserResource::make($user)
        ];

        return response($response);
    }

    public function getAuthenticatedUserData(Request $request)
    {
        return response([
            'message' => 'User data successfully retrieved',
            'code' => 'USER_DATA_RETRIEVED',
            'user' => UserResource::make($request->user())
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
