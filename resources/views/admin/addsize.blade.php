<title>Jewellery Admin Add Size</title>
@extends('admin.layout')

@section('content')

    <div class="container">
        <div class="bg-light rounded mt-3 p-4">
            <h6 class="mb-4">Add New Size</h6>
            <form class="w-75" method="POST" action="/adminpanel/addSize">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Sizee" name="size">
                    <label for="floatingInput">Size</label>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

