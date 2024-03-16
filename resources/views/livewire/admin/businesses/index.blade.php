<div>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>{{ __('Business') }}
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
                        <li class="breadcrumb-item active">{{ __('Business') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <form wire:submit="search" class="form-inline search-form search-box">
                            <div class="form-group">
                                <input class="form-control-plaintext" wire:model.live="query" type="search" placeholder="Search..">
                            </div>
                        </form>

                        <a wire:navigate href="{{ route('admin.businesses.create') }}" class="btn btn-primary add-row mt-md-0 mt-2">
                            {{ __('Add Business') }}
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-desi">
                            <table class="table all-package trans-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Logo') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Phone') }}</th>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Country') }}</th>
                                        <th>{{ __('City') }}</th>
                                        <th>{{ __('Products') }}</th>
                                        <th>{{ __('Users') }}</th>
                                        <th>{{ __('Created At') }}</th>
                                        <th>{{ __('Option') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($businesses as $business)
                                        <tr>
                                            <td>
                                                <img src="{{ $business->getFirstMediaUrl('logo') ?? asset('images/business_placeholder.jpg') }}"
                                                    data-field="image" alt="">
                                            </td>

                                            <td data-field="name">{{ $business->name }}</td>

                                            <td data-field="email">{{ $business->email }}</td>

                                            <td data-field="phone">{{ $business->phone }}</td>

                                            <td data-field="category">{{ $business->category->name }}</td>

                                            <td data-field="country">{{ $business->country->name }}</td>

                                            <td data-field="city">{{ $business->city->name }}</td>

                                            <td data-field="products">{{ $business->products_count }}</td>

                                            <td data-field="users">{{ $business->users_count }}</td>

                                            <td data-field="users">{{ $business->created_at->format('d/m/Y') }}</td>

                                            <td>
                                                <a wire:navigate href="{{ route('admin.businesses.edit', $business->id) }}" class="me-1">
                                                    <i class="fa fa-edit" title="Edit"></i>
                                                </a>

                                                <a href="javascript:void(0)">
                                                    <i class="fa fa-trash" title="Delete"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div>
                                {{ $businesses->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
