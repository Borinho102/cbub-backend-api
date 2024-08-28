<div class="grow">
    <!-- Panel body -->
    <div class="p-6 space-y-6">
        <h2 class="text-2xl text-slate-800 dark:text-slate-100 font-bold mb-5">{{ __('Update Password') }}</h2>
        <section>
            <header>
                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                </p>
            </header>

            <form id="update-password" wire:submit.prevent="updatePassword" class="mt-6 space-y-6">
                <div>
                    <x-input.label for="form.current_password" :value="__('Current Password')" />
                    <x-input.text wire:model.blur="form.current_password" id="form.current_password" name="form.current_password" required autocomplete="form.current_password" />
                </div>

                <div>
                    <x-input.label for="form.new_password" :value="__('New Password')" />
                    <x-input.text wire:model.blur="form.new_password" id="form.new_password" name="form.new_password" required autocomplete="form.new_password" />
                </div>

                <div>
                    <x-input.label for="form.confirm_password" :value="__('Confirm Password')" />
                    <x-input.text wire:model.blur="form.confirm_password" id="form.confirm_password" name="form.confirm_password" required autocomplete="form.confirm_password" />
                </div>
            </form>
        </section>
    </div>

    <!-- Panel footer -->
    <footer>
        <div class="flex flex-col px-6 py-5 border-t border-slate-200 dark:border-slate-700">
            <div class="flex self-end">
                <x-button.danger class="mr-2">{{ __('Cancel') }}</x-button.danger>
                <x-button.primary type="submit" form="update-password">
                    <div wire:loading wire:target="updatePassword">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    {{ __('Change') }}
                </x-button.primary>
                @if (session('status') === 'password-updated')
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
