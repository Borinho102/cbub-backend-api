@php
    $user = auth(appGuard())->user();
@endphp

<div class="grow">
    <!-- Panel body -->
    <div class="p-6 space-y-6">
        <h2 class="text-2xl text-slate-800 dark:text-slate-100 font-bold mb-5">{{ __('Profile Information') }}</h2>
        <section>
            <header>
                <p class="mt-1 text-sm text-gray-600">
                    {{ __("Update your account's profile information and email address.") }}
                </p>
            </header>

            <form id="update-profile" wire:submit.prevent="updateProfile" class="mt-6 space-y-6">
                @if ($user->profile_picture)
                    <div>
                        <x:input.image initialImage="{{ $user->profile_picture }}" name="profile_picture_preview" id="profile_picture_preview"/>
                        <x:input.file wire:model.blur="form.profile_picture" name="form.profile_picture" id="form.profile_picture"/>
                    </div>
                @else
                    <div>
                        <x-input.label :value="__('Profile Picture')" for="form.profile_picture"/>
                        <x:input.file wire:model.blur="form.profile_picture" name="form.profile_picture" id="form.profile_picture"/>
                    </div>
                @endif

                <div>
                    <x-input.label for="name" :value="__('Name')" />
                    <x-input.text wire:model.blur="form.name" id="form.name" name="form.name" required autocomplete="form.name" />
                </div>

                <div>
                    <x-input.label for="phone" :value="__('Phone')" />
                    <x-input.text wire:model.blur="form.phone" id="form.phone" name="form.phone" required autocomplete="form.phone" />
                </div>

                <div>
                    <x-input.label for="email" :value="__('Email')" />
                    <x-input.text wire:model.blur="form.email" id="form.email" name="form.email" required autocomplete="form.email" />
                </div>
            </form>
        </section>
    </div>

    <!-- Panel footer -->
    <footer>
        <div class="flex flex-col px-6 py-5 border-t border-slate-200 dark:border-slate-700">
            <div class="flex self-end">
                <x-button.danger class="mr-2">{{ __('Cancel') }}</x-button.danger>
                <x-button.primary type="submit" form="update-profile">
                    <div wire:loading wire:target="updateProfile">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    {{ __('Update') }}
                </x-button.primary>
                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                    >{{ __('Saved.') }}</p>
                @endif
            </div>
        </div>
    </footer>
</div>
