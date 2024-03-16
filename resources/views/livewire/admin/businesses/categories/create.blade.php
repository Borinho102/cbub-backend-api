<div>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>
                            @if (isset($form->category))
                                {{ __('Update Category') }}
                            @else
                                {{ __('Add Category') }}
                            @endif
                            <small>{{ __('Cbub Admin Panel') }}</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item">
                            <a href="index.html">
                                <i data-feather="home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">{{ __('Dashboard') }}</li>
                        <li class="breadcrumb-item active">
                            @if (isset($form->category))
                                {{ __('Update Category') }}
                            @else
                                {{ __('Add Category') }}
                            @endif
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form wire:submit="save" class="row">
            <div class="row category-adding">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="digital-add needs-validation">
                                <div class="form-group">
                                    <x-input-label :value="__('Name (English)')" for="name_en" required/>
                                    <x-text-input wire:model.live="form.name_en" name="form.name_en" id="name_en" type="text"/>
                                </div>
                                <div class="form-group">
                                    <x-input-label :value="__('Name (French)')" for="name_fr" required/>
                                    <x-text-input wire:model.live="form.name_fr" name="form.name_fr" id="name_fr" type="text"/>
                                </div>
                                <div class="form-group">
                                    <x-input-label :value="__('Code')" for="code" required/>
                                    <x-text-input wire:model.live="form.code" name="form.code" id="code" readonly type="text"/>
                                </div>

                                <div class="form-group">
                                    <x-input-label :value="__('Description (English)')" for="description_en"/>
                                    <x-text-area-input wire:model.live="form.description_en" name="form.description_en" id="description_en" rows="4" cols="12"></x-text-area-input>
                                </div>

                                <div class="form-group">
                                    <x-input-label :value="__('Description (French)')" for="description_fr"/>
                                    <x-text-area-input wire:model.live="form.description_fr" name="form.description_fr" id="description_fr" rows="4" cols="12"></x-text-area-input>
                                </div>

                                <div class="form-group col-xl-4">
                                    <x-input-label :value="__('Logo')" for="logo"/>
                                    <x:file-upload-input wire:model.live="form.logo" name="form.logo" id="logo"/>
                                </div>
                            </div>
                            <div class="mt-4 d-flex justify-content-end">
                                <x-primary-button type="button" class="btn-light me-2">
                                    {{ __('Clear') }}
                                </x-primary-button>
                                <x-primary-button type="submit" class="btn-primary">
                                    @if (isset($form->category))
                                        {{ __('Update') }}
                                    @else
                                        {{ __('Create') }}
                                    @endif
                                </x-primary-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
