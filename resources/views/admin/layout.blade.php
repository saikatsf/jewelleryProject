<head>

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

    
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>

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


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="/adminpanel" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary">jAdmin</h3>
                </a>
                <div class="navbar-nav w-100">
                    <a href="/adminpanel" class="nav-item nav-link dashboard"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="/adminpanel/managecategories" class="nav-item nav-link category"><i class="fa fa-th me-2"></i>Categories</a>
                    <a href="/adminpanel/manageproducts" class="nav-item nav-link product"><i class="fas fa-truck me-2"></i>Products</a>
                    <a href="/adminpanel/orders" class="nav-item nav-link order"><i class="fas fa-list-alt me-2"></i>Orders</a>
                    <a href="/adminpanel/managecoupons" class="nav-item nav-link order"><i class="fas fa-list-alt me-2"></i>Coupons</a>
                    <a href="/adminpanel/managereviews" class="nav-item nav-link order"><i class="fas fa-list-alt me-2"></i>Reviews</a>
                    <a href="/adminpanel/managecolors" class="nav-item nav-link order"><i class="fas fa-list-alt me-2"></i>Colors</a>
                    <a href="/adminpanel/managepolishes" class="nav-item nav-link order"><i class="fas fa-list-alt me-2"></i>Polishes</a>
                    <a href="/adminpanel/managecollections" class="nav-item nav-link order"><i class="fas fa-list-alt me-2"></i>Collections</a>
                    <a href="/adminpanel/managesizes" class="nav-item nav-link order"><i class="fas fa-list-alt me-2"></i>Sizes</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="/adminpanel" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>


                <div class="navbar-nav align-items-center ms-auto">

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notification</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">New user added</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">

                            <span class="d-none d-lg-inline-flex">Welcome {{ session('adminname') }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="/adminpanel/logoutadmin" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->


            @yield('content')


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">JewelleryWeb</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            Designed By <a href="https://htmlcodex.com">Saikat Fouzdar</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- Template Javascript -->
    <script src="{{ URL::asset('admin/js/main.js') }}"></script>
</body>
