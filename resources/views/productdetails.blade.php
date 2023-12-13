@extends('layout')

@section('content')

<div class="container row my-5">

    <div class="col-12 col-md-6 col-lg-6">
      <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="true" data-bs-interval="false">
        <div class="carousel-inner">
          @php $i=0; @endphp
          @foreach ($product_detail->image as $item)
            @if ($item->delete_flag == 0)
              @php
                  $i++;
              @endphp
              @if ($i==1)
                <div class="carousel-item active">
                  <img class="img-fluid" src="{{ URL::asset('imageUploads/'.$item->product_img) }}">
                </div>
              @else
                <div class="carousel-item">
                  <img class="img-fluid" src="{{ URL::asset('imageUploads/'.$item->product_img) }}">
                </div>
              @endif
            @endif
          @endforeach
          
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      <div class="d-flex row px-5 py-2">
        @php $n=0; @endphp
        @foreach ($product_detail->image as $item)
          @if ($item->delete_flag == 0)
            <div class="col">
              <img class="img-thumbnail" style="max-height: 100px" src="{{ URL::asset('imageUploads/'.$item->product_img) }}" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide-to="{{$n}}" aria-label="Slide {{$n+1}}">
            </div>
            @php
                $n++;
            @endphp
          @endif
        @endforeach
      </div>

    </div>

    <div class="col-12 col-md-6 col-lg-6 pt-2">

        @php
          $prodID = Crypt::encrypt($product_detail->product_id);
        @endphp
        <input type="hidden" name="prodID" value="{{$prodID}}">
        <h2>{{ $product_detail->product_name }}</h2>
        <p class="my-2">&#8377; <span class="text-muted"><del>{{ intval(100 / ( 100 - $product_detail->discount) * $product_detail->price ) }}</del></span> {{ $product_detail->price }} <span class="text-light bg-secondary p-1">{{ $product_detail->discount }} % Off</span></p>
        

        {{------------- rating -------------}}
        <div class="my-3">
          <p>
            <span class="fw-bold">Rating :</span> 
            @php 
              $rating = App\Http\Controllers\allcontroller::getRating($product_detail->product_id);
            @endphp
            <span class="ms-2">
              @if ($rating == 5)
                  <span class="fa fa-star checked"></span>
                  <span class="fa fa-star checked"></span>
                  <span class="fa fa-star checked"></span>
                  <span class="fa fa-star checked"></span>
                  <span class="fa fa-star checked"></span>
              @elseif ($rating == 4)
                  <span class="fa fa-star checked"></span>
                  <span class="fa fa-star checked"></span>
                  <span class="fa fa-star checked"></span>
                  <span class="fa fa-star checked"></span>
                  <span class="fa fa-star"></span>
              @elseif ($rating == 3)
                  <span class="fa fa-star checked"></span>
                  <span class="fa fa-star checked"></span>
                  <span class="fa fa-star checked"></span>
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
              @elseif ($rating == 2)
                  <span class="fa fa-star checked"></span>
                  <span class="fa fa-star checked"></span>
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
              @elseif ($rating == 1)
                  <span class="fa fa-star checked"></span>
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
                  <span class="fa fa-star"></span>
              @else
                No Rating available
              @endif
            </span>
          </p>
          <p>{{ $product_detail->description }}</p>
        </div>

        
          <div class="row">
            @php
                $i = 0;
            @endphp
            @foreach ($product_types as $item)
              
            @if ($item->quantity > 0)
              <div class="col-12 col-sm-6 col-lg-4">
                @if ( $i == 0 )
                  <input type="radio" id="{{ $item->product_type_id }}" name="type_select" value="{{ $item->product_type_id }}" checked>
                @else
                  <input type="radio" id="{{ $item->product_type_id }}" name="type_select" value="{{ $item->product_type_id }}">
                @endif
                
                <label for="{{ $item->product_type_id }}">
                  <span class="fw-bold">{{ $item->getcolor->color }} + {{ $item->getpolish->polish }}</span>
                </label>
                @php
                  $i++;
                @endphp
              </div>
            @endif
            @endforeach
          </div>

          <div id="sizes" class="row">
            
          </div>

          @if ($quantity > 0)
          
            <div class="text-success pb-2"> Delivery By {{Date('d F', strtotime('+'.$product_detail->del_days_min.'days')) }} to {{Date('d F', strtotime('+'.$product_detail->del_days_max.'days')) }} </div>
            
            <button class="btn btn-default m-2" onclick="addtocart()">Add To Cart</button>
            <button class="btn btn-default-2 m-2" onclick="buynow()">Buy Now</button>
          @else
            <span class="alert alert-secondary my-2 text-center h5">Out Of Stock</span>
          @endif
          
    </div>
    
</div>

<style>
  /*  carousel      */
  @import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";


  p {
      font-family: 'Poppins', sans-serif;
      font-size: 1.1em;
      font-weight: 300;
      line-height: 1.7em;
  }

  input[type="radio"] {
    display: none;
    &:not(:disabled) ~ label {
      cursor: pointer;
    }
  }
  input[type="radio"] + label {
    display: block;
    background: white;
    color: #daa520;
    border: 2px solid #daa520;
    border-radius: 20px;
    padding: 8px 10px;
    margin-bottom: 1rem;
    text-align: center;
    box-shadow: 0px 3px 10px -2px #daa520;
    position: relative;
  }
  input[type="radio"]:checked + label {
    background: #daa520;
    color: hsla(215, 0%, 100%, 1);
    box-shadow: 0px 0px 20px rgba(218, 165, 32, 0.75);
    &::after {
      color: hsla(215, 5%, 25%, 1);
      font-family: FontAwesome;
      border: 2px solid #daa520;
      content: "\f00c";
      font-size: 24px;
      position: absolute;
      top: -25px;
      left: 50%;
      transform: translateX(-50%);
      height: 50px;
      width: 50px;
      line-height: 50px;
      text-align: center;
      border-radius: 50%;
      background: white;
      box-shadow: 0px 2px 5px -2px hsla(0, 0%, 0%, 0.25);
    }
  }

</style>

<script>
  $(document).ready(function(){
    getSizes();
    $("input[name='type_select']").change(function(){
      getSizes();
    });
    
  });

  function getSizes() {
    var type = $("input[name='type_select']:checked").val();
    $.ajax({
        type:'GET',
        url:'/getSize',
        data: {
          product_id : $("input[name='prodID']").val(),
          type_id : type },
        success:function(data) {
          $("#sizes").html(data.html);
        }
    });
  }

  function addtocart(prodID) {
    var prodID= $("input[name='prodID']").val();
    
    var typeID= $("input[name='type_select']:checked").val();
    var sizeID= $("input[name='size_select']:checked").val();
    if (sizeID !== undefined){
      var typeID = sizeID;
    }

    location.href ='/addtocart/'+prodID+'/'+typeID;
  }

  function buynow(prodID) {
    var prodID= $("input[name='prodID']").val();
    
    var typeID= $("input[name='type_select']:checked").val();
    var sizeID= $("input[name='size_select']:checked").val();
    if (sizeID !== undefined){
      var typeID = sizeID;
    }

    location.href = '/buynow/'+prodID+'/'+typeID;
  }
</script>
@endsection


