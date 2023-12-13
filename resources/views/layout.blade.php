<!DOCTYPE html>
<html>
  
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
 <!-- Css Styles -->
 <link rel="stylesheet" href="/assets/css/bootstrap.min.css" type="text/css">
 <link rel="stylesheet" href="/assets/css/font-awesome.min.css" type="text/css">
 <link rel="stylesheet" href="/assets/css/themify-icons.css" type="text/css">
 <link rel="stylesheet" href="/assets/css/elegant-icons.css" type="text/css">
 <link rel="stylesheet" href="/assets/css/owl.carousel.min.css" type="text/css">
 <link rel="stylesheet" href="/assets/css/nice-select.css" type="text/css">
 <link rel="stylesheet" href="/assets/css/jquery-ui.min.css" type="text/css">
 <link rel="stylesheet" href="/assets/css/slicknav.min.css" type="text/css">
 <link rel="stylesheet" href="/assets/css/style.css" type="text/css">
 
 <!-- Js Plugins -->
 <script src="https://kit.fontawesome.com/06be0bfffe.js" crossorigin="anonymous"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
 
 <script src="/assets/js/jquery-3.3.1.min.js"></script>
 <script src="/assets/js/bootstrap.min.js"></script>
 <script src="/assets/js/jquery-ui.min.js"></script>
 <script src="/assets/js/jquery.countdown.min.js"></script>
 <script src="/assets/js/jquery.nice-select.min.js"></script>
 <script src="/assets/js/jquery.zoom.min.js"></script>
 <script src="/assets/js/jquery.dd.min.js"></script>
 <script src="/assets/js/jquery.slicknav.js"></script>
 <script src="/assets/js/owl.carousel.min.js"></script>
 <script src="/assets/js/main.js"></script>
</style>

