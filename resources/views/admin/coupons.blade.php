<title>Jewellery Admin Coupons</title>
@extends('admin.layout')

@section('content')

<div class="container">
    <div class="rounded h-100 p-4">
        <div class="bg-light rounded p-3 row">
            <div class="h3 col-6">Coupons</div>
            <div class="col-6 text-end">
                <a href="/adminpanel/addcouponpage" class="btn btn-success p-2">Add Coupon</a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover" id="coupons">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Code</th>
                        <th scope="col">Discount(%)</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($coupons as $item)
                        
                        <tr class="align-middle"> 
                            <th scope="row">{{ $i++; }}</th>
                            <td>{{$item->coupon_code}}</td>
                            <td>{{$item->discount}}</td>
                            <td>
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Action</a>
                                    <div class="dropdown-menu">
                                        <a href="/adminpanel/editCoupon/{{$item->coupon_id}}" class="dropdown-item">Edit</a>
                                        <a href="/adminpanel/deleteCoupon/{{$item->coupon_id}}" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
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
        $('#coupons').DataTable({
            searching: false
        });
    });
</script>
@endsection

