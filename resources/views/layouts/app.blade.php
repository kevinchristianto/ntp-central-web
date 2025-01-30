<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>@yield('title') - Centralized NTP Clock</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- file upload -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/file-upload.css') }}"> --}}
    <!-- file upload -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/plyr.css') }}"> --}}
    <!-- DataTables -->
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css"> --}}
    <!-- full calendar -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/full-calendar.css') }}"> --}}
    <!-- jquery Ui -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}"> --}}
    <!-- editor quill Ui -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/editor-quill.css') }}"> --}}
    <!-- apex charts Css -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/apexcharts.css') }}"> --}}
    <!-- calendar Css -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/calendar.css') }}"> --}}
    <!-- jvector map Css -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/jquery-jvectormap-2.0.5.css') }}"> --}}
    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head> 
<body>
    
    <!--==================== Preloader Start ====================-->
    <div class="preloader">
        <div class="loader"></div>
    </div>
    <!--==================== Preloader End ====================-->
    
    <!--==================== Sidebar Overlay End ====================-->
    <div class="side-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->
    
    <!-- ============================ Sidebar Start ============================ -->
    
    <aside class="sidebar">
        <!-- sidebar close btn -->
        <button type="button" class="sidebar-close-btn text-gray-500 hover-text-white hover-bg-main-600 text-md w-24 h-24 border border-gray-100 hover-border-main-600 d-xl-none d-flex flex-center rounded-circle position-absolute"><i class="ph ph-x"></i></button>
        <!-- sidebar close btn -->
        
        <a href="{{ route('home') }}" class="sidebar__logo text-center p-20 position-sticky inset-block-start-0 bg-white w-100 z-1 pb-10">
            {{-- <img src="assets/images/logo/logo.png" alt="Logo"> --}}
            <h2 class="text-20 text-main-600 mb-0 pb-0 lh-sm">Centralized<br>NTP Clock</h2>
        </a>
        
        <div class="sidebar-menu-wrapper overflow-y-auto scroll-sm">
            <div class="p-20 pt-10 mt-20">
                <ul class="sidebar-menu">
                    <li class="sidebar-menu__item">
                        <a href="{{ route('home') }}/" class="sidebar-menu__link">
                            <span class="icon"><i class="ph ph-house"></i></span>
                            <span class="text">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-menu__item">
                        <a href="{{ route('clocks.index') }}" class="sidebar-menu__link">
                            <span class="icon"><i class="ph ph-clock"></i></span>
                            <span class="text">Manage NTP Clock</span>
                        </a>
                    </li>
                    <li class="sidebar-menu__item">
                        <a href="{{ route('users.index') }}" class="sidebar-menu__link">
                            <span class="icon"><i class="ph ph-users"></i></span>
                            <span class="text">Manage Users</span>
                        </a>
                    </li>
                    <li class="sidebar-menu__item has-dropdown">
                        <a href="javascript:void(0)" class="sidebar-menu__link">
                            <span class="icon"><i class="ph ph-notebook"></i></span>
                            <span class="text">Logs</span>
                        </a>
                        <!-- Submenu start -->
                        <ul class="sidebar-submenu">
                            <li class="sidebar-submenu__item">
                                <a href="{{ route('logs.user') }}" class="sidebar-submenu__link">User Logs</a>
                            </li>
                            <li class="sidebar-submenu__item">
                                <a href="{{ route('logs.clock') }}" class="sidebar-submenu__link">Clock Logs</a>
                            </li>
                        </ul>
                        <!-- Submenu End -->
                    </li>
                    <li class="sidebar-menu__item has-dropdown">
                        <a href="javascript:void(0)" class="sidebar-menu__link">
                            <span class="icon"><i class="ph ph-database"></i></span>
                            <span class="text">Master Data</span>
                        </a>
                        <!-- Submenu start -->
                        <ul class="sidebar-submenu">
                            <li class="sidebar-submenu__item">
                                <a href="{{ route('master.lines.index') }}" class="sidebar-submenu__link">Production Lines</a>
                            </li>
                        </ul>
                        <!-- Submenu End -->
                    </li>
                </ul>
            </div>
        </div>
        
    </aside>    
    <!-- ============================ Sidebar End  ============================ -->
    
    <div class="dashboard-main-wrapper">
        <div class="top-navbar d-flex">
            
            <div class="flex-align ms-auto">
                <!-- User Profile Start -->
                <div class="dropdown">
                    <button class="users arrow-down-icon border border-gray-200 rounded-pill p-4 d-inline-block pe-40 position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="position-relative">
                            <img src="https://avatar.iran.liara.run/public/49" alt="Image" class="h-32 w-32 rounded-circle">
                            <span class="activation-badge w-8 h-8 position-absolute inset-block-end-0 inset-inline-end-0"></span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu--lg border-0 bg-transparent p-0">
                        <div class="card border border-gray-100 rounded-12 box-shadow-custom">
                            <div class="card-body">
                                <div class="flex-align gap-8 mb-20">
                                    <img src="https://avatar.iran.liara.run/public/49" alt="" class="w-54 h-54 rounded-circle">
                                    <div class="">
                                        <h4 class="mb-0">{{ auth()->user()->name }}</h4>
                                        <p class="fw-medium text-13 text-gray-200">{{ auth()->user()->username }}</p>
                                    </div>
                                </div>
                                <ul class="max-h-270 overflow-y-auto scroll-sm pe-4">
                                    <li class="pt-8 border-top border-gray-100">
                                        <a href="{{ route('logout') }}" class="py-12 text-15 px-20 hover-bg-danger-50 text-gray-300 hover-text-danger-600 rounded-8 flex-align gap-8 fw-medium text-15">
                                            <span class="text-2xl text-danger-600 d-flex"><i class="ph ph-sign-out"></i></span>
                                            <span class="text">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Profile Start -->
                
            </div>
        </div>
        
        
        <div class="dashboard-body">
            <!-- Breadcrumb Start -->
            @yield('breadcrumbs')
            <!-- Breadcrumb End -->

            @if (session()->has('success') || session()->has('failed'))
                <div class="alert alert-{{ session()->get('success') ? 'success' : 'danger' }} alert-dismissible fade show">
                    {{ session()->get('message') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ $error }}
                        <button class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endforeach
            @endif
            @yield('main-content')
        </div>

        <div class="dashboard-footer">
            <div class="flex-between flex-wrap gap-16">
                <p class="text-gray-300 text-13 fw-normal"> Copyright &copy; <script>document.write(new Date().getFullYear())</script> Kalbio Global Medika. All Rights Reserved</p>
            </div>
        </div>
    </div>
    
    
    @yield('modal-section')
    
    <!-- Jquery js -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap Bundle Js -->
    <script src="{{ asset('assets/js/boostrap.bundle.min.js') }}"></script>
    <!-- Phosphor Js -->
    <script src="{{ asset('assets/js/phosphor-icon.js') }}"></script>
    <!-- file upload -->
    {{-- <script src="{{ asset('assets/js/file-upload.js') }}"></script> --}}
    <!-- file upload -->
    {{-- <script src="{{ asset('assets/js/plyr.js') }}"></script> --}}
    <!-- dataTables -->
    {{-- <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script> --}}
    <!-- full calendar -->
    {{-- <script src="{{ asset('assets/js/full-calendar.js') }}"></script> --}}
    <!-- jQuery UI -->
    {{-- <script src="{{ asset('assets/js/jquery-ui.js') }}"></script> --}}
    <!-- jQuery UI -->
    {{-- <script src="{{ asset('assets/js/editor-quill.js') }}"></script> --}}
    <!-- apex charts -->
    {{-- <script src="{{ asset('assets/js/apexcharts.min.js') }}"></script> --}}
    <!-- Calendar Js -->
    {{-- <script src="{{ asset('assets/js/calendar.js') }}"></script> --}}
    <!-- jvectormap Js -->
    {{-- <script src="{{ asset('assets/js/jquery-jvectormap-2.0.5.min.js') }}"></script> --}}
    <!-- jvectormap world Js -->
    {{-- <script src="{{ asset('assets/js/jquery-jvectormap-world-mill-en.js') }}"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.3/jquery-ui.min.js"></script> --}}
    
    <!-- main js -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    @yield('custom-scripts')
</body>
</html>