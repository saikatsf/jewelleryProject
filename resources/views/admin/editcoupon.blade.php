<title>Jewellery Admin Edit Coupon</title>
@extends('admin.layout')

@section('content')

    <div class="container">
        <div class="bg-light rounded mt-3 p-4">
            <h6 class="mb-4">Edit Coupon</h6>
            <form class="w-50" method="POST" action="/adminpanel/editCoupon">
                @csrf
                <input type="hidden" name="coupon_id" value="{{$coupon->coupon_id}}">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Coupon Code" name="coupon_code" value="{{$coupon->coupon_code}}">
                    <label for="floatingInput">Coupon Code</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Discount" name="discount" value="{{$coupon->discount}}">
                    <label for="floatingInput">Discount ( % )</label>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    
@endsection

