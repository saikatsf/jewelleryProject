<title>Jewellery Admin Add Color</title>
@extends('admin.layout')

@section('content')

    <div class="container">
        <div class="bg-light rounded mt-3 p-4">
            <h6 class="mb-4">Add New Color</h6>
            <form class="w-75" method="POST" action="/adminpanel/addColor">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Color Name" name="color">
                    <label for="floatingInput">Color</label>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

