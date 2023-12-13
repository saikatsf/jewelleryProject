<title>Jewellery Admin Orders</title>
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
            <table class="table table-hover" id="orders">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                            <th scope="col">Order No.</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Tracking Id</th>
                            <th scope="col">Bank Ref No.</th>
                            <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($orders as $item)
                        
                        <tr class="align-middle"> 
                            <th scope="row">{{ $i++; }}</th>

                            <td>{{ date('Y-m-d', strtotime($item->created_at)); }}</td>
                            <td>{{$item->order_no}}</td>
                            <td>{{$item->name}}</td>
                            <td>&#8377; {{$item->price}}</td>
                            <td>{{$item->tracking_id}}</td>
                            <td>{{$item->bank_ref_no}}</td>
                            <td><a class="btn btn-sm btn-primary" href="/adminpanel/orderdetail/{{$item->order_no}}">Detail</a></td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#orders').DataTable({
            searching: false
        });
    });
</script>
@endsection

