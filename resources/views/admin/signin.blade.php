<head>
    <title>Jewellery Admin Sign In</title>

    <!-- Favicon -->
    <link href="{{ URL::asset('admin/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ URL::asset('admin/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('admin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ URL::asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ URL::asset('admin/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            
                            <h3 class="text-primary">jAdmin</h3>
                            <h3>Sign In</h3>
                        </div>
                        <form action="/adminpanel/login" method="post">
                            @csrf

                            @if(session()->get('adminloginmessage'))
                                <p class="alert alert-danger mt-1">{{ session()->get('adminloginmessage') }}</p>
                            @endif
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="admin_email">
                                <label for="floatingInput">Email address</label>
                            </div>
                            @error('admin_email')
                                <p class="alert alert-danger mt-1">{{$message}}</p>
                            @enderror
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="admin_password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            @error('admin_password')
                                <p class="alert alert-danger mt-1">{{$message}}</p>
                            @enderror
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                
                                <a href="">Forgot Password ?</a>
                            </div>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL::asset('admin/lib/chart/chart.min.js') }}"></script>
    <script src="{{ URL::asset('admin/lib/easing/easing.min.js') }}"></script>
    <script src="{{ URL::asset('admin/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ URL::asset('admin/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ URL::asset('admin/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ URL::asset('admin/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ URL::asset('admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ URL::asset('admin/js/main.js') }}"></script>
</body>