<body>
  <div class="overlay"></div>

  <header class="header-section">
    <div class="header-top">
        <div class="container">
            <div class="ht-left">
                <div class="mail-service">
                    <i class=" fa fa-envelope"></i>
                    jhumstaacreations29g5@gmail.com
                </div>
                <div class="phone-service">
                    <i class=" fa fa-phone"></i>
                    +91 9082619103
                </div>
            </div>
            <div class="ht-right">
              @if (session()->has('username'))
                <a class="login-panel dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <span class="text-dark"> Welcome {{ session('username') }} </span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="#"> <i class="fa fa-solid fa-user me-2"></i> My Account</a></li>
                  <li><a class="dropdown-item" href="/getorders"> <i class="fa fa-solid fa-user me-2"></i> My Orders</a></li>
                  <li><a class="dropdown-item" href="/logoutuser"> <i class="fas fa-sign-out-alt me-2"></i></i> Logout</a></li>
                </ul>
              @else
                <a href="#" class="login-panel" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fa fa-user"></i>Login</a>
              @endif
                
                
                <div class="top-social">
                    <a href="#"><i class="ti-facebook"></i></a>
                    <a href="#"><i class="ti-twitter-alt"></i></a>
                    <a href="#"><i class="ti-linkedin"></i></a>
                    <a href="#"><i class="ti-pinterest"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="inner-header">
            <div class="row">
                <div class="col-lg-2 col-md-2">
                    <div class="logo">
                        <a href="/">
                          <img src="{{ URL::asset('images/logo.jpg') }}" height="50px" alt="Jhumstaa Creations">
                        </a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7">
                  <form method="get" action="/productlist">

                    <div class="advanced-search">
                        <select class="form-select category-btn" aria-label="Default select example" name="category">
                          
                          <option value="{{Crypt::encrypt(0)}}" selected>All Categories</option>
                          @foreach ($categories as $item)
                              @php $catID= Crypt::encrypt($item->category_id); @endphp
                              <option value="{{$catID}}">{{ $item->category_name }}</option>
                          @endforeach

                        </select>
                        <div class="input-group">
                            @if (isset($searchtext) && $searchtext!=NULL)
                                <input type="text" placeholder="What do you need?" name="search" value="{{$searchtext}}"/>
                            @else
                                <input type="text" placeholder="What do you need?" name="search"/>
                            @endif
                            <button class="searchbtn" type="submit"><i class="ti-search"></i></button>
                        </div>
                    </div>
                  </form>
                </div>
                
                <div class="col-lg-3 text-right col-md-3">
                    <ul class="nav-right">
                        {{-- <li class="heart-icon">
                            <a href="#">
                                <i class="icon_heart_alt"></i>
                                <span>1</span>
                            </a>
                        </li> --}}
                        <li class="cart-icon">
                            
                            <a href="/cart">
                                <i class="icon_bag_alt"></i>
                                @if (session()->has('cart'))
                                    <span>{{  count(Session('cart')) }}</span>
                                @endif
                            </a>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="nav-item">
        <div class="container">
            <div class="nav-depart">
                <div class="depart-btn">
                    <i class="ti-menu"></i>
                    <span>All departments</span>
                    <ul class="depart-hover">
                      @foreach ($categories as $item)
                        @php $catID=Crypt::encrypt($item->category_id) @endphp
                        <li><a href="/productlist?category={{$catID}}">{{ $item->category_name }}</a></li>
                        
                      @endforeach
                        
                    </ul>
                </div>
            </div>
            <nav class="nav-menu mobile-menu">
                <ul>
                    <li class="active"><a href="/">Home</a></li>
                    <li><a href="/productlist?category={{Crypt::encrypt(0)}}">Shop</a>
                        <ul class="dropdown">
                            @foreach ($categories as $item)
                                @php $catID=Crypt::encrypt($item->category_id) @endphp
                                <li><a href="/productlist?category={{$catID}}">{{ $item->category_name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="/ContactUs">Contact</a></li>
                    <li><a>Pages</a>
                        <ul class="dropdown">
                            <li><a href="#">Blog Details</a></li>
                            <li><a href="/cart">Shopping Cart</a></li>
                            <li><a href="/checkout">Checkout</a></li>
                            <li><a href="/ContactUs">Contact Us</a></li>
                            <li><a href="/AboutUs">About Us</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <div id="mobile-menu-wrap"></div>
        </div>
    </div>
  </header>

  <!-- Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body row p-0">
                <div class="col bg-light text-center row">
                    <img src="{{ URL::asset('images/logo.jpg') }}" alt="brand logo" class="img-fluid">
                </div>
                <div class="col">
                    <div class="float-end">
                        <button type="button" class="btn-close m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="container mt-5">
                        {{-- login form --}}
                        <form method="post" action="/loginuser">

                          @csrf

                          @if(session()->get('loginmessage'))
                            <p class="alert alert-danger mt-1">{{ session()->get('loginmessage') }}</p>
                          @endif
                            
                            {{-- <div class="form-group text-center">
                                <a href="/Ulogin/google" class="btn btn-danger m-1"><i class="fab fa-google me-2"></i>Login Using Google</a>
                            </div> --}}
                            
                            <div class="form-group m-1">
                                <label for="loginemail">Email or Phone No.:</label>
                                <input type="text" class="form-control" name="user_email_login">
                                @error('user_email_login')
                                    <p class="alert alert-danger mt-1">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="form-group m-1">
                                <label for="loginpwd">Password:</label>
                                <input type="password" class="form-control" name="user_password_login">
                                @error('user_password_login')
                                    <p class="alert alert-danger mt-1">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="float-end pb-3">
                                <a href="/forgotpasswordpage" class="text-primary">Forgot Password ?</a>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-default m-2">Log In</button>
                            </div>
                          </form>

                        <div class="text-center">
                            <p style="cursor:pointer; color:#b8860b" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">New Here ? Click Here</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

  <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-body row p-0">
                  <div class="col bg-light text-center row">
                    <img src="{{ URL::asset('images/logo.jpg') }}" class="w-100" alt="brand logo">
                  </div>
                  <div class="col">
                      <div class="float-end">
                          <button type="button" class="btn-close m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div><br>
                      <div class="mt-5 container">
                          {{-- register form --}}
                          <form method="POST" action="/registeruser">
                              @csrf

                              @if(session()->get('registermessage'))
                                <p class="alert alert-danger mt-1">{{ session()->get('registermessage') }}</p>
                              @endif
                              <div class="form-group m-1">
                                  <label for="fname">Enter your first name:</label>
                                  <input type="text" class="form-control" id="fname" name="user_fname_register">
                                  @error('user_fname_register')
                                      <p class="alert alert-danger mt-1">{{$message}}</p>
                                  @enderror
                              </div>

                              <div class="form-group m-1">
                                <label for="lname">Enter your last name:</label>
                                <input type="text" class="form-control" id="lname" name="user_lname_register">
                                @error('user_lname_register')
                                    <p class="alert alert-danger mt-1">{{$message}}</p>
                                @enderror
                            </div>

                              <div class="form-group m-1">
                                  <label for="email">Email or Phone no.:</label>
                                  <input type="text" class="form-control" id="email" name="user_email_register">
                                  @error('user_email_register')
                                    <p class="alert alert-danger mt-1">{{$message}}</p>
                                  @enderror
                              </div>
                              <div class="form-group m-1">
                                  <label for="pwd">Password:</label>
                                  <input type="password" class="form-control" id="pwd" name="user_password_register">
                                  @error('user_password_register')
                                    <p class="alert alert-danger mt-1">{{$message}}</p>
                                  @enderror
                              </div>
                              <div class="text-center">
                                  <button type="submit" class="btn btn-default m-2">Create Account</button>
                              </div>
                          </form>

                          <div class="text-center">
                              <p style="cursor:pointer; color:#b8860b" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Already Have An Account ? Log In</p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body row p-0">
                <div class="col bg-light text-center row">
                    <img src="{{ URL::asset('images/logo.jpg') }}" alt="brand logo" class="img-fluid">
                </div>
                <div class="col">
                    <div class="float-end">
                        <button type="button" class="btn-close m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="container mt-5">
                        {{-- otp form --}}
                        <form method="post" action="/verifyotp">

                            @csrf

                            @if(session()->get('otpmessage'))
                                <p class="alert alert-success mt-1">{{ session()->get('otpmessage') }}</p>
                            @endif

                            @if (session()->get('verifyemail'))
                                <input type="hidden" value="{{ session()->get('verifyemail') }}" name="user_verify_email">
                            @endif

                            @error('user_verify_email')
                                <p class="alert alert-succeess mt-1">{{$message}}</p>
                            @enderror

                            <div class="form-group m-1">
                                <label for="otp">Enter OTP:</label>
                                <input type="text" class="form-control" name="user_verify_otp">
                                @error('user_verify_otp')
                                    <p class="alert alert-succeess mt-1">{{$message}}</p>
                                @enderror
                            </div>

                            <div>
                                <button type="submit" class="btn btn-default m-2">Verify</button>
                            </div>
                          </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

@yield('content')
  
<footer class="footer-section">
  <div class="container">
      <div class="row">
          <div class="col-lg-3">
              <div class="footer-left">
                  <div class="footer-logo">
                      <a href="/">
                        <img class="rounded" src="{{ URL::asset('images/logo.jpg') }}" height="80px" alt="brand logo">
                      </a>
                  </div>
                  <ul>
                      <li><b>Address: </b>Nandan Kanan,  Santoshpur,  Kolkata-700075</li>
                      <li><b>Phone: </b>+91 9082619103</li>
                      <li><b>Email: </b>jhumstaacreations29g5@gmail.com</li>
                  </ul>
                  <div class="footer-social">
                      <a href="https://www.facebook.com/profile.php?id=100066457855909"><i class="fa fa-facebook"></i></a>
                      <a href="http://www.instagram.com/jhumstaa_creations"><i class="fa fa-instagram"></i></a>
                      {{-- <a href="#"><i class="fa fa-twitter"></i></a>
                      <a href="#"><i class="fa fa-pinterest"></i></a> --}}
                  </div>
              </div>
          </div>
          <div class="col-lg-2 offset-lg-1">
              <div class="footer-widget">
                  <h5>Information</h5>
                  <ul>
                      <li><a href="/AboutUs">About Us</a></li>
                      <li><a href="/TermsAndConditions">Terms & Conditions</a></li>
                      <li><a href="/PrivacyPolicy">Privacy Policy</a></li>
                      <li><a href="/ShippingPolicy">Shipping & Delivery</a></li>
                      <li><a href="/ReturnPolicy">Return Policy</a></li>
                      <li><a href="/ContactUs">Contact Us</a></li>
                  </ul>
              </div>
          </div>
          <div class="col-lg-2">
              <div class="footer-widget">
                  <h5>My Account</h5>
                  <ul>
                      <li><a href="#">My Account</a></li>
                      <li><a href="/checkout">Checkout</a></li>
                      <li><a href="/cart">Shopping Cart</a></li>
                      <li><a href="#">Shop</a></li>
                  </ul>
              </div>
          </div>
          <div class="col-lg-4">
              <div class="newslatter-item">
                  <h5>Join Our Newsletter Now</h5>
                  <p>Get E-mail updates about our latest shop and special offers.</p>
                  <form action="#" class="subscribe-form">
                      <input type="text" placeholder="Enter Your Mail" />
                      <button type="button">Subscribe</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
  <div class="copyright-reserved">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <div class="copyright-text">
                    Copyright &copy;jhumstaacreations2022 All rights reserved
                  </div>
              </div>
          </div>
      </div>
  </div>
</footer>



</body>
</html>

<style>
  .checked {
    color: orange;
  }
  .btn-default{
    background-color: #daa520;
    color:#FFF;
  }

  .btn-default-2{
    color: #daa520;
    border: 1px #daa520 solid;
  }

  .btn-default-2:hover, .btn-default-2:focus, .btn-default-2:active, .btn-default-2.active {
    color:#b8860b;
    border: 1px #b8860b solid;
  }
 
  .btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.active, .open .dropdown-toggle.btn-default {
    background-color: #b8860b;
    color:#FFF;
  }
</style>

@if(session()->get('loginmessage') || $errors->has('user_email_login') || $errors->has('user_password_login'))
    <script>
        $(document).ready(function(){
            $("#loginModal").modal('show');
        });
    </script>
@endif

@if(session()->get('registermessage') || $errors->has('user_fname_register') || $errors->has('user_lname_register') || $errors->has('user_email_register') || $errors->has('user_password_register'))
    <script>
        $(document).ready(function(){
            $("#registerModal").modal('show');
        });
    </script>
@endif

@if(session()->get('otpmessage')|| $errors->has('user_email') || $errors->has('user_verify_otp'))
<script>
    $(document).ready(function(){
        $("#otpModal").modal('show');
    });
</script>
@endif