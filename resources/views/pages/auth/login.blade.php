<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>Sign In - Centralized NTP Clock</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.webp') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
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
    
    <section class="auth d-flex">
        <div class="auth-left bg-main-50 flex-center p-48">
            <img src="{{ asset('assets/images/thumbs/login-illustration.svg') }}" alt="" width="75%">
        </div>
        <div class="auth-right py-40 px-24 flex-center flex-column">
            <div class="auth-right__inner mx-auto w-100">
                <h2 class="mb-8 text-center">Centralized<br>NTP Clock</h2>
                <p class="text-gray-600 text-15 text-center mb-32">Please sign in to continue</p>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ $error }}
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endforeach
                @endif
                <form action="{{ route('authenticate') }}" method="POST">
                    @csrf
                    <div class="mb-24">
                        <label for="fname" class="form-label mb-8 h6">Username</label>
                        <div class="position-relative">
                            <input type="text" class="form-control py-11 ps-40" name="username" id="fname" placeholder="Enter your 3 digit username" autofocus>
                            <span class="position-absolute top-50 translate-middle-y ms-16 text-gray-600 d-flex"><i class="ph ph-user"></i></span>
                        </div>
                    </div>
                    <div class="mb-24">
                        <label for="current-password" class="form-label mb-8 h6">Current Password</label>
                        <div class="position-relative">
                            <input type="password" class="form-control py-11 ps-40" name="password" id="current-password" placeholder="Enter your password">
                            <span class="toggle-password position-absolute top-50 inset-inline-end-0 me-16 translate-middle-y ph ph-eye-slash" id="#current-password"></span>
                            <span class="position-absolute top-50 translate-middle-y ms-16 text-gray-600 d-flex"><i class="ph ph-lock"></i></span>
                        </div>
                    </div>
                    <button class="btn btn-main w-100 rounded-pill">
                        <i class="ph ph-sign-in"></i>
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </section>
    
    <!-- Jquery js -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap Bundle Js -->
    <script src="{{ asset('assets/js/boostrap.bundle.min.js') }}"></script>
    <!-- Phosphor Js -->
    <script src="{{ asset('assets/js/phosphor-icon.js') }}"></script>
    
    <!-- main js -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
</body>
</html>