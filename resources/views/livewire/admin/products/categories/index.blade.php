<div>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>{{ __('Category') }}
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
                        <li class="breadcrumb-item">{{ __('Product') }}</li>
                        <li class="breadcrumb-item active">{{ __('Category') }}</li>
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

                        <a wire:navigate href="{{ route('admin.products.categories.create') }}" class="btn btn-primary add-row mt-md-0 mt-2">
                            {{ __('Add Category') }}
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-desi">
                            <table class="table all-package trans-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Image') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Products') }}</th>
                                        <th>{{ __('Option') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('images/category_placeholder.jpg') }}"
                                                    data-field="image" alt="">
                                            </td>

                                            <td data-field="name">{{ $category->name }}</td>

                                            @if ($category->is_active)
                                                <td class="order-success" data-field="status">
                                                    <span>{{ __('Active') }}</span>
                                                </td>
                                            @else
                                                <td class="order-pending" data-field="status">
                                                    <span>{{ __('Inactive') }}</span>
                                                </td>
                                            @endif

                                            <td data-field="products">{{ $category->products_count }}</td>

                                            <td>
                                                <a wire:navigate href="{{ route('admin.products.categories.edit', $category->id) }}" class="me-1">
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
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
