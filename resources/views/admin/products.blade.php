<title>Jewellery Admin Products</title>
@extends('admin.layout')

@section('content')

<div class="container">
    <div class="rounded h-100 p-4">
        <div class="bg-light rounded p-3 row">
            <div class="h3 col-6">Products</div>
            <div class="col-6 text-end">
                <a href="/adminpanel/addproductpage" class="btn btn-success p-2">Add Product</a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover" id="products">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($products as $item)

                        <tr class="align-middle"> 
                            <th scope="row">{{ $i++; }}</th>

                            <td>
                                <img class="rounded" src="{{ URL::asset('/imageUploads/'.$item->coverimage->product_img) }}" alt="" style="width: 80px; height: 80px;">
                            </td>

                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->category->category_name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->discount }}</td>

                            <td>
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Action</a>
                                    <div class="dropdown-menu">
                                        <a href="/adminpanel/editProduct/{{$item->product_id}}" class="dropdown-item">Edit</a>
                                        <a href="/adminpanel/deleteProduct/{{$item->product_id}}" class="dropdown-item">Delete</a>
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
        $('#products').DataTable({
            searching: false
        });
    });
</script>
@endsection

