<title>Jewellery Admin Order Details</title>
@extends('admin.layout')

@section('content')

<div class="container">
    <div class="rounded h-100 p-4">
        <div class="bg-light rounded p-3 row">
            <div class="h3 col-6">Orders</div>
            <div class="col-6 text-end">
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover" id="orderdetails">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product Image</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Quanity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($orderdetails as $item)
                        
                        <tr class="align-middle"> 
                            <th scope="row">{{ $i++; }}</th>
                            <td>
                                <img class="rounded" src="{{ URL::asset('/imageUploads/'.$item->product_detail->coverimage->product_img) }}" alt="" style="width: 80px; height: 80px;">
                            </td>
                            <td>
                                {{ $item->product_detail->product_name }}
                                ( {{$item->product_type_detail->getcolor->color}} + {{$item->product_type_detail->getpolish->polish}})
                                @if ($item->product_type_detail->product_size != 'NA')
                                    ( Size : {{ $item->product_type_detail->product_size }} )
                                @endif
                            </td>
                            <td>{{$item->quantity}}</td>
                            <td>&#8377; {{$item->price}}</td>
                            <td>
                                @if ($item->order_status == 1)
                                    Delivered
                                @else
                                    Pending
                                @endif
                                <a href="/changeorderstatus/{{$item->orderDetail_id}}" class="btn btn-secondary p-2">Change</a>
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#orderdetails').DataTable({
            searching: false
        });
    });
</script>
@endsection

