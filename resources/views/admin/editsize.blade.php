<title>Jewellery Admin Edit Size</title>
@extends('admin.layout')

@section('content')

    <div class="container">
        <div class="bg-light rounded mt-3 p-4">
            <h6 class="mb-4">Edit Size</h6>
            <form class="w-50" method="POST" action="/adminpanel/editSize">
                @csrf
                <input type="hidden" name="size_id" value="{{$size->size_id}}">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Size" name="size" value="{{$size->size}}">
                    <label for="floatingInput">Size</label>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    
@endsection

