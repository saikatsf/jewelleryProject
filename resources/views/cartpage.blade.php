@extends('layout')

@section('content')

    <div class="container py-5">

        @foreach ($cart_list as $item)
            @php
                $prodId = Crypt::encrypt($item['product_id']);
                $typeId = $item['product_type_id'];
            @endphp 
            <div class="row">
                <div class="col-3">
                    <img class="img-fluid img-thumbnail" src="{{ URL::asset('imageUploads/'.$item['image']) }}" alt="">
                </div>
                <div class="col-9">
                    <p class="h4 fw-bold">
                        {{ $item['name'] }} ( {{ $item['product_type_name'] }} )
                        @if ($item['product_size'] != 0)
                        ( Size : {{ $item['product_size'] }} )
                        @endif
                    </p>
                    @if (  $item['stock'] > 0 )
                        <p class="h5 my-2">&#8377; {{ $item['price'] * $item['quantity'] }} <span class="text-muted"><del>&#8377; {{ $item['mrp'] * $item['quantity'] }}</del></span> </p>
                    @else
                        <br>
                        <span class="alert alert-secondary my-2 text-center h5">Out Of Stock</span>
                        @php session()->put('outofstock',1); @endphp
                    @endif

                    <div class="row">

                        <div class="col-6 col-lg-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary fw-bold decrease_cart" type="button" id="button-addon1" data-prodid="{{ $prodId }}" data-typeid="{{ $typeId }}">-</button>
                                </div>
                                
                                    <input type="text" class="form-control text-center fw-bold cart_qty" aria-describedby="button-addon1" value="{{ $item['quantity'] }}">
            
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary fw-bold increase_cart" type="button" id="button-addon2" data-prodid="{{ $prodId }}" data-typeid="{{ $typeId }}">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-9">
                            <a class="btn btn-default" href="/removecart/{{ $prodId }}/{{ $typeId }}">
                                Remove
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <hr>
        @endforeach
            
        
        <div class="text-center">
            @if (empty($cart_list))
            <p class="alert p-3">
                <p class="h6">Your Cart is Empty</p>
                <a class="btn btn-default" href="/">Continue Shopping</a>
            </p>
            @elseif (session()->has('outofstock'))
                <p class="alert alert-danger h5  my-5">Kindly Remove Out of Stock Products</p>
            @else
            <a class="btn btn-default-2" href="/checkout">
                Checkout
            </a>
            @endif
            
        </div>
    </div>
    <script>
        

         $(".increase_cart").click(function (e) {
            e.preventDefault();
    
            var prodID = $(this).attr('data-prodid');
            var typeID = $(this).attr('data-typeid');
            var _url = '/increasecart/'+prodID+'/'+typeID;

            $.ajax({
                url: _url,
                method: "GET",
                
                success: function (response) {
                    window.location.reload();
                }
            });
        });

        $(".decrease_cart").click(function (e) {
            e.preventDefault();
            
            var prodID = $(this).attr('data-prodid');
            var typeID = $(this).attr('data-typeid');
            var _url = '/decreasecart/'+prodID+'/'+typeID;

            $.ajax({
                url: _url,
                method: "GET",
                
                success: function (response) {
                    window.location.reload();
                }
            });
        });
    </script>


@endsection