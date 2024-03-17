<x-admin-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" framework="tailwind"/>
            <x-text-input id="email" class="tw-block tw-mt-1 tw-w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" framework="tailwind"/>
            <x-input-error :messages="$errors->get('email')" class="tw-mt-2" framework="tailwind"/>
        </div>

        <!-- Password -->
        <div class="tw-mt-4">
            <x-input-label for="password" :value="__('Password')" framework="tailwind"/>
            <x-text-input id="password" class="tw-block tw-mt-1 tw-w-full" type="password" name="password" required autocomplete="new-password" framework="tailwind"/>
            <x-input-error :messages="$errors->get('password')" class="tw-mt-2" framework="tailwind"/>
        </div>

        <!-- Confirm Password -->
        <div class="tw-mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" framework="tailwind"/>

            <x-text-input id="password_confirmation" class="tw-block tw-mt-1 tw-w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" framework="tailwind"/>

            <x-input-error :messages="$errors->get('password_confirmation')" class="tw-mt-2" framework="tailwind"/>
        </div>

        <div class="tw-flex tw-items-center tw-justify-end tw-mt-4">
            <x-primary-button framework="tailwind">
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-admin-guest-layout>
