<x-business-guest-layout>
    <form method="POST" action="{{ route('guest.business.password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input.label for="email" :value="__('Email')" framework="tailwind"/>
            <x-input.text id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" framework="tailwind"/>
            <x-input.error :messages="$errors->get('email')" class="mt-2" framework="tailwind"/>
        </div>

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
                {{ __('Reset Password') }}
            </x-button.primary>
        </div>
    </form>
</x-business-guest-layout>
