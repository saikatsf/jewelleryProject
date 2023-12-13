<title>Jewellery Admin Categories</title>
@extends('admin.layout')

@section('content')

<div class="container">
    <div class="rounded h-100 p-4">
        <div class="bg-light rounded p-3 row">
            <div class="h3 col-6">Categories</div>
            <div class="col-6 text-end">
                <a href="/adminpanel/addcategorypage" class="btn btn-success p-2">Add Category</a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover" id="categories">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($categories as $item)

                        <tr class="align-middle"> 
                            <th scope="row">{{ $i++; }}</th>

                            <td>
                                <img class="rounded" src="{{ URL::asset('/imageUploads/'.$item->category_img) }}" alt="" style="width: 80px; height: 80px;">
                            </td>

                            <td>{{ $item->category_name }}</td>

                            <td>
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Action</a>
                                    <div class="dropdown-menu">
                                        <a href="/adminpanel/editCategory/{{$item->category_id}}" class="dropdown-item">Edit</a>
                                        <a href="/adminpanel/deleteCategory/{{$item->category_id}}" class="dropdown-item">Delete</a>
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
        $('#categories').DataTable({
            searching: false
        });
    });
    
</script>
@endsection

