@extends('layout')

@section('content')

    <div class="row container-fluid my-5">

        <div class="col-12 col-lg-8 bg-light p-2">
            <form method="post" action="/checkoutorder">
                @csrf
                <input type="hidden" value="{{ Crypt::encrypt($directorder['product_id']) }}" name="directorder_id">
                <input type="hidden" value="{{ Crypt::encrypt($directorder['product_type_id']) }}" name="directorder_type_id">
                
                <input type="hidden" value="{{ $discount_amt }}" name="discount_amt">
                <p class="h5 p-2">Address Information</p> 
                <div class="row g-2 mb-3">
                    <div class="col-md">
                        <div class="form-floating ">
                            <input type="text" class="form-control" id="floatingInput1" placeholder="name" name="user_name" required>
                            <label for="floatingInput1">Name</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput2" placeholder="10 digit mobile no" name="user_mobile" required>
                            <label for="floatingInput2">Mobile Number</label>
                        </div>
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <textarea type="text" class="form-control" id="floatingTextarea" placeholder="address" style="height: 80px" name="user_address" required></textarea>
                    <label for="floatingTextarea">Address</label>
                </div>

                <div class="row g-2 mb-3">
                    
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInput3" placeholder="state" name="user_landmark" required>
                            <label for="floatingInput3">Landmark</label>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="address_pin" placeholder="city" name="user_pin" required>
                            <label for="floatingInput">PIN</label>
                        </div>
                    </div>
                    
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md">
                        <div class="form-floating ">
                            <input type="text" class="form-control" id="address_city" placeholder="city" name="user_city" required>
                            <label for="floatingInput">City</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="address_state" placeholder="state" name="user_state" required>
                            <label for="floatingInput">State</label>
                        </div>
                    </div>
                </div>


                {{-- 
                    <p class="h5 p-2">Payment Information</p>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payment_mode" id="inlineRadio1" value="1">
                        <label class="form-check-label" for="inlineRadio1">Cash On Delivery</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payment_mode" id="inlineRadio2" value="2">
                        <label class="form-check-label" for="inlineRadio2">Razorpay</label>
                    </div>
                --}}

                <input type="hidden" name="payment_mode" value="2">
                <div class="mt-5 mx-2 text-center">
                    <button class="btn btn-default btn-lg" type="submit">Place Order</button>
                </div>
            </form>
        </div>

        <div class="col-12 col-lg-4 bg-light p-2">
            <p class="h5">Your Orders</p>
                
                @if ($directorder['product_id'] != 0)
                    @foreach ($products as $item)
                        <div class="row p-2">
                            <div class="col">
                                <img src="{{ URL::asset('imageUploads/'.$item->coverimage->product_img) }}" alt="" height="50px">
                            </div>
                            <div class="col">
                                {{$item->product_name}} {{$directorder['product_type_name']}}
                            </div>
                            <div class="col">
                                {{ $item->price }}.00
                            </div>
                        </div>
                    @endforeach

                    @if ($item->delivery_charges == 1)
                        @php $delivery_charge = 80; @endphp
                    @else
                        @php $delivery_charge = 0; @endphp
                    @endif
                    @php
                        $totalPrice = $item->price;
                    @endphp
                    <p class="h5">Net Amount : &#8377; {{ $totalPrice }}.00</p>
                    <p class="h5">Discount : &#8377; {{ intval($totalPrice * $discount_amt / 100) }}.00</p>
                    <p class="h5">Delivery Charge : &#8377; {{ $delivery_charge }}.00</p>
                    <p class="h5">Total Amount : &#8377; {{ $totalPrice - intval($totalPrice * $discount_amt / 100) + $delivery_charge }}.00</p>
                    
                @else
                    @php
                        $totalPrice = 0;
                        $delivery_charge = 80;
                    @endphp
                    @foreach ($products as $item)
                        <div class="row p-2">
                            <div class="col">
                                <img class="img-fluid img-thumbnail" src="{{ URL::asset('imageUploads/'.$item->product_detail->coverimage->product_img) }}" alt="">
                            </div>
                            <div class="col">
                                {{$item->product_detail->product_name}}
                                ( {{$item->product_type_detail->getcolor->color}} + {{$item->product_type_detail->getpolish->polish}})
                                @if ($item->product_type_detail->product_size != 0)
                                    ( Size : {{ $item->product_type_detail->getsize->size }} )
                                @endif
                            </div>
                            <div class="col">
                                &#8377; {{ $item->product_detail->price * $item->quantity }}
                            </div>
                        </div>
                        @php
                            $totalPrice = $totalPrice + ($item->product_detail->price * $item->quantity);
                        @endphp

                        @if ( $item->product_detail->delivery_charges == 0)
                            @php $delivery_charge = 0; @endphp
                        @endif

                    @endforeach
                    <p class="h5">Net Amount : &#8377; {{ $totalPrice }}.00</p>
                    <p class="h5">Discount : &#8377; {{ intval($totalPrice * $discount_amt / 100) }}.00</p>
                    <p class="h5">Delivery Charge : &#8377; {{ $delivery_charge }}.00</p>
                    <p class="h5">Total Amount : &#8377; {{ $totalPrice - intval($totalPrice * $discount_amt / 100) + $delivery_charge }}.00</p>
                @endif

                <div class="newslatter-item pt-3">
                    <p class="h5">Apply Coupon Code</p>
                    <form action="/checkout" method="get">
                        <input type="hidden" name="directorder_id" value="{{Crypt::encrypt($directorder['product_id'])}}"/>
                        <input type="hidden" name="type_id" value="{{$directorder['product_type_id']}}"/>
                        <input type="text" class="form-control" name="coupon_code"/>
                        <button type="submit" class="btn btn-default my-2">Apply</button>
                    </form>
                </div>
            
        </div>

    </div>

    <script>
        $(document).ready(function(){
            $('#address_pin').keyup(function(){
                var pin = $('#address_pin').val();
                if(pin.length == 6){

                    var _url = '/getaddress/'+pin;
                    $.ajax({
                        url: _url,
                        method: "GET",
                        
                        success: function (response) {
                            if (response == "none") {
                                $('#address_city').val('');
                                $('#address_state').val('');
                            }else{
                                var getData = $.parseJSON(response);
                                $('#address_city').val(getData.city);
                                $('#address_state').val(getData.state);
                            }
                        }
                    });
                }
                else{
                    $('#address_city').val('');
                    $('#address_state').val('');
                }
            });
        });
    </script>

    
@endsection