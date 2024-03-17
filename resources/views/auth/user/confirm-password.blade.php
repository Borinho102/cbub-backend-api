<x-user-guest-layout>
    <div class="tw-mb-4 tw-text-sm tw-text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('guest.user.password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" framework="tailwind" />

            <x-text-input id="password" class="tw-block tw-mt-1 tw-w-full"
                            type="password"
                            name="password"
                            framework="tailwind"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" framework="tailwind" class="tw-mt-2" />
        </div>

        <div class="tw-flex tw-justify-end tw-mt-4">
            <x-primary-button framework="tailwind">
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-user-guest-layout>
