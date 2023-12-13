@extends('layout')

@section('content')
<!-- Font Awesome JS -->
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <div class="container py-5">

        <div class="wrapper">

            <!-- Sidebar  -->
            <nav id="sidebar">
                
                <form method="get" action="/productlist">
                    
                    <div class="sidebar-header">
                        <h3>Filters</h3>
                    </div>

                    <div class="components">

                        @if ($searchtext != NULL)
                            <input type="hidden" name="search" value="{{$searchtext}}">    
                        @endif
                        @if ($category_id != NULL)
                            <input type="hidden" name="category" value="{{$category_id}}">    
                        @endif

                        <div class="my-3">
                            <p class="h6 mx-1 fw-bold"> Sort By</p>

                              <div class="form-check">
                                  @if ($sortby == 'latest')
                                    <input class="form-check-input" type="radio" name="sortby" id="sortby1" value="latest" checked>
                                  @else
                                    <input class="form-check-input" type="radio" name="sortby" id="sortby1" value="latest">
                                  @endif
                                <label class="form-check-label" for="sortby1">
                                    Latest
                                </label>
                              </div>

                              <div class="form-check">
                                @if ($sortby == 'popular')
                                    <input class="form-check-input" type="radio" name="sortby" id="sortby2" value="popular" checked>
                                @else
                                    <input class="form-check-input" type="radio" name="sortby" id="sortby2" value="popular">
                                @endif
                                <label class="form-check-label" for="sortby2">
                                  Popularity
                                </label>
                              </div>

                              <div class="form-check">
                                @if ($sortby == 'low2high')
                                    <input class="form-check-input" type="radio" name="sortby" id="sortby3" value="low2high" checked>
                                @else
                                    <input class="form-check-input" type="radio" name="sortby" id="sortby3" value="low2high">
                                @endif
                                <label class="form-check-label" for="sortby3">
                                    Price : Low to High
                                </label>
                              </div>

                              <div class="form-check">
                                @if ($sortby == 'high2low')
                                    <input class="form-check-input" type="radio" name="sortby" id="sortby4" value="high2low" checked>
                                @else
                                    <input class="form-check-input" type="radio" name="sortby" id="sortby4" value="high2low">
                                @endif
                                <label class="form-check-label" for="sortby4">
                                    Price : High to Low
                                </label>
                              </div>
                        </div>

                        <div class="my-3">
                            
                            <p class="h6 mx-1 fw-bold"> Color :</p>

                            @foreach ($colors as $item)

                                @if( $colorfilter!='none' && in_array($item->color_id, $colorfilter))
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="colorfilter[]" id="colorfilter1" value="{{ $item->color_id }}" checked>
                                        <label class="form-check-label" for="colorfilter1">
                                            {{ $item->color }}
                                        </label>
                                    </div>
                                @else
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="colorfilter[]" id="colorfilter1" value="{{ $item->color_id }}">
                                        <label class="form-check-label" for="colorfilter1">
                                            {{ $item->color }}
                                        </label>
                                    </div>
                                @endif
                                
                            @endforeach

                        </div>


                        <div class="my-3">
                            
                            <p class="h6 mx-1 fw-bold"> Polish :</p>
                            @foreach ($polishes as $item)

                                @if( $polishfilter!='none' && in_array($item->polish_id, $polishfilter))
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="polishfilter[]" id="polishfilter1" value="{{ $item->polish_id }}" checked>
                                        <label class="form-check-label" for="polishfilter1">
                                            {{ $item->polish }}
                                        </label>
                                    </div>
                                @else
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="polishfilter[]" id="polishfilter1" value="{{ $item->polish_id }}">
                                        <label class="form-check-label" for="polishfilter1">
                                            {{ $item->polish }}
                                        </label>
                                    </div>
                                @endif
                                
                            @endforeach

                        </div>

                        <div class="my-3">
                            
                            <p class="h6 mx-1 fw-bold"> Collection :</p>
                            @foreach ($collections as $item)
                                
                                @if( $collectionfilter!='none' && in_array($item->collection_id, $collectionfilter))
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="collectionfilter[]" id="polishfilter1" value="{{ $item->collection_id }}" checked>
                                        <label class="form-check-label" for="polishfilter1">
                                            {{ $item->collection }}
                                        </label>
                                    </div>
                                @else
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="collectionfilter[]" id="polishfilter1" value="{{ $item->collection_id }}">
                                        <label class="form-check-label" for="polishfilter1">
                                            {{ $item->collection }}
                                        </label>
                                    </div>
                                @endif
                                
                            @endforeach

                        </div>

                        <div class="my-3">
                            
                            <p class="h6 mx-1 fw-bold"> Size :</p>
                            @foreach ($sizes as $item)
                                
                                @if( $sizefilter!='none' && in_array($item->size_id, $sizefilter))
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sizefilter[]" id="sizefilter1" value="{{ $item->size_id }}" checked>
                                        <label class="form-check-label" for="sizefilter1">
                                            {{ $item->size }}
                                        </label>
                                    </div>
                                @else
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sizefilter[]" id="sizefilter1" value="{{ $item->size_id }}">
                                        <label class="form-check-label" for="sizefilter1">
                                            {{ $item->size }}
                                        </label>
                                    </div>
                                @endif
                                
                            @endforeach

                        </div>
                        
                        <div class="my-3">
                            <p class="h6 mx-1 fw-bold"> Price :</p>

                                <div class="form-check">
                                    @if ($pricefilter == 'type1')
                                        <input class="form-check-input" type="radio" name="pricefilter" id="pricefilter1" value="type1" checked>
                                    @else
                                        <input class="form-check-input" type="radio" name="pricefilter" id="pricefilter1" value="type1">
                                    @endif
                                    <label class="form-check-label" for="pricefilter1">
                                    0 - 500
                                    </label>
                                </div>

                                <div class="form-check">
                                    @if ($pricefilter == 'type2')
                                        <input class="form-check-input" type="radio" name="pricefilter" id="pricefilter2" value="type2" checked>
                                    @else
                                        <input class="form-check-input" type="radio" name="pricefilter" id="pricefilter2" value="type2">
                                    @endif
                                    <label class="form-check-label" for="pricefilter2">
                                        0 - 1000
                                    </label>
                                </div>

                                <div class="form-check">
                                    @if ($pricefilter == 'type3')
                                        <input class="form-check-input" type="radio" name="pricefilter" id="pricefilter3" value="type3" checked>
                                    @else
                                        <input class="form-check-input" type="radio" name="pricefilter" id="pricefilter3" value="type3">
                                    @endif
                                    <label class="form-check-label" for="pricefilter3">
                                        0 - 2000
                                    </label>
                                </div>

                                <div class="form-check">
                                    @if ($pricefilter == 'type4')
                                        <input class="form-check-input" type="radio" name="pricefilter" id="pricefilter4" value="type4" checked>
                                    @else
                                        <input class="form-check-input" type="radio" name="pricefilter" id="pricefilter4" value="type4">
                                    @endif
                                    <label class="form-check-label" for="pricefilter4">
                                        0 - 3000
                                    </label>
                                </div>

                                <div class="form-check">
                                    @if ($pricefilter == 'type5')
                                        <input class="form-check-input" type="radio" name="pricefilter" id="pricefilter5" value="type5" checked>
                                    @else
                                        <input class="form-check-input" type="radio" name="pricefilter" id="pricefilter5" value="type5">
                                    @endif
                                    <label class="form-check-label" for="pricefilter5">
                                        0 - 5000
                                    </label>
                                </div>

                                <div class="form-check">
                                    @if ($pricefilter == 'type6')
                                    <input class="form-check-input" type="radio" name="pricefilter" id="pricefilter6" value="type6" checked>
                                    @else
                                        <input class="form-check-input" type="radio" name="pricefilter" id="pricefilter6" value="type6">
                                    @endif
                                    <label class="form-check-label" for="pricefilter6">
                                        0 - 5000+
                                    </label>
                                </div>

                        </div>

                        <div class="my-3">
                            <p class="h6 mx-1 fw-bold">Delivery Charges</p>

                              <div class="form-check">
                                  @if ($delcharges == 'both')
                                    <input class="form-check-input" type="radio" name="delcharges" id="delcharges1" value="both" checked>
                                  @else
                                    <input class="form-check-input" type="radio" name="delcharges" id="delcharges1" value="both">
                                  @endif
                                <label class="form-check-label" for="delcharges1">
                                    Both
                                </label>
                              </div>

                              <div class="form-check">
                                @if ($delcharges == 'on')
                                    <input class="form-check-input" type="radio" name="delcharges" id="delcharges2" value="on" checked>
                                @else
                                    <input class="form-check-input" type="radio" name="delcharges" id="delcharges2" value="on">
                                @endif
                                <label class="form-check-label" for="delcharges2">
                                  On
                                </label>
                              </div>

                              <div class="form-check">
                                @if ($delcharges == 'off')
                                    <input class="form-check-input" type="radio" name="delcharges" id="delcharges3" value="off" checked>
                                @else
                                    <input class="form-check-input" type="radio" name="delcharges" id="delcharges3" value="off">
                                @endif
                                <label class="form-check-label" for="delcharges3">
                                    Off
                                </label>
                              </div>
                        </div>

                    </div>
                    <div id="dismiss">
                        <button class="btn btn-dark"> Apply </button>
                    </div>
                </form>

            </nav>

            <!-- Page Content  -->
            <div id="content">
                <div class="container-fluid row">
                    <div class="col-5">
                        <button type="button" id="sidebarCollapse" class="btn btn-light border-dark">
                            <i class="fas fa-align-left"></i>
                            <span>Apply Filters</span>
                        </button>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="container">

            <div class="row">
                @if ($product_list->isEmpty())
                    <div class="text-center h6">
                        No Products Matched
                    </div>
                @else
                    @foreach ($product_list as $item)
                        <div class="col-12 col-md-6 col-lg-4">
                            @php $prodID= Crypt::encrypt($item->product_id); @endphp
                            <a href="/product/{{$prodID}}" class="text-decoration-none text-dark">
                                <div class="card border-0">
                                    <img src="{{ URL::asset('imageUploads/'.$item->coverimage->product_img) }}" class="card-img-top mx-auto img-fluid" alt="...">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $item->product_name }}</h6>
                                        <p class="card-text">
                                            &#8377; <span class="text-muted"><del>{{ intval(100 / ( 100 - $item->discount) * $item->price ) }}</del></span> {{ $item->price }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
                
                
        
            </div>

        </div>
        

    </div>

    <script type="text/javascript">
        
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss, .overlay').on('click', function () {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
        
    </script>

    <style>
        .card{
            margin: 10px;
        }
        

        @import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";


        p {
            font-family: 'Poppins', sans-serif;
            font-size: 1.1em;
            font-weight: 300;
            line-height: 1.7em;
        }

        a, a:hover, a:focus {
            color: inherit;
            text-decoration: none;
            transition: all 0.3s;
        }


        /* ---------------------------------------------------
            SIDEBAR STYLE
        ----------------------------------------------------- */

        #sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            height: 100vh;
            z-index: 999;
            background: white;
            color: black;
            transition: all 0.3s;
            overflow-y: scroll;
            box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.2);
        }

        #sidebar.active {
            left: 0;
        }

        #dismiss {
            width: 35px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            position: absolute;
            top: 10px;
            right: 45px;
            cursor: pointer;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }

        .overlay {
            display: none;
            position: fixed;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.7);
            z-index: 998;
            opacity: 0;
            transition: all 0.5s ease-in-out;
        }

        .overlay.active {
            display: block;
            opacity: 1;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: white;
        }

        #sidebar .components {
            padding: 20px;
            border-bottom: 1px solid #999;
        }

        .slider {
            -webkit-appearance: none;
            width: 100%;
            height: 25px;
            background: #d3d3d3;
            outline: none;
            opacity: 0.7;
            -webkit-transition: .2s;
            transition: opacity .2s;
        }

        .slider:hover {
            opacity: 1;
        }

        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 25px;
            height: 25px;
            background: #04AA6D;
            cursor: pointer;
        }

        .slider::-moz-range-thumb {
            width: 25px;
            height: 25px;
            background: #04AA6D;
            cursor: pointer;
        }
    </style>

@endsection
