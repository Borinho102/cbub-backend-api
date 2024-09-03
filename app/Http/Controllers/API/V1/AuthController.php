<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\UserResource;
use App\Mail\OtpVerificationCode;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends ApiController
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

        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip()
        ]);

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
                'message' => $validator->errors()->first(),
                'code' => 'VALIDATION_ERROR',
            ], 406);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => generateUsername(new User, explode('@', $request->email)[0]),
            'email' => $request->email,
            'password' => $request->password,
            'device_token' => $request->header('device-token'),
            'device_platform' => $request->header('device-platform'),
            'language' => $request->header('accept-language', 'en')
        ]);

        $user->syncRoles(['customer']);

        event(new Registered($user));

        return response([
            'code' => 'REGISTER_SUCCESS',
            'message' => 'Successfully sign up.',
            'user' => UserResource::make($user)
        ]);
    }

    public function getUserProfile(Request $request)
    {
        $user = User::find($request->user('api')->id);

        return response([
            'message' => 'User data successfully retrieved',
            'code' => 'USER_DATA_RETRIEVED',
            'user' => UserResource::make($user)
        ], 200);
    }

    public function updateUserProfile(Request $request)
    {
        $user = $request->user('api');

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id . ',id',
            'phone' => 'required|unique:users,phone,' . $user->id . ',id',
            'password' => 'nullable|confirmed|min:6',
            'profile_picture' => 'nullable|image'
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors()->first(),
                'message' => $validator->errors()->first(),
                'code' => 'VALIDATION_ERROR',
            ], 406);
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        if ($request->phone !== $user->phone) {
            $user->phone_verified_at = null;
        }
        if ($request->email !== $user->email) {
            $user->email_verified_at = null;
        }
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->password) {
            $user->password = $request->password;
        }

        $user->update();

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            if ($file->isValid()) {
                $user->addMediaFromRequest('profile_picture')
                    ->usingName('profile_picture')
                    ->usingFileName(time() . '.' . $file->getClientOriginalExtension())
                    ->toMediaCollection('avatar');
            }
        }

        return response([
            'code' => 'PROFILE_UPDATED',
            'message' => 'Profile successfully updated!',
            'user' => UserResource::make($user)
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user('api');

        $user->tokens()->delete();

        session()->flush();

        session()->invalidate();

        return response([
            'message' => 'You have been successfully logged out!',
            'CODE' => 'USER_LOGOUT'
        ], 200);
    }

    public function deleteAccount(Request $request)
    {
        $user = $request->user('api');

        $user->tokens()->delete();

        session()->flush();

        session()->invalidate();

        User::where('id', $user->id)
            ->update([
                'deleted_at' => now(),
                'username' => $user->username . '.' . now()->timestamp,
                'email' => $user->email . '.' . now()->timestamp,
                'phone' => $user->phone . '.' . now()->timestamp
            ]);

        return $this->successfulResponse(
            true,
            'ACCOUNT_DELETED',
            __('Your account has been successfully deleted!'),
        );
    }

    /**
     * Send otp verification code.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendOtpCode(Request $request)
    {
        $user = $request->user('api');

        $request->validate([
            'type' => 'required|in:email,phone',
            'email' => 'required_if:type,email|exists:users,email',
            'phone' => 'required_if:type,phone|exists:users,phone',
        ]);

        $code = generateUniqueOtpCode();
        $otpCode = OtpCode::updateOrCreate([
            'type' => $request->type,
            'user' => $request->get('email', $request->get('phone')),
        ], [
            'code' => $code,
            'expires_at' => now()->addMinutes(10)
        ]);

        if ($request->type == 'email') {
            $user = User::where('email', $request->email)->first();
            Mail::to($user)->send(new OtpVerificationCode($otpCode));
            $message = __('general.otp_successfully_sent_to_email', [
                'email' => $request->email
            ]);
        } else {
            abort(422, __('general.otp_code_via_sms_inactive'));
        }

        return $this->successfulResponse(true, 'OTP_CODE_SENT', $message, 200);
    }

    /**
     * Verify otp verification code.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function verifyOtpCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:email,phone',
            'email' => 'required_if:type,email|exists:users,email',
            'phone' => 'required_if:type,phone|exists:users,phone',
            'code' => 'required|min:6|max:6',
            'action' => 'nullable|in:update-phone-verified-at,update-email-verified-at'
        ]);

        if ($validator->fails()) {
            return $this->badRequestResponse('INVALID_DATA', $validator->errors()->first(), 422);
        }

        $otpCode = OtpCode::latest()
            ->where('code', $request->code)
            ->where('type', $request->type)
            ->where('user', $request->get('email', $request->get('phone')))
            ->first();

        if ($otpCode) {
            if (now()->subMinutes(10) <= $otpCode->expires_at) {
                if ($otpCode->code == $request->code) {
                    if ($request->action === 'update-phone-verified-at') {
                        User::where('phone', $otpCode->user)->update([
                            'phone_verified_at' => now()
                        ]);
                    } else if ($request->action === 'update-email-verified-at') {
                        User::where('email', $otpCode->email)->update([
                            'email_verified_at' => now()
                        ]);
                    }
                    return $this->successfulResponse(true, 'VALID_OTP_CODE', __('general.valid_otp_code'));
                }
            } else {
                $otpCode->delete();
                return $this->badRequestResponse('OTP_CODE_EXPIRED', __('general.otp_code_expired'));
            }
        }

        return $this->badRequestResponse('INVALID_OTP_CODE', __('general.invalid_otp_code'), 422);
    }

    /**
     * Reset password
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'type' => 'required|in:email',
            'email' => 'required_if:type,email|exists:users,email',
            'phone' => 'required_if:type,phone|exists:users,phone',
            'code' => 'required|exists:otp_codes,code',
            'password' => 'required|confirmed|min:6'
        ]);

        $emailOrPhone = $request->get('email', $request->get('phone'));
        $otpCode = OtpCode::latest()
            ->where('code', $request->code)
            ->where('type', $request->type)
            ->where('user', $emailOrPhone)
            ->firstOrFail();

        $user = User::where(function ($q) use ($emailOrPhone) {
            $q->where('email', $emailOrPhone)
                ->orWhere('phone', $emailOrPhone);
        })->firstOrFail();

        $user->password = $request->password;
        $user->save();

        $otpCode->delete();

        return $this->successfulResponse(true, 'PASSWORD_RESET', __('general.password_successfully_reset'));
    }
}
