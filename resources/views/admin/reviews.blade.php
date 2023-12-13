<title>Jewellery Admin Reviews</title>
@extends('admin.layout')

@section('content')

<div class="container">
    <div class="rounded h-100 p-4">
        <div class="bg-light rounded p-3 row">
            <div class="h3 col-6">Reviews</div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover" id="coupons">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Review Image</th>
                        <th scope="col">Review</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($reviews as $item)
                        
                        <tr class="align-middle"> 
                            <th scope="row">{{ $i++; }}</th>
                            <td class="w-25">{{$item->product_detail->product_name}}</td>
                            <td>
                                <img class="rounded" src="{{ URL::asset('/imageUploads/'.$item->coverimage->review_img) }}" alt="" style="width: 80px; height: 80px;">
                            </td>
                            <td>{{$item->review}}</td>
                            <td>
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
                            </td>
                            <td>
                                @if ($item->approved == 0)
                                    Not Approved
                                @else
                                    Approved
                                @endif
                                <a href="/changeapprovalstatus/{{$item->review_id}}" class="btn btn-secondary p-2">Change</a>
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    .checked {
    color: orange;
  }
</style>
<script>
    $(document).ready(function() {
        $('#coupons').DataTable({
            searching: false
        });
    });
</script>
@endsection

