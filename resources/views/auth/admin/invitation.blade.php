<x-business-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="my-4 text-sm p-4 rounded border-l-2 border-sky-500 bg-sky-100 text-sky-500 font-bold">
        {{ __("Welcome :invitee! Before you begin, you'll need to set up your account by defining a new password to log in to your personalized dashboard.", ['invitee' => $invitation->invitee->name]) }}
    </div>

    <form method="POST" action="{{ route('guest.admin.invitation.accept', $request->route('token')) }}">
        @csrf

        <!-- Password -->
        <div class="mt-4">
            <x-input.label for="password" :value="__('Password')" framework="tailwind"/>
            <x-input.text id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" framework="tailwind"/>
            <x-input.error :messages="$errors->get('password')" class="mt-2" framework="tailwind"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input.label for="password_confirmation" :value="__('Confirm Password')" framework="tailwind"/>

            <x-input.text id="password_confirmation" class="block mt-1 w-full"
                type="password"
                name="password_confirmation" required autocomplete="new-password" framework="tailwind"/>

            <x-input.error :messages="$errors->get('password_confirmation')" class="mt-2" framework="tailwind"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button.primary framework="tailwind">
                {{ __('Proceed') }}
            </x-button.primary>
        </div>
    </form>
</x-business-guest-layout>
