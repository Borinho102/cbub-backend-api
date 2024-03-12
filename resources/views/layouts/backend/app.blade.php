<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Cbub') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,500;1,600;1,700;1,800;1,900&amp;display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap">
        <!-- Scripts -->
        <link href="{{ mix('dist/cbub-backend.css') }}" rel="stylesheet">
        {{-- <link href="{{ mix('dist/tailwind.css') }}" rel="stylesheet"> --}}
        <script type="text/javascript" src="{{ mix('dist/cbub-backend.js') }}" defer></script>
        {{-- <script type="text/javascript" src="{{ mix('dist/manifest.js') }}"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    </head>
    <body>
        @php
            $auth = Auth::guard(cbubGuard())->user();
            $profile_picture = $auth->getFirstMedia()->getUrl();
        @endphp

        <div class="page-wrapper">
            <!-- Page Header Start-->
            @include('layouts.backend.partials.header')
            <!-- Page Header Ends -->

            <!-- Page Body Start-->
            <div class="page-body-wrapper">
                <!-- Page Sidebar Start-->
                @include('layouts.backend.partials.sidebar')
                <!-- Page Sidebar Ends-->

                <!-- Right sidebar Start-->
                <div class="right-sidebar" id="right_side_bar">
                    <div>
                        <div class="container p-0">
                            <div class="modal-header p-l-20 p-r-20">
                                <div class="col-sm-8 p-0">
                                    <h6 class="modal-title font-weight-bold">FRIEND LIST</h6>
                                </div>
                                <div class="col-sm-4 text-end p-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings me-2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                </div>
                            </div>
                        </div>
                        <div class="friend-list-search mt-0">
                            <input type="text" placeholder="search friend">
                            <i class="fa fa-search"></i>
                        </div>
                        <div class="p-l-30 p-r-30 friend-list-name">
                            <div class="chat-box">
                                <div class="people-list friend-list">
                                    <ul class="list">
                                        <li class="clearfix">
                                            <img class="rounded-circle user-image blur-up lazyloaded" src="assets/images/dashboard/user.jpg" alt="">
                                            <div class="status-circle online"></div>
                                            <div class="about">
                                                <div class="name">Vincent Porter</div>
                                                <div class="status">Online</div>
                                            </div>
                                        </li>
                                        <li class="clearfix">
                                            <img class="rounded-circle user-image blur-up lazyloaded" src="assets/images/dashboard/user1.jpg" alt="">
                                            <div class="status-circle away"></div>
                                            <div class="about">
                                                <div class="name">Ain Chavez</div>
                                                <div class="status">28 minutes ago</div>
                                            </div>
                                        </li>
                                        <li class="clearfix">
                                            <img class="rounded-circle user-image blur-up lazyloaded" src="assets/images/dashboard/user2.jpg" alt="">
                                            <div class="status-circle online"></div>
                                            <div class="about">
                                                <div class="name">Kori Thomas</div>
                                                <div class="status">Online</div>
                                            </div>
                                        </li>
                                        <li class="clearfix">
                                            <img class="rounded-circle user-image blur-up lazyloaded" src="assets/images/dashboard/user3.jpg" alt="">
                                            <div class="status-circle online"></div>
                                            <div class="about">
                                                <div class="name">Erica Hughes</div>
                                                <div class="status">Online</div>
                                            </div>
                                        </li>
                                        <li class="clearfix">
                                            <img class="rounded-circle user-image blur-up lazyloaded" src="assets/images/dashboard/user3.jpg" alt="">
                                            <div class="status-circle offline"></div>
                                            <div class="about">
                                                <div class="name">Ginger Johnston</div>
                                                <div class="status">2 minutes ago</div>
                                            </div>
                                        </li>
                                        <li class="clearfix">
                                            <img class="rounded-circle user-image blur-up lazyloaded" src="assets/images/dashboard/user5.jpg" alt="">
                                            <div class="status-circle away"></div>
                                            <div class="about">
                                                <div class="name">Prasanth Anand</div>
                                                <div class="status">2 hour ago</div>
                                            </div>
                                        </li>
                                        <li class="clearfix">
                                            <img class="rounded-circle user-image blur-up lazyloaded" src="assets/images/dashboard/designer.jpg" alt="">
                                            <div class="status-circle online"></div>
                                            <div class="about">
                                                <div class="name">Hileri Jecno</div>
                                                <div class="status">Online</div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right sidebar Ends-->

                <div class="page-body">
                    {{ $slot }}
                </div>

                <!-- footer start-->
                @include('layouts.backend.partials.footer')
                <!-- footer end-->
            </div>
        </div>
    </body>
</html>
