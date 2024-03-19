<div>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>{{ __('Product List') }}
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
                        <li class="breadcrumb-item active">{{ __('Product List') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="mb-3 d-flex justify-content-end">
                    <a wire:navigate href="{{ route('admin.products.create') }}" class="btn btn-primary add-row mt-md-0 mt-2">
                        {{ __('Add Product') }}
                    </a>
                </div>

                <div class="card">
                    <div class="card-header">
                        <livewire:admin.products.filter wire:model="form" lazy />
                        <form wire:submit="search" class="form-inline search-form search-box">
                            <div class="form-group">
                                <input class="form-control-plaintext" wire:model.live="form.query" type="search" placeholder="Search..">
                            </div>
                        </form>
                    </div>

                    <div class="row products-admin ratio_asos p-4">
                        <div class="col-xl-3 col-sm-6">
                            <div class="card">
                                <div class="card-body product-box">
                                    <div class="img-wrapper">
                                        <div class="front">
                                            <a href="javascript:void(0)"><img src="{{ asset('backend/images/pro3/34.jpg') }}"
                                                    class="img-fluid blur-up lazyload bg-img" alt=""></a>
                                            <div class="product-hover">
                                                <ul>
                                                    <li>
                                                        <button class="btn" type="button" data-original-title=""
                                                            title=""><i class="ti-pencil-alt"></i></button>
                                                    </li>
                                                    <li>
                                                        <button class="btn"><i class="ti-trash"></i></button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-detail">
                                        <div class="rating"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                                class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                                class="fa fa-star"></i></div>
                                        <a href="javascript:void(0)">
                                            <h6>Slim Fit Cotton Shirt</h6>
                                        </a>
                                        <h4>$500.00 <del>$600.00</del></h4>
                                        <ul class="color-variant">
                                            <li class="bg-light0"></li>
                                            <li class="bg-light1"></li>
                                            <li class="bg-light2"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach ($products as $product)
                            <div class="col-xl-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body product-box">
                                        <div class="img-wrapper">
                                            <div class="front">
                                                <a href="javascript:void(0)"><img src="{{ asset('backend/images/fashion/pro/1.jpg') }}"
                                                        class="img-fluid bg-img" alt=""></a>
                                                <div class="product-hover">
                                                    <ul>
                                                        <li>
                                                            <button class="btn" type="button" data-original-title=""
                                                                title=""><i class="ti-pencil-alt"></i></button>
                                                        </li>
                                                        <li>
                                                            <button class="btn"><i class="ti-trash"></i></button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-detail">
                                            <div class="rating"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                                    class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                                    class="fa fa-star"></i></div>
                                            <a href="javascript:void(0)">
                                                <h6>Slim Fit Cotton Shirt</h6>
                                            </a>
                                            <h4>$500.00 <del>$650.00</del></h4>
                                            <ul class="color-variant">
                                                <li class="bg-light0"></li>
                                                <li class="bg-light1"></li>
                                                <li class="bg-light2"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
