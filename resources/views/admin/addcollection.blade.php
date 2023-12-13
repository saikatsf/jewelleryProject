<title>Jewellery Admin Add Collection</title>
@extends('admin.layout')

@section('content')

    <div class="container">
        <div class="bg-light rounded mt-3 p-4">
            <h6 class="mb-4">Add New Collection</h6>
            <form class="w-75" method="POST" action="/adminpanel/addCollection">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Collection Name" name="collection">
                    <label for="floatingInput">Collection</label>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

