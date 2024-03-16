<div class="page-sidebar">
    <div class="main-header-left d-none d-lg-block">
        <div class="logo-wrapper">
            <a href="index.html">
                <img class="d-none d-lg-block blur-up lazyloaded" src="{{ asset('backend/images/dashboard/multikart-logo.png') }}" alt="">
            </a>
        </div>
    </div>
    @if (cbubGuard() == 'admins')
        <div class="sidebar custom-scrollbar">
            <a href="javascript:void(0)" class="sidebar-back d-lg-none d-block"><i class="fa fa-times" aria-hidden="true"></i></a>
            <div class="sidebar-user">
                <img class="img-60" src="{{ $profile_picture }}" alt="#">
                <div>
                    <h6 class="f-14">{{ $auth->name }}</h6>
                    <p>general manager.</p>
                </div>
            </div>
            <ul class="sidebar-menu">
                <li class="active">
                    <a
                        class="sidebar-header {{ request()->is('admin.dashboard') ? 'active' : '' }}"
                        wire:navigate href="{{ route('admin.dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a
                        class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span>Businesses</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a wire:navigate href="{{ route('admin.businesses.categories.index') }}">
                                <i class="fa fa-circle"></i>Category
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('admin.businesses.index') }}">
                                <i class="fa fa-circle"></i>Business List
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('admin.businesses.create') }}">
                                <i class="fa fa-circle"></i>Create Business
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        <span>Products</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>

                    <ul class="sidebar-submenu">
                        <li>
                            <a href="javascript:void(0)">
                                <i class="fa fa-circle"></i>
                                <span>Physical</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>

                            <ul class="sidebar-submenu">
                                <li>
                                    <a wire:navigate href="{{ route('admin.products.categories.index') }}">
                                        <i class="fa fa-circle"></i>Category
                                    </a>
                                </li>

                                <li>
                                    <a wire:navigate href="{{ route('admin.products.index') }}">
                                        <i class="fa fa-circle"></i>Product List</a>
                                </li>

                                <li>
                                    <a wire:navigate href="{{ route('admin.products.create') }}">
                                        <i class="fa fa-circle"></i>Add Product
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="product-review.html">
                                <i class="fa fa-circle"></i>
                                <span>product Review</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-archive"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                        <span>Orders</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>

                    <ul class="sidebar-submenu">
                        <li>
                            <a href="order-list.html">
                                <i class="fa fa-circle"></i>
                                <span>Order List</span>
                            </a>
                        </li>

                        <li>
                            <a href="order-tracking.html">
                                <i class="fa fa-circle"></i>
                                <span>Order Tracking</span>
                            </a>
                        </li>

                        <li>
                            <a href="order-detail.html">
                                <i class="fa fa-circle"></i>
                                <span>Order Details</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        <span>Sales</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="order.html">
                                <i class="fa fa-circle"></i>Orders
                            </a>
                        </li>
                        <li>
                            <a href="transactions.html">
                                <i class="fa fa-circle"></i>Transactions
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        <span>Coupons</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="coupon-list.html">
                                <i class="fa fa-circle"></i>List Coupons
                            </a>
                        </li>
                        <li>
                            <a href="coupon-create.html">
                                <i class="fa fa-circle"></i>Create Coupons
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                        <span>Pages</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="pages-list.html">
                                <i class="fa fa-circle"></i>List Page
                            </a>
                        </li>
                        <li>
                            <a href="page-create.html">
                                <i class="fa fa-circle"></i>Create Page
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="media.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                        <span>Media</span>
                    </a>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-align-left"><line x1="17" y1="10" x2="3" y2="10"></line><line x1="21" y1="6" x2="3" y2="6"></line><line x1="21" y1="14" x2="3" y2="14"></line><line x1="17" y1="18" x2="3" y2="18"></line></svg>
                        <span>Menus</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="menu-list.html">
                                <i class="fa fa-circle"></i>Menu Lists
                            </a>
                        </li>
                        <li>
                            <a href="create-menu.html">
                                <i class="fa fa-circle"></i>Create Menu
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                        <span>Users</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="user-list.html">
                                <i class="fa fa-circle"></i>User List
                            </a>
                        </li>
                        <li>
                            <a href="create-user.html">
                                <i class="fa fa-circle"></i>Create User
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chrome"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="4"></circle><line x1="21.17" y1="8" x2="12" y2="8"></line><line x1="3.95" y1="6.06" x2="8.54" y2="14"></line><line x1="10.88" y1="21.94" x2="15.46" y2="14"></line></svg>
                        <span>Localization</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="translations.html"><i class="fa fa-circle"></i>Translations
                            </a>
                        </li>
                        <li>
                            <a href="currency-rates.html"><i class="fa fa-circle"></i>Currency Rates
                            </a>
                        </li>
                        <li>
                            <a href="taxes.html"><i class="fa fa-circle"></i>Taxes
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="support-ticket.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg><span>Support Ticket</span>
                    </a>
                </li>

                <li>
                    <a class="sidebar-header" href="reports.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg><span>Reports</span>
                    </a>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg><span>Settings</span><i class="fa fa-angle-right pull-right"></i></a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="profile.html"><i class="fa fa-circle"></i>Profile
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="invoice.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-archive"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg><span>Invoice</span></a>
                </li>

                <li>
                    <a class="sidebar-header" href="forgot-password.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-key"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
                        <span>Forgot Password</span>
                    </a>
                </li>

                <li>
                    <a class="sidebar-header" href="login.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-in"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                        <span>Login</span>
                    </a>
                </li>
            </ul>
        </div>
    @elseif (cbubGuard() == 'users')
        <div class="sidebar custom-scrollbar">
            <a href="javascript:void(0)" class="sidebar-back d-lg-none d-block"><i class="fa fa-times" aria-hidden="true"></i></a>
            <div class="sidebar-user">
                <img class="img-60" src="{{ $profile_picture }}" alt="#">
                <div>
                    <h6 class="f-14">{{ $auth->name }}</h6>
                    <p>general manager.</p>
                </div>
            </div>
            <ul class="sidebar-menu">
                <li class="active">
                    <a
                        class="sidebar-header {{ request()->is('console.dashboard') ? 'active' : '' }}"
                        wire:navigate href="{{ route('console.dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        <span>Products</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>

                    <ul class="sidebar-submenu">
                        <li>
                            <a href="javascript:void(0)">
                                <i class="fa fa-circle"></i>
                                <span>Physical</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>

                            <ul class="sidebar-submenu">
                                <li>
                                    <a wire:navigate href="{{ route('console.categories.index') }}">
                                        <i class="fa fa-circle"></i>Category
                                    </a>
                                </li>

                                <li>
                                    <a wire:navigate href="{{ route('console.products.index') }}">
                                        <i class="fa fa-circle"></i>Product List</a>
                                </li>

                                <li>
                                    <a wire:navigate href="{{ route('console.products.create') }}">
                                        <i class="fa fa-circle"></i>Add Product
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="product-review.html">
                                <i class="fa fa-circle"></i>
                                <span>product Review</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-archive"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                        <span>Orders</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>

                    <ul class="sidebar-submenu">
                        <li>
                            <a href="order-list.html">
                                <i class="fa fa-circle"></i>
                                <span>Order List</span>
                            </a>
                        </li>

                        <li>
                            <a href="order-tracking.html">
                                <i class="fa fa-circle"></i>
                                <span>Order Tracking</span>
                            </a>
                        </li>

                        <li>
                            <a href="order-detail.html">
                                <i class="fa fa-circle"></i>
                                <span>Order Details</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        <span>Sales</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="order.html">
                                <i class="fa fa-circle"></i>Orders
                            </a>
                        </li>
                        <li>
                            <a href="transactions.html">
                                <i class="fa fa-circle"></i>Transactions
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        <span>Coupons</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="coupon-list.html">
                                <i class="fa fa-circle"></i>List Coupons
                            </a>
                        </li>
                        <li>
                            <a href="coupon-create.html">
                                <i class="fa fa-circle"></i>Create Coupons
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                        <span>Pages</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="pages-list.html">
                                <i class="fa fa-circle"></i>List Page
                            </a>
                        </li>
                        <li>
                            <a href="page-create.html">
                                <i class="fa fa-circle"></i>Create Page
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="media.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                        <span>Media</span>
                    </a>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-align-left"><line x1="17" y1="10" x2="3" y2="10"></line><line x1="21" y1="6" x2="3" y2="6"></line><line x1="21" y1="14" x2="3" y2="14"></line><line x1="17" y1="18" x2="3" y2="18"></line></svg>
                        <span>Menus</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="menu-list.html">
                                <i class="fa fa-circle"></i>Menu Lists
                            </a>
                        </li>
                        <li>
                            <a href="create-menu.html">
                                <i class="fa fa-circle"></i>Create Menu
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                        <span>Users</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="user-list.html">
                                <i class="fa fa-circle"></i>User List
                            </a>
                        </li>
                        <li>
                            <a href="create-user.html">
                                <i class="fa fa-circle"></i>Create User
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span>Vendors</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="list-vendor.html">
                                <i class="fa fa-circle"></i>Vendor List
                            </a>
                        </li>
                        <li>
                            <a href="create-vendors.html">
                                <i class="fa fa-circle"></i>Create Vendor
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chrome"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="4"></circle><line x1="21.17" y1="8" x2="12" y2="8"></line><line x1="3.95" y1="6.06" x2="8.54" y2="14"></line><line x1="10.88" y1="21.94" x2="15.46" y2="14"></line></svg>
                        <span>Localization</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="translations.html"><i class="fa fa-circle"></i>Translations
                            </a>
                        </li>
                        <li>
                            <a href="currency-rates.html"><i class="fa fa-circle"></i>Currency Rates
                            </a>
                        </li>
                        <li>
                            <a href="taxes.html"><i class="fa fa-circle"></i>Taxes
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="support-ticket.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg><span>Support Ticket</span>
                    </a>
                </li>

                <li>
                    <a class="sidebar-header" href="reports.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg><span>Reports</span>
                    </a>
                </li>

                <li>
                    <a class="sidebar-header" href="javascript:void(0)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg><span>Settings</span><i class="fa fa-angle-right pull-right"></i></a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="profile.html"><i class="fa fa-circle"></i>Profile
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="sidebar-header" href="invoice.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-archive"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg><span>Invoice</span></a>
                </li>

                <li>
                    <a class="sidebar-header" href="forgot-password.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-key"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
                        <span>Forgot Password</span>
                    </a>
                </li>

                <li>
                    <a class="sidebar-header" href="login.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-in"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                        <span>Login</span>
                    </a>
                </li>
            </ul>
        </div>
    @endif
</div>
