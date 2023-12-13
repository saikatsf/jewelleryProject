
@extends('layout')

@section('content')
    <div class="container h2 p-3 border-bottom">
        My Orders
    </div>
    <div class="container">
        @foreach ($myorders as $item)
            <div class="my-2 border border-2 rounded-3">
                <p class="p-2 m-0 bg-light rounded-top">
                    <span class="ps-2 fw-bold">Order No. </span>#{{$item->order_no}}
                </p>

                <div class="row p-3">
                    <div class="col-3">
                        <img src="{{ URL::asset('imageUploads/'.$item->product_detail->coverimage->product_img) }}" alt="" height="100px">
                    </div>
    
                    <div class="col-9 p-2">
                        <div class="row">
                            <div class="col-12 col-lg-9">
                                <span class="h4 fw-bold">
                                    {{ $item->product_detail->product_name }}
                                    ( {{$item->product_type_detail->getcolor->color}} + {{$item->product_type_detail->getpolish->polish}})
                                    @if ($item->product_type_detail->product_size != 0)
                                        ( Size : {{ $item->product_type_detail->getsize->size }} )
                                    @endif
                                </span>
    
                                @if ($item->order_status == 1)
                                    <div class="text-success"> Delivered </div>
                                @else
                                    <div class="text-success"> Delivery By {{ date('d F',strtotime($item->created_at.'+'.$item->product_detail->del_days_min.'days'))}} to {{ date('d F',strtotime($item->created_at.'+'.$item->product_detail->del_days_max.'days'))}}</div>
                                @endif
                            </div>
    
                            @if ($item->order_status == 1 && $item->review_status == 0)
                                <div class="col-12 col-lg-3 py-2">
                                    <a class="btn btn-default-2 rounded-pill" href="/review/{{Crypt::encrypt($item->orderDetail_id)}}"> Write a Review </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                
            </div>
        @endforeach

        <div class="text-center">
            @if ($myorders->isEmpty())
            <p class="alert p-3">
                <p class="h6">Your Have No Orders Yet</p>
                <a class="btn btn-default" href="/">Continue Shopping</a>
            </p>
            @endif
        </div>
        
    </div>
@endsection