<x-business-guest-layout>
    <form method="POST" action="{{ route('guest.business.register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input.label for="name" :value="__('Name')" framework="tailwind"/>
            <x-input.text id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" framework="tailwind"/>
            <x-input.error :messages="$errors->get('name')" class="mt-2" framework="tailwind"/>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input.label for="email" :value="__('Email')" framework="tailwind"/>
            <x-input.text id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" framework="tailwind"/>
            <x-input.error :messages="$errors->get('email')" class="mt-2" framework="tailwind"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input.label for="password" :value="__('Password')" framework="tailwind"/>

            <x-input.text id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" framework="tailwind"/>

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
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-button.primary class="ms-4" framework="tailwind">
                {{ __('Register') }}
            </x-button.primary>
        </div>
    </form>
</x-business-guest-layout>
