<title>Jewellery Admin Edit Category</title>
@extends('admin.layout')

@section('content')

    <div class="container">
        <div class="bg-light rounded mt-3 p-4">
            <h6 class="mb-4">Edit Category</h6>
            <form class="w-50" method="POST" action="/adminpanel/editCategory" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category_id" value="{{$category->category_id}}">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Category Name" name="category_name" value="{{$category->category_name}}">
                    <label for="floatingInput">Catgeory Name</label>
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">Image</label>
                    <div class="my-1">
                        <img class="rounded" id="blah" src="{{ URL::asset('imageUploads/'.$category->category_img) }}" alt="your image">
                    </div>
                    <input class="form-control" type="file" id="formFile" name="category_image" onchange="readURL(this);">
                </div>
                
              	<div class="form-check form-switch mb-3">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Add to Homescreen</label>
                    @if ($category->homescreen == 1)
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="homescreen" checked>
                    @else
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="homescreen">
                    @endif
                </div>
              
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <style>
        img{
            max-width:150px;
        }
        input[type=file]{
            padding:10px;
            background:#2d2d2d;
        }
    </style>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection

