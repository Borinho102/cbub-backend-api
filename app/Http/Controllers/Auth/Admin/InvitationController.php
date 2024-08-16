<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Invitation;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class InvitationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $token)
    {
        if ($request->isMethod('GET')) {
            if (!URL::hasValidSignature($request)) {
                notify()->error(__('Your invitation link has expired, please contact the invitor to send you another link!'));
                return redirect(route('index'));
            }

            $invitation = Invitation::with('invitee')->where('token', $token)->firstOrFail();

            return view('auth.admin.invitation', [
                'invitation' => $invitation,
                'request' => $request
            ]);
        }

        $invitation = Invitation::with('invitee')
            ->where('expires_at', '>', now())
            ->where('invitor_type', Admin::class)
            ->whereNull('accepted_at')
            ->where('token', $token)->firstOrFail();

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $invitation->invitee->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
            'email_verified_at' => now()
        ])->save();

        $invitation->update(['accepted_at' => now()]);

        Auth::guard('admins')->login($invitation->invitee);

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
    }
}
