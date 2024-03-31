<x-business-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('guest.user.password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input.label for="password" :value="__('Password')" framework="tailwind" />

            <x-input.text id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            framework="tailwind"
                            required autocomplete="current-password" />

            <x-input.error :messages="$errors->get('password')" framework="tailwind" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-button.primary framework="tailwind">
                {{ __('Confirm') }}
            </x-button.primary>
        </div>
    </form>
</x-business-guest-layout>
