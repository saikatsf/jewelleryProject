    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <!-- Google Fonts Roboto -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"
    />
    <!-- MDB -->
    <link rel="stylesheet" href="/md5/css/mdb.min.css" />
@extends('layout')

@section('content')


        <!-- Carousel wrapper -->
        <div id="carouselVideoExample" class="carousel slide carousel-fade" data-mdb-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-mdb-target="#carouselVideoExample" data-mdb-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-mdb-target="#carouselVideoExample" data-mdb-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-mdb-target="#carouselVideoExample" data-mdb-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-mdb-target="#carouselVideoExample" data-mdb-slide-to="3" aria-label="Slide 3"></button>
            </div>

            <!-- Inner -->
            <div class="carousel-inner">
                <!-- Single item -->
                <div class="carousel-item active" data-mdb-interval="4000">
                    <video class="img-fluid" autoplay loop muted>
                        <source src="/banners/BANNER1.mp4" type="video/mp4"/>
                    </video>
                </div>

                <!-- Single item -->
                <div class="carousel-item" data-mdb-interval="4000">
                    <video class="img-fluid" autoplay loop muted>
                        <source src="/banners/BANNER2.mp4" type="video/mp4"/>
                    </video>
                </div>

                <!-- Single item -->
                <div class="carousel-item" data-mdb-interval="4000">
                    <video class="img-fluid" autoplay loop muted>
                        <source src="/banners/BANNER3.mp4" type="video/mp4"/>
                    </video>
                </div>

                <!-- Single item -->
                <div class="carousel-item" data-mdb-interval="4000">
                    <video class="img-fluid" autoplay loop muted>
                        <source src="/banners/BANNER4.mp4" type="video/mp4"/>
                    </video>
                </div>

            </div>
            <!-- Inner -->

            <!-- Controls -->
            {{-- <button class="carousel-control-prev" type="button" data-mdb-target="#carouselVideoExample" data-mdb-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>

            <button class="carousel-control-next" type="button" data-mdb-target="#carouselVideoExample" data-mdb-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button> --}}
        </div>
        <!-- Carousel wrapper -->

      
    <div class="banner-section spad">
        <div class="container-fluid">
            <div class="row">
                @foreach($hs_categories as $cat)
                    @php $catID=Crypt::encrypt($cat->category_id) @endphp
                        <div class="col-lg-4 pb-1">
                            <a href="/productlist?category={{$catID}}">
                                <div class="single-banner">
                                    <img src="{{ URL::asset('imageUploads/'.$cat->category_img) }}" alt="" style="height:300px"/>
                                    <div class="inner-text">
                                        <h4>{{$cat->category_name}}</h4>
                                    </div>
                                </div>
                            </a> 
                        </div>
                @endforeach
            </div>
        </div>
    </div>

    <section class="women-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="product-large set-bg" data-setbg="assets/img/women-large.jpg">
                        <h2>New Arrivals</h2>
                        <a href="/productlist?sortby=latest">Discover More</a>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-1 py-5">
                    <div class="product-slider owl-carousel py-5">
                      @foreach ($newproducts as $item)
                        @php $prodID= Crypt::encrypt($item->product_id); @endphp
                        <div class="product-item">
                            <a href="/product/{{$prodID}}">
                                <div class="pi-pic">
                                    <img src="{{ URL::asset('imageUploads/'.$item->coverimage->product_img) }}" alt="" />
                                </div>
                                <div class="pi-text">
                                    <div class="catagory-name">{{ $item->category->category_name }}</div>
                                    
                                        <h5>{{ $item->product_name }}</h5>
                                    
                                    <div class="product-price">
                                        &#8377; {{ $item->price }}
                                        <span>&#8377; {{ intval(100 / ( 100 - $item->discount) * $item->price ) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                      @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <section class="deal-of-week set-bg spad" data-setbg="assets/img/time-bg.jpg">
        <div class="container">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h2>Deal Of The Week</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed<br /> do ipsum dolor sit amet,
                        consectetur adipisicing elit </p>
                    <div class="product-price">
                        $35.00
                        <span>/ HanBag</span>
                    </div>
                </div>
                <div class="countdown-timer" id="countdown">
                    <div class="cd-item">
                        <span>56</span>
                        <p>Days</p>
                    </div>
                    <div class="cd-item">
                        <span>12</span>
                        <p>Hrs</p>
                    </div>
                    <div class="cd-item">
                        <span>40</span>
                        <p>Mins</p>
                    </div>
                    <div class="cd-item">
                        <span>52</span>
                        <p>Secs</p>
                    </div>
                </div>
                <a href="#" class="primary-btn">Shop Now</a>
            </div>
        </div>
    </section> --}}

    <section class="man-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 py-5">
                    
                    <div class="product-slider owl-carousel py-5">
                      @foreach ($bestsellers as $item)
                        @php $prodID= Crypt::encrypt($item->product_id); @endphp
                        <div class="product-item">
                            <a href="/product/{{$prodID}}">
                                <div class="pi-pic">
                                    <img src="{{ URL::asset('imageUploads/'.$item->coverimage->product_img) }}" alt="" />
                                </div>
                                <div class="pi-text">
                                    <div class="catagory-name">{{ $item->category->category_name }}</div>
                                    
                                        <h5>{{ $item->product_name }}</h5>
                                    
                                    <div class="product-price">
                                        &#8377; {{ $item->price }}
                                        <span>&#8377; {{ intval(100 / ( 100 - $item->discount) * $item->price ) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                      
                      @endforeach

                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="product-large set-bg m-large" data-setbg="assets/img/man-large.jpg">
                        <h2>Best Sellers</h2>
                        <a href="/productlist?sortby=popular">Discover More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="latest-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Customer Reviews</h2>
                    </div>
                </div>
            </div>
            <div class="row">

                @foreach ($reviews as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-latest-blog">
                            <img src="{{ URL::asset('/imageUploads/'.$item->coverimage->review_img) }}" alt="" height="200px"/>
                            <div class="latest-text">
                                <div class="tag-list">
                                    <div class="tag-item">
                                        <i class="fa fa-calendar-o"></i>
                                        {{date('M d Y', strtotime($item->created_at))}}
                                    </div>
                                </div>
                                <p>
                                    <h4>{{ $item->review }}</h4>
                                </p>
                                @if ($item->rating == 5)
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                @elseif ($item->rating == 4)
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                @elseif ($item->rating == 3)
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                @elseif ($item->rating == 2)
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                @else
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                
            </div>
        </div>
    </section>

@endsection
<style>
  
  @import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";


  p {
      font-family: 'Poppins', sans-serif;
      font-size: 1.1em;
      font-weight: 300;
      line-height: 1.7em;
  }
  </style>
  <script type="text/javascript" src="/md5/js/mdb.min.js"></script>


