<title>Jewellery Admin Add Category</title>
@extends('admin.layout')

@section('content')

    <div class="container">
        <div class="bg-light rounded mt-3 p-4">
            <h6 class="mb-4">Add New Category</h6>
            <form class="w-50" method="POST" action="/adminpanel/addCategory" enctype="multipart/form-data">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Category Name" name="category_name">
                    <label for="floatingInput">Catgeory Name</label>
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">Image</label>
                    <input class="form-control" type="file" id="formFile" name="category_image">
                </div>
                
              	<div class="form-check form-switch mb-3">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Add to Homescreen</label>
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="homescreen">
                </div>
              
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

@endsection

